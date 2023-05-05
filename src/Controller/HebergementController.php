<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Entity\Categories;
use App\Entity\Countries;
use App\Entity\Department;
use App\Entity\Panier;
use App\Entity\Reservations;
use App\Entity\Users;
use App\Form\ReservationType;
use App\Repository\HebergementRepository;
use App\Repository\CategoriesRepository;
use App\Repository\CountriesRepository;
use App\Repository\PanierRepository;
use Symfony\Component\String\ByteString;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HebergementController extends AbstractController
{
    /**
     * @Route("/", name="home")
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
    public function show(Hebergement $hebergement, Request $request, EntityManagerInterface $entityManager, SessionInterface $session, PanierRepository $panierRepo){         
        
        $reservation = new Reservations();
        
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $form->getData()->getUsers();
            $entityManager->persist($user);
            
            $reservation->setUsers($user);
            $reservation->setHebergement($hebergement);
            //Récupérer la date du jour
            $reservation->setCreatedAt(new \DateTime('now'));
            
            //Calcul du prix :               
                $promo_checked = $hebergement->getIsPromotional();
                $night_nb = $form->getData()->getNightNb();

                if($promo_checked == 1){
                    $promo = $hebergement->getPromoTotal();
                    $total = $promo*$night_nb;
                }else{
                    $price = $hebergement->getTarif();
                    $total = $price*$night_nb;
                }
            //---------------

            $reservation->setPrice($total);
            
            //Générer une référence automatiquement
            $ref = ByteString::fromRandom(8)->toString();
            $reservation->setReference($ref);

            $entityManager->persist($reservation);

            //Je stock la session en guise de référence de panier
            $panier_ref = $session->get("panier_ref", '');
            // dd($panier_ref);
            
            if(empty($panier_ref)){
                $panier_ref = uniqid();
                $session->set("panier_ref", $panier_ref);
            }else{
                $panier = $panierRepo->findOneBy(["RefPanier" => $panier_ref]);
                $panier_ref = $panier->getRefPanier();
            }  

            $panier = new Panier();
            $panier->addReservation($reservation);          
    
            //On sauvegarde la session de référence dans la BDD
            $panier->setRefPanier($panier_ref);
            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->redirectToRoute("cart_index");

        }    

        return $this->render('models/hebergement.html.twig',
        [
            'hebergement' => $hebergement ,
            'form' => $form->createView(),
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
