<?php

namespace App\DataFixtures;

use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SiteFixtures extends Fixture
{

    public const SITE_REFERENCE1 ='site1';
    public const SITE_REFERENCE2 ='site2';



    public function load(ObjectManager $objectManager)
    {
        $site = new Site();

        $site->setNom("Quimper");
        $site->setId(1);

        $objectManager->persist($site);
        $objectManager->flush();

        $this->addReference(self::SITE_REFERENCE1,$site);




        $site2 = new Site();
        $site2->setNom("Nantes");
        $site2->setId(2);

        $objectManager->persist($site2);
        $objectManager->flush();

        $this->addReference(self::SITE_REFERENCE2,$site2);

    }
}