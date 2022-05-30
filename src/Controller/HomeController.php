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
       
        return $this->render('home/tout-nos-hebergements.html.twig', [
            //"hebergement" => $hebergement
        ]);
    }
    
}
