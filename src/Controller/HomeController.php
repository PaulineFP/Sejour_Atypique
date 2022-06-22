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
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository(Hebergement::class);
        $listePromotions = $repository->findByPromotion();

        // $groups = découper listePromotion en petit bout de 3 ou 4 avec arrayschunk
        // https://www.php.net/manual/fr/function.array-chunk.php
        
        return $this->render('home/index.html.twig',
    [
        'promotions' => $listePromotions
        // renvoyer groups;
    ]);

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
    public function show(Hebergement $hebergement){

        return $this->render('models/hebergement.html.twig',
        [
            'hebergement' => $hebergement
        ]);
    }   
    
}
