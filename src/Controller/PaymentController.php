<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Repository\HebergementRepository;
use PhpParser\Node\Stmt\If_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


    /**
     *@Route("/reservations", name="cart_")
     */
class PaymentController extends AbstractController
{

    /**
     *@Route("/", name="index")
     */
    public function index(SessionInterface $session, HebergementRepository $hebergementRepository){
        $panier = $session->get("panier", []);

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
     * @Route("/add/{id}", name="add")
     */
    public function add(Hebergement $hebergement, SessionInterface $session){
        //On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $hebergement->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        //On sauvegarde dans la session
        $session->set("panier", $panier);
        
        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/remove/{id}", name="remove")
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
     * @Route("/delete/{id}", name="delete")
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
