<?php
namespace App\Controller;


use App\Entity\Hebergement;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\HebergementRepository;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

 /**
  * @Route("/operation-payement", name="stripe_")
  */
class StripeController extends AbstractController
{
  public function __construct()
  {
    $clientSecret = $_ENV['STRIPE_KEY'];
    $webhookSecret = $_ENV['WEBHOOK_KEY'];
    Stripe::setApikey($clientSecret);
    //Stripe::setApikey($webhookSecret);
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

  //J'instancie le contenue de mon panier
  foreach($panier as $hebergementId => $quantity) {
    $hebergement = $repo->findOneById($hebergementId);
    //je dissocie la quantité des hébergements pour mieux les identifier et les manipuler ensuite 
    $panierItems[] = [
      "quantity" => $quantity,
      "hebergement" => $hebergement
    ];
   
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
   //je renvoie sur l'url renvoyer par stripe
    return $this->redirect($session->url);
    
   }

    /**
  * @Route("/webhook2.php", name="webhook")
  */
   public function webhook (LoggerInterface $logger, Request $request){
    //je surveille dans le terminal se que webhook envoie
    //json_encode permet de transformer en chaine
    $logger->critical(json_encode($request));
    
    //Je decode le json pour que ce soit lisible
    $info = json_decode($request->getContent());
    $logger->critical(json_encode($info));
    return new Response ('BLALBLA');
    //pour récupérer les infos en bdd $info['ma donnee']
   }
   
   //https://www.youtube.com/watch?v=k9ZA8BoNFik   

}
