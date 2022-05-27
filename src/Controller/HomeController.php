<?php

namespace App\Controller;

use App\Entity\Hebergement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
       /**
     * @Route("/hebergements", name="herbergements")
     */
    public function hebergements(): Response
    {
        // Crée manuellement le contenu
        $hebergement = new Hebergement();
        $hebergement->setTitle('Logement 1')
                    ->setDescription('Fugiat voluptate sit ea est aute tempor qui et nisi minim veniam. ')
                    ->setTarif('150')
                    ->setLieux('ICI');

        return $this->render('home/tout-nos-hebergements.html.twig', [
            "hebergement" => $hebergement
        ]);
    }
    
}
