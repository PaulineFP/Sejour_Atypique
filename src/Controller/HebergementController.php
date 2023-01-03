<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Entity\Categories;
use App\Entity\Countries;
use App\Entity\Department;
use App\Repository\HebergementRepository;
use App\Repository\CategoriesRepository;
use App\Repository\CountriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



class HebergementController extends AbstractController
{
    /**
     * @Route("/accueil", name="home")
     */
    public function index(CategoriesRepository $repoCat, HebergementRepository $repoHeb, CountriesRepository $repoCount ): Response
    {                       
        // PROMOTIONS ------------------
        $listePromotions = $repoHeb->findByPromotion();       
        
        //CATEGORIES----------------------
        $listeCategories = $repoCat->findAll();

        //REGIONS-------------------------
        $listeCountries = $repoCount->findAll();
        
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
    public function showall(HebergementRepository $repo)
    {
        $hebergements = $repo->findAll();

        // PROMOTIONS ------------------
       $listePromotions = $repo->findByPromotion();
       
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
