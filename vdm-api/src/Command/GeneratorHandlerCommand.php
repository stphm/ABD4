<?php

namespace App\Command;

use App\Entity\Booking;
use App\Entity\BookingPayment;
use App\Entity\BookingTicket;
use App\Entity\GameRoom;
use App\Entity\GameRoomSession;
use App\Entity\ReferenceBookingPaymentStatus;
use App\Entity\ReferenceBookingStatus;
use App\Entity\ReferenceBookingTicketPricing;
use App\Entity\ReferenceGameRoomTheme;
use App\Entity\ReferencePeopleCivility;
use App\Entity\User;
use App\Event\BookingConfirmedEvent;
use App\Repository\GameRoomRepository;
use App\Repository\ReferenceBookingPaymentStatusRepository;
use App\Repository\ReferenceBookingStatusRepository;
use App\Repository\ReferenceBookingTicketPricingRepository;
use App\Repository\ReferenceGameRoomThemeRepository;
use App\Repository\ReferencePeopleCivilityRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'traffic:generator:handler',
    description: 'Add a short description for your command',
)]
class GeneratorHandlerCommand extends Command
{
    private readonly UserRepository $userRepository;
    private readonly ReferenceBookingTicketPricingRepository $refTicketPricingRepository;
    private readonly ReferenceBookingPaymentStatusRepository $refBookingPaymentStatusRepository;
    private readonly ReferenceBookingStatusRepository $refBookingStatusRepository;
    private readonly ReferenceGameRoomThemeRepository $refGameRoomThemeRepository;
    private readonly GameRoomRepository $gameRoomRepository;
    private readonly ReferencePeopleCivilityRepository $refPeopleCivilityRepository;

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly EntityManagerInterface $em
    ) {
        parent::__construct();
        $this->userRepository = $em->getRepository(User::class);
        $this->refTicketPricingRepository = $em->getRepository(ReferenceBookingTicketPricing::class);
        $this->refBookingPaymentStatusRepository = $em->getRepository(ReferenceBookingPaymentStatus::class);
        $this->refBookingStatusRepository = $em->getRepository(ReferenceBookingStatus::class);
        $this->refGameRoomThemeRepository = $em->getRepository(ReferenceGameRoomTheme::class);
        $this->gameRoomRepository = $em->getRepository(GameRoom::class);
        $this->refPeopleCivilityRepository = $em->getRepository(ReferencePeopleCivility::class);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // decode json from input stream
        $file = fopen('php://stdin', 'r');
        while (!feof($file)) {
            try {
                $json = json_decode(fgets($file), true, flags: JSON_THROW_ON_ERROR);

                if (null === $buyer = $this->userRepository->findOneBy(['email' => $json['Acheteur']['Email']])) {
                    $buyerCivility = $this->refPeopleCivilityRepository->findOneBy([
                        'label' => $this->getRefPeopleCivilityFromString($json['Acheteur']['Civilite']),
                    ]);
                    // create new user
                    $buyer = (new User())
                        ->setEmail($json['Acheteur']['Email'])
                        ->setFirstName($json['Acheteur']['Prenom'])
                        ->setLastName($json['Acheteur']['Nom'])
                        ->setRoles(['ROLE_USER'])
                        ->setPassword('password')
                        ->setCivility($buyerCivility)
                        ->setAge($json['Acheteur']['Age'])
                    ;
                    $buyer->setPassword($this->userPasswordHasher->hashPassword($buyer, $buyer->getPassword()));

                    $this->em->persist($buyer);
                }

                // create booking
                if (null === $refGameRoomTheme = $this->refGameRoomThemeRepository->findOneBy(['label' => $json['Game']['Nom']])) {
                    $refGameRoomTheme = (new ReferenceGameRoomTheme())
                        ->setLabel($json['Game']['Nom'])
                    ;
                    $this->em->persist($refGameRoomTheme);
                }

                if (null === $gameRoom = $this->gameRoomRepository->findOneBy(['theme' => $refGameRoomTheme])) {
                    $gameRoom = (new GameRoom())
                        ->setTheme($refGameRoomTheme)
                        ->setIsVr($json['Game']['VR'])
                    ;
                    $this->em->persist($gameRoom);
                }

                $sessionStartAt = new \DateTimeImmutable("{$json['Game']['Jour']} {$json['Game']['Horaire']}");
                $gameRoomSession = (new GameRoomSession())
                    ->setRoom($gameRoom)
                    ->setStartAt($sessionStartAt)
                    ->setEndAt($sessionStartAt->modify("+{$gameRoom->getDuration()} minutes"))
                ;
                $this->em->persist($gameRoomSession);

                $refBookingStatus = $this->refBookingStatusRepository->findOneBy([
                    'label' => ReferenceBookingPaymentStatus::STATUS_VALIDATED,
                ]);
                $booking = (new Booking())
                    ->setStatus($refBookingStatus)
                    ->setCustomer($buyer)
                    ->setSession($gameRoomSession)
                ;
                $totalPrice = 0.0;
                $ticketsCount = 0;
                foreach ($json['Reservation'] as $rawDataTicket) {
                    $referencePrice = $this->refTicketPricingRepository->findOneBy([
                        'label' => $this->getRefPriceLabelFromString($rawDataTicket['Tarif']),
                    ]);
                    $bookingTicket = (new BookingTicket())
                        ->setBooking($booking)
                        ->setReferencePricing($referencePrice)
                        ->setPrice($referencePrice->getCurrentValue())
                    ;

                    $ownerCivility = $this->refPeopleCivilityRepository->findOneBy([
                        'label' => $this->getRefPeopleCivilityFromString($rawDataTicket['Spectateur']['Civilite']),
                    ]);
                    // check if the ticket's owner civility, first name, last name and age are the same as the buyer
                    if ($rawDataTicket['Spectateur']['Nom'] === $buyer->getLastName()
                        && $rawDataTicket['Spectateur']['Prenom'] === $buyer->getFirstName()
                        && $rawDataTicket['Spectateur']['Age'] === $buyer->getAge()
                        && $ownerCivility->getId() === $buyer->getCivility()->getId()
                    ) {
                        $bookingTicket->setOwner($buyer);
                    } else {
                        $bookingTicket->setOwnerCivility($ownerCivility);
                        $bookingTicket->setOwnerFirstName($rawDataTicket['Spectateur']['Prenom']);
                        $bookingTicket->setOwnerLastName($rawDataTicket['Spectateur']['Nom']);
                        $bookingTicket->setOwnerAge($rawDataTicket['Spectateur']['Age']);
                    }

                    $totalPrice += $referencePrice->getCurrentValue();
                    ++$ticketsCount;

                    $this->em->persist($bookingTicket);
                }

                $refStatusPayment = $this->refBookingPaymentStatusRepository->findOneBy([
                    'label' => ReferenceBookingPaymentStatus::STATUS_VALIDATED,
                ]);
                $payment = (new BookingPayment())
                    ->setStatus($refStatusPayment)
                    ->setValue($totalPrice)
                    ->setValidatedAt(new \DateTimeImmutable())
                ;
                $this->em->persist($payment);
                $booking->setPayment($payment);
                $this->em->persist($booking);

                $this->em->flush();
                $io->success('Booking created for user '.$buyer->getEmail().' with '.$ticketsCount.' tickets');

                $this->eventDispatcher->dispatch(new BookingConfirmedEvent($booking->getId()));

                // clear entity manager to avoid memory leak
                $this->em->clear();
            } catch (\Exception $e) {
                $io->error($e->getMessage());

                continue;
            }
        }

        return Command::SUCCESS;
    }

    private function getRefPriceLabelFromString(string $value): string
    {
        return match ($value) {
            'Plein tarif' => ReferenceBookingTicketPricing::PRICING_FULL,
            'Tarif etudiant' => ReferenceBookingTicketPricing::PRICING_STUDENT,
            'Tarif reduit' => ReferenceBookingTicketPricing::PRICING_REDUCED,
            default => ReferenceBookingTicketPricing::PRICING_SENIOR,
        };
    }

    private function getRefPeopleCivilityFromString(string $value): string
    {
        return match (strtolower($value)) {
            'monsieur' => ReferencePeopleCivility::CIVILITY_MISTER,
            'madame' => ReferencePeopleCivility::CIVILITY_MADAM,
            default => ReferencePeopleCivility::CIVILITY_OTHER
        };
    }
}
