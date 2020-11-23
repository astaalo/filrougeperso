<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\CM;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CMFixtures extends Fixture  implements DependentFixtureInterface
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

            $cm = new CM();

            $hash = $this->encoder->encodePassword($cm, "passer");
            
            $cm
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName)
                ->setLogin($faker->email)
                ->setPassword($hash)
                ->setTelephone($faker->unique()->randomElement(["771907654", "701000425", "762901223"]))
                ->setProfil($this->getReference("CM"));
                ;
            $manager->persist($cm);
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