<?php

namespace App\Event;

final class BookingConfirmedEvent
{
    public function __construct(private readonly int $bookingId)
    {
    }

    public function getBookingId(): int
    {
        return $this->bookingId;
    }
}
