<?php

namespace App\DataFixtures;

use App\Entity\ReferencePeopleCivility;
use App\Entity\User;
use App\Repository\ReferencePeopleCivilityRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly ReferencePeopleCivilityRepository $refPeopleCivilityRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $user) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ReferencePeopleCivilityFixtures::class,
        ];
    }

    private function getData(): \Generator
    {
        $refMr = $this->refPeopleCivilityRepository->findOneBy(['label' => ReferencePeopleCivility::CIVILITY_MISTER]);
        $refMrs = $this->refPeopleCivilityRepository->findOneBy(['label' => ReferencePeopleCivility::CIVILITY_MADAM]);

        yield (new User())->setEmail('user@gmail.com')
            ->setPassword('password')
            ->setRoles(['ROLE_USER'])
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setCivility($refMr)
            ->setAge(18)
        ;

        yield (new User())->setEmail('admin@gmail.com')
            ->setPassword('password')
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Jane')
            ->setLastName('Doe')
            ->setCivility($refMrs)
            ->setAge(18)
        ;
    }
}
