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
        // PROMOTIONS ------------------
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository(Hebergement::class);
        $listePromotions = $repository->findByPromotion();       
        
        //CATEGORIES----------------------

        //REGIONS-------------------------
        
        return $this->render('home/index.html.twig',
        [
            'promotions' => $listePromotions          
        ]);
      
    }
       /**
     * @Route("/hebergements", name="herbergements")
     */
    public function showall(HebergementRepository $ripo)
    {
        $hebergements = $ripo->findAll();

        // PROMOTIONS ------------------
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository(Hebergement::class);
       $listePromotions = $repository->findByPromotion();
       
       $groups = (array_chunk($listePromotions, 4, true)); 

        return $this->render('home/tout-nos-hebergements.html.twig', 
        [
            'hebergements' => $hebergements,
            'promotions' => $listePromotions  
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
