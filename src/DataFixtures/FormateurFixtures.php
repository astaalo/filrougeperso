<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Formateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormateurFixtures extends Fixture  implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 3; $i++) {

            $formateur = new Formateur();

            $hash = $this->encoder->encodePassword($formateur, "passer");
            
            $formateur
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName)
                ->setLogin($faker->email)
                ->setPassword($hash)
                ->setAdresse($faker->city)
                ->setTelephone($faker->unique()->randomElement(["771907654", "701000425", "762901223"]))
                ->setProfil($this->getReference("FORMATEUR"));

            $manager->persist($formateur);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProfilsFixtures::class,
        );
    }
}