<?php

namespace App\Controller;

use App\Controller\StripeController;
use App\Entity\Reservations;
use App\Repository\HebergementRepository;
use App\Repository\PanierRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class PaymentController extends AbstractController
{

    /**
     *@Route("/reservations", name="cart_index")
     */
    public function index(PanierRepository $panierRepo, HebergementRepository $hebergementRepository, SessionInterface $session)
    {
        $panier_ref = $session->get("panier_ref", '');
        $paniers = $panierRepo->findBy(['RefPanier' => $panier_ref]);
        // dd($paniers);
        return $this->render('payment/index.html.twig', [
            "paniers" => $paniers
        ]);
    }

    /**
     * @Route("delete/{id}", name="cart_delete")
     * @param Reservations $reservations
     * @return RedirectResponse
     */
    public function delete(Reservations $reservations, ManagerRegistry $doctrine): RedirectResponse
    {
        $em = $this->$doctrine->getManager();
        $em->remove($reservations);
        $em->flush();


        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="cart_delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier", []);
        return $this->redirectToRoute("cart_index");
    }


    /**
     * @Route("/payment", name="cart_payment")
     */
    public function payment(SessionInterface $session, StripeController $payment, PanierRepository $panierRepo)
    {
        require '../vendor/autoload.php';
        //TEST  
        // Je récupère les informations du panier en BDD de la session en cours
        // $panier_ref = $session->get("panier_ref", '');
        // $paniers = $panierRepo->findBy(['RefPanier' => $panier_ref]);
        //J'initialise Stripe
        $payment = new StripeController();


        //calculer le total de chaque reservation

        return $this->redirectToRoute("stripe_start");
        // return $this->render('/operation-payement', [
        //     "paniers" => $paniers,
        //     "payment" => $payment
        // ]);
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
