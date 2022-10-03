<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Entity\Categories;
use App\Entity\Countries;
use App\Repository\HebergementRepository;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
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
        $repository_count = $this->getDoctrine()
                                 ->getManager()
                                 ->getRepository(Countries::class);
        $listeCountries = $repository_count->findAll();
        
        return $this->render('home/index.html.twig',
        [
            'promotions' => $listePromotions,
            'categories' => $listeCategories,
            'countries' => $listeCountries         
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
     * @Route("/categorie/{name}", name="show_category")
     */
    public function showCat(Categories $category){       
       
        return $this->render('models/category.html.twig',
        [
            'category' => $category           
        ]);
    }  

    /**
     * @Route("/region/{name}", name ="show_country")
     */
    public function showCountry(HebergementRepository $repo, Countries $countries): Response
    {
        
        $hebergements = $repo->findByCountry($countries);
        $countryName = $countries->getName();

        return $this->render('models/country.html.twig',
        [
            'country'=> $countries,
            'countryName'=> $countryName,
            'hebergements' => $hebergements          
        ]);
       
    }


   
}
