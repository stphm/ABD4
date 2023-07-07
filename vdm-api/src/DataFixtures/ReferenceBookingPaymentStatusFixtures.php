<?php

namespace App\DataFixtures;

use App\Entity\ReferenceBookingPaymentStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReferenceBookingPaymentStatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $label) {
            $referenceBookingPaymentStatus = new ReferenceBookingPaymentStatus();
            $referenceBookingPaymentStatus->setLabel($label);

            $manager->persist($referenceBookingPaymentStatus);
        }
        $manager->flush();
    }

    private function getData(): \Generator
    {
        yield ReferenceBookingPaymentStatus::STATUS_PENDING;

        yield ReferenceBookingPaymentStatus::STATUS_VALIDATED;

        yield ReferenceBookingPaymentStatus::STATUS_REFUSED;
    }
}
