<?php

namespace App\Controller;

use app\Entity\Users;
use app\Entity\Reservations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /** 
     * @param Request $request
     * @return Response
     */
    
    public function new(Request $request): Response
    {
        return $this->render('models/hebergement.html.twig');
    }
}
