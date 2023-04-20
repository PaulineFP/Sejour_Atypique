<?php

namespace App\Controller;

use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
        /**
     * @Route("/hebergement/{id}", name="create_reserver_form")
     */
    // public function index(): Response
    // {
    //    $form = $this->createForm(ReservationType::class);
    //    return $this->render('models/hebergement.html.twig', [
    //     'form' => $form->createView()
    //    ]);
    // }
}
