<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Livre;
use AppBundle\Entity\Auteur;

class LoadLivreData implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $orwell = new Auteur();
        $orwell
            ->setNom('Orwell')
            ->setPrenom('George')
            ->setNaissance(new \DateTime('1903-06-25'))
            ->setLieu('Motihari')
        ;
        $manager->persist($orwell);

        $fermeAnimaux = new Livre;
        $fermeAnimaux
            ->setTitre('La ferme des animaux')
            ->setAuteur($orwell)
            ->setDateParution(new \DateTime('1945-08-17'))
        ;
        $manager->persist($fermeAnimaux);

        $verne = new Auteur();
        $verne
            ->setNom('Verne')
            ->setPrenom('Jules')
            ->setNaissance(new \DateTime('1828-02-08'))
            ->setLieu('Nantes')
        ;
        $manager->persist($verne);

        $tourDuMonde = new Livre;
        $tourDuMonde
            ->setTitre('Le tour du monde en 80 jours')
            ->setAuteur($verne)
            ->setDateParution(new \DateTime('1872-01-01'))
        ;
        $manager->persist($tourDuMonde);

        $manager->flush();
    }
}