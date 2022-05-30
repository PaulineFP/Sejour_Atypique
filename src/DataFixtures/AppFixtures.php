<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i=0; $i<10; $i++) {
        // Crée manuellement un contenu fictif
        $hebergement = new Hebergement();
        $hebergement->setTitle('Logement 1')
                    ->setDescription('Fugiat voluptate sit ea est aute tempor qui et nisi minim veniam. ')
                    ->setTarif('150')
                    ->setLieux('ICI');

         $manager->persist($hebergement);
        }
        ]
        $manager->flush();
    }
}
