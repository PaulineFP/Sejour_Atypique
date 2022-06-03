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
        $hebergements = $ripo->findAll();

        return $this->render('home/tout-nos-hebergements.html.twig', 
        [
            'hebergements' => $hebergements
        ]);
    }
    /**
     * @Route("/hebergement/{id}", name="show_herbergement")
     */
    public function show(Hebergement $Hebergement){

        return $this->render('models/hebergement.html.twig',
        [
            'Hebergement' => $Hebergement
        ]);
    }   
    
}
