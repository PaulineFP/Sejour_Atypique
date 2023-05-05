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
    public function index(PanierRepository $panierRepo, HebergementRepository $hebergementRepository){
        $panier = $panierRepo;
        //je dois recuperer tout les paniers le ref de la session $panier_ref
        //dans dataPanier faire un findBy avec les meme paramettre que pour findoneby
        //boucle
        //puis parcourir le tableau pour chaque panier ($panierRepo)
        //une fois que j'ai un panier je fait un get reservation
       
        //On "fabrique" les données
        
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $hebergement = $hebergementRepository->find($id);
            $dataPanier[] = [
                "hebergement" => $hebergement,
                "quantite" => $quantite
            ];
            //Ne pas oublier par la suite : nombre de personne; nombre de nuit, types de services et les promotions/réductions
            $total += $hebergement->getTarif() * $quantite;
        }
        
        return $this->render('payment/index.html.twig', compact("dataPanier", "total"));
    }

    //Tuto panier : https://www.youtube.com/watch?v=__CdqAy1xMg&t=473s


    /**
     * @Route("/remove/{id}", name="cart_remove")
     */
    public function remove(Hebergement $hebergement, SessionInterface $session){
        //On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $hebergement->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        //On sauvegarde dans la session
        $session->set("panier", $panier);
        
        return $this->redirectToRoute("cart_index");
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
