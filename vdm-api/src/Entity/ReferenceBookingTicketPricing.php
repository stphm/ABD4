<?php

namespace App\Entity;

use App\Repository\ReferenceBookingTicketPricingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferenceBookingTicketPricingRepository::class)]
#[ORM\Table(name: 'reference_booking_ticket_pricing')]
class ReferenceBookingTicketPricing
{
    public const PRICING_STUDENT = 'student';
    public const PRICING_REDUCED = 'reduced';
    public const PRICING_SENIOR = 'senior';
    public const PRICING_FULL = 'full';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $label;

    #[ORM\Column]
    private float $currentValue = 0.0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getCurrentValue(): float
    {
        return $this->currentValue;
    }

    public function setCurrentValue(float $currentValue): self
    {
        $this->currentValue = $currentValue;

        return $this;
    }
}
