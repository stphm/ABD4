<?php

namespace App\DataFixtures;

use App\Entity\ReferenceBookingTicketPricing;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReferenceBookingTicketPricingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as [$label, $price]) {
            $referenceBookingPaymentStatus = (new ReferenceBookingTicketPricing())
                ->setLabel($label)
                ->setCurrentValue($price)
            ;

            $manager->persist($referenceBookingPaymentStatus);
        }
        $manager->flush();
    }

    private function getData(): \Generator
    {
        yield [ReferenceBookingTicketPricing::PRICING_STUDENT, 6.80];

        yield [ReferenceBookingTicketPricing::PRICING_SENIOR, 6.80];

        yield [ReferenceBookingTicketPricing::PRICING_REDUCED, 7.40];

        yield [ReferenceBookingTicketPricing::PRICING_FULL, 9.40];
    }
}
