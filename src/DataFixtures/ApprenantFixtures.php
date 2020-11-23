<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Apprenant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApprenantFixtures extends Fixture  implements DependentFixtureInterface
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

            $app = new Apprenant();

            $hash = $this->encoder->encodePassword($app, "passer");
            $app
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName)
                ->setLogin($faker->email)
                ->setPassword($hash)
                ->setIsDeleted(false)
                ->setAdresse($faker->city)
                ->setTelephone($faker->unique()->randomElement(["771734216", "701003425", "762901234"]))
                ->setStatus($faker->randomElement(["actif", "abandonné", "décédé", "suspendu"]))
                ->setProfil($this->getReference("APPRENANT"));

            $manager->persist($app);
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