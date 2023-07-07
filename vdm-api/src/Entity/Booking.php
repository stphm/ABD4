<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\Table(name: 'booking')]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'id_ref_status', nullable: false)]
    private ReferenceBookingStatus $status;

    #[ORM\ManyToOne(fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    private ?BookingPayment $payment = null;

    #[ORM\ManyToOne(fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private User $customer;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    #[ORM\OneToMany(
        mappedBy: 'booking',
        targetEntity: BookingTicket::class,
        orphanRemoval: true,
        cascade: ['persist', 'remove'],
        fetch: 'EAGER'
    )]
    private Collection $tickets;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private GameRoomSession $session;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ReferenceBookingStatus
    {
        return $this->status;
    }

    public function setStatus(ReferenceBookingStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPayment(): ?BookingPayment
    {
        return $this->payment;
    }

    public function setPayment(?BookingPayment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getCustomer(): User
    {
        return $this->customer;
    }

    public function setCustomer(User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, BookingTicket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function getSession(): GameRoomSession
    {
        return $this->session;
    }

    public function setSession(GameRoomSession $session): self
    {
        $this->session = $session;

        return $this;
    }
}
