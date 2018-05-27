<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Departement;
use AppBundle\Entity\Region;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadEmbededFiledsData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $region1 = new Region();
        $region1->setName('Nord');
        $region1->setCode(01);
        $region2 = new Region();
        $region2->setName('Sud');
        $region2->setCode(02);
        $region3 = new Region();
        $region3->setName('Est');
        $region3->setCode(03);
        $region4 = new Region();
        $region4->setName('Ouest');
        $region4->setCode(04);

        $departement1 = new Departement();
        $departement1->setRegion($region1);
        $departement1->
        $manager->persist($region1);

        $manager->flush();
    }
}