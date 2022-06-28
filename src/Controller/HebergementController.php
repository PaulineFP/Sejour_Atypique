<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Entity\Categories;
use App\Repository\HebergementRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HebergementController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoriesRepository $cat): Response
    {                       
        // PROMOTIONS ------------------
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository(Hebergement::class);
        $listePromotions = $repository->findByPromotion();       
        
        //CATEGORIES----------------------
        $listeCategories = $cat->findAll();
        

        //REGIONS-------------------------
        
        return $this->render('home/index.html.twig',
        [
            'promotions' => $listePromotions,
            'categories' => $listeCategories          
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
      /**
     * @Route("/{name}", name="show_category")
     */
    public function showCat(Categories $category){         

        return $this->render('models/category.html.twig',
        [
            'category' => $category            
        ]);
    }  

    //Crée une vue pour lister tout les hebergements d'une catégorie
}
