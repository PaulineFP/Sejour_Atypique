<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     *@Route("/reservations", name="reservation")
     */
class PaymentController extends AbstractController
{
    /**
     *@Route("/mon-panier", name="cart_")
     */
    public function index(){
        return $this->render('payment/index.html.twig');
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
