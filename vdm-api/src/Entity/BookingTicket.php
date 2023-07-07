<?php

namespace App\Entity;

use App\Repository\BookingTicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingTicketRepository::class)]
class BookingTicket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tickets', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private Booking $booking;

    #[ORM\ManyToOne(fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ReferenceBookingTicketPricing $referencePricing;

    #[ORM\Column]
    private float $price = 0.0;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $owner = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ownerFirstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ownerLastName = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(name: 'id_ref_owner_civility', nullable: true)]
    private ?ReferencePeopleCivility $ownerCivility = null;

    #[ORM\Column(nullable: true)]
    private ?int $ownerAge = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooking(): Booking
    {
        return $this->booking;
    }

    public function setBooking(Booking $booking): self
    {
        $this->booking = $booking;

        return $this;
    }

    public function getReferencePricing(): ReferenceBookingTicketPricing
    {
        return $this->referencePricing;
    }

    public function setReferencePricing(ReferenceBookingTicketPricing $referencePricing): self
    {
        $this->referencePricing = $referencePricing;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getOwnerFirstName(): ?string
    {
        return $this->ownerFirstName;
    }

    public function setOwnerFirstName(string $ownerFirstName): self
    {
        $this->ownerFirstName = $ownerFirstName;

        return $this;
    }

    public function getOwnerLastName(): ?string
    {
        return $this->ownerLastName;
    }

    public function setOwnerLastName(string $ownerLastName): self
    {
        $this->ownerLastName = $ownerLastName;

        return $this;
    }

    public function getOwnerCivility(): ?ReferencePeopleCivility
    {
        return $this->ownerCivility;
    }

    public function setOwnerCivility(?ReferencePeopleCivility $ownerCivility): self
    {
        $this->ownerCivility = $ownerCivility;

        return $this;
    }

    public function getOwnerAge(): ?int
    {
        return $this->ownerAge;
    }

    public function setOwnerAge(?int $ownerAge): self
    {
        $this->ownerAge = $ownerAge;

        return $this;
    }
}
