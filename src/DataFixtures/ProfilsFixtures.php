<?php

namespace App\DataFixtures;

use App\Entity\Profils;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfilsFixtures extends Fixture
{
   
    public function load(ObjectManager $manager)
    {
        
        $TabProfil = ['ADMIN', 'FORMATEUR', 'APPRENANT', 'CM'];

        foreach($TabProfil as $profilUser) {
            $profil = new Profils();
            $profil->setLibelle($profilUser);
            $manager->persist($profil);
            $manager->flush();
            $this->addReference($profilUser, $profil);
        }
    }
}