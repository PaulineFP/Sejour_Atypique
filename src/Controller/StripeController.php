<?php
namespace App\Controller;

use App\Entity\Hebergement;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\HebergementRepository;
use Stripe\Checkout\Session;

 /**
  * @Route("/operation-payement", name="stripe_")
  */
class StripeController extends AbstractController
{
  public function __construct()
  {
    $clientSecret = $_ENV['STRIPE_KEY'];
    Stripe::setApikey($clientSecret);
    Stripe::setApiVersion('2022-08-01');
  }

 /**
  * @Route("/payement-reussi", name="success")
  */
  public function success(){
    return $this->render('stripe/success.html.twig');
  }


  /**
  * @Route("/operation-payement", name="start")
  */
  public function startPayment(SessionInterface $session, HebergementRepository $repo){

    //On récupère le panier actuel
    $panier = $session->get("panier", []);

  $hebergements = [];

  //J'instancie le contenue de mon panier
  foreach($panier as $hebergementId => $quantity) {
    $hebergement = $repo->findOneById($hebergementId);
    //je dissocie la quantité des hébergements pour mieux les identifier et les manipuler ensuite 
    $panierItems[] = [
      "quantity" => $quantity,
      "hebergement" => $hebergement
    ];
    //$hebergements[]= $hebergement;
  }
 // dd($panierItems);

     $session = Session::create([
       'line_items'                  => [
        //je map sur tout le contenu de mon panier
         array_map(fn($panierItems) => [
        // et je récupère ce qu il m'intéresse de façon inclusive
             'quantity'   => $panierItems['quantity'],
             'price_data' => [
                 'currency'     => 'EUR',
                 'product_data' => [
                     'name' => $panierItems['hebergement']->getTitle()
                 ],
                 //stripe considère tout sous forme de centime
                 'unit_amount'  => $panierItems['hebergement']->getTarif() * 100

             ]
         ], $panierItems)
     ],
     'mode' => 'payment',
     'success_url' => 'http://127.0.0.1:8000/operation-payement/payement-reussi',
     'cancel_url' => 'http://127.0.0.1:8000/', /* voir si je peux simplifier avec home de mon controller*/
     
     'billing_address_collection'  => 'required',
     'shipping_address_collection' => [
       'allowed_countries' => ['FR']
   ],
   ]); 
    return $this->redirect($session->url);
   }
   
 
   //https://www.youtube.com/watch?v=k9ZA8BoNFik     ->14:20

}
