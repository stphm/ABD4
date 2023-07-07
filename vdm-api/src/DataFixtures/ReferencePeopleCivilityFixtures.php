<?php

namespace App\DataFixtures;

use App\Entity\ReferencePeopleCivility;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReferencePeopleCivilityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $label) {
            $referenceBookingPaymentStatus = new ReferencePeopleCivility();
            $referenceBookingPaymentStatus->setLabel($label);

            $manager->persist($referenceBookingPaymentStatus);
        }
        $manager->flush();
    }

    private function getData(): \Generator
    {
        yield ReferencePeopleCivility::CIVILITY_MISTER;

        yield ReferencePeopleCivility::CIVILITY_MADAM;

        yield ReferencePeopleCivility::CIVILITY_OTHER;
    }
}
