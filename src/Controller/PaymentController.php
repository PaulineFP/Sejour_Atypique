<?php

namespace App\Controller;

use App\Controller\StripeController;
use App\Entity\Hebergement;
use App\Entity\Reservations;
use App\Repository\HebergementRepository;
use App\Repository\PanierRepository;
use PhpParser\Node\Stmt\If_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;

   
class PaymentController extends AbstractController
{

   /**
     *@Route("/reservations", name="cart_index")
     */
    public function index(PanierRepository $panierRepo, HebergementRepository $hebergementRepository, SessionInterface $session){
        
       
        $panier_ref = $session->get("panier_ref", '');
        $paniers = $panierRepo->findBy(['RefPanier' => $panier_ref]);
        
        return $this->render('payment/index.html.twig', [
            "paniers" => $paniers
        ]);
    }

        /**
     * @Route("/delete/{id}", name="cart_delete")
     */
    public function delete(Hebergement $hebergement, SessionInterface $session){
        //On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $hebergement->getId();

        if(!empty($panier[$id])){
          unset($panier[$id]);          
        }

        //On sauvegarde dans la session
        $session->set("panier", $panier);
        
        return $this->redirectToRoute("cart_index");
    }

            /**
     * @Route("/delete", name="cart_delete_all")
     */
    public function deleteAll(SessionInterface $session){                
        $session->remove("panier", []);        
        return $this->redirectToRoute("cart_index");
    }


     /**
     * @Route("/payment", name="payment")
     */
    public function payment(SessionInterface $session, StripeController $payment){
        require '../vendor/autoload.php';
        //On récupère le panier actuel
        $panier = $session->get("panier", []);
        $payment = new StripeController();

    //sinon tu peux mettres ton panier sous forme JSON, et enregistrer ca dans un champ de ton entité order
        //$save_panier = $panier;

        return $this->redirectToRoute("stripe_start", $panier);
          
    }

    // /**
    //  * @Route("/payment", name="app_payment")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('payment/index.html.twig', [
    //         'controller_name' => 'PaymentController',
    //     ]);
    // }
}
