<?php

namespace App\DataFixtures;

use App\Entity\Hebergement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
Use Faker\factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        for ($i=0; $i<10; $i++) {
        // Crée manuellement un contenu fictif
        $hebergement = new Hebergement();
        $hebergement->setTitle($faker->sentence($nbWords = 2, $variableNbWords = true))
                    ->setDescription($faker->sentence($nbWords = 10, $variableNbWords = true))
                    ->setTarif($faker->randomNumber(3))
                    ->setLieux('ICI');

         $manager->persist($hebergement);
        }
        
        $manager->flush();
    }
}
