<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Repository\HebergementRepository;
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
    public function showall(HebergementRepository $ripo)
    {
        $Hebergement = $ripo->findAll();

        return $this->render('home/index.html.twig', [
            'Hebergement' => $Hebergement
        ]);
    }   
    
}
