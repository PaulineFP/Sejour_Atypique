<?php
namespace App\Controller;

use App\Entity\Order;
use App\Entity\Hebergement;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\HebergementRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Egulias\EmailValidator\Result\InvalidEmail;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use Psr\Log\LoggerInterface;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\RedirectController;

 //TUTO Stripe : https://www.youtube.com/watch?v=k9ZA8BoNFik   

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
  * @Route("payementReussi", name="stripe_success")
  */
  public function success(SessionInterface $session){
    
    //Pour éviter que les utilisateurs ne voient des données périmées, je reboot la session 
    // Supprime tous les attribues de la session
    $session->clear();

    $url = '/accueil';
   
    return $this->render(
      //url de rediredtion
      'stripe/success.html.twig', 
      // je donne les parametre de l'url
      ['url' => $url], 
      // je donne la nouvelle url a recharger au bout de tant de secondes
      RedirectController::getRedirectLater($url) 
      );
  }


  /**
  * @Route("/operation-payement", name="stripe_start")
  */
  public function startPayment(SessionInterface $session, HebergementRepository $repo, EntityManagerInterface $entitymanager){

    //On récupère le panier actuel
    $panier = $session->get("panier", []);
    $panierId = $session->getId();
    $save_panier = [];
  //J'instancie le contenue de mon panier
  foreach($panier as $hebergementId => $quantity) {
    $hebergement = $repo->findOneById($hebergementId);

    $hebergementName = $hebergement->getTitle();

    //je dissocie la quantité des hébergements pour mieux les identifier et les manipuler ensuite 
    $panierItems[] = [
      "quantity" => $quantity,
      "hebergement" => $hebergement
    ];

    //Je crée une syntaxe approprier pour pouvoir reprendre les informations pour les inscrire en BDD
    $productDetail = $quantity. ' '. $hebergementName;
    $save_panier[] = $productDetail ;
  }
   $save_panier = implode('   , ', $save_panier);
 


    // je prepare mes information a conserver
    $order = new Order();
    $order->setname(' ');
    $order->setEmail(' ');
    $order->setAdress(' ');
    $order->setPrice(' ');
    $order->setIdPanier($panierId);
    $order->setOrderInfo($save_panier);
    $order->setIdPayment(' ');
   
    $entitymanager->persist($order);
    $entitymanager->flush($order);
    //dd($order);


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
     //j'enregistre mes données
     "metadata" => ["order_id" => $order->getId()],

     'mode' => 'payment',
     'success_url' => 'http://127.0.0.1:8000/payementReussi',
     'cancel_url' => 'http://127.0.0.1:8000/accueil', /* voir si je peux simplifier avec home de mon controller*/
     
     'billing_address_collection'  => 'required',
     'shipping_address_collection' => [
       'allowed_countries' => ['FR']
   ],
   ]); 
   //je renvoie sur l'url renvoyer par stripe
    return $this->redirect($session->url);
    
   }

   //Je relie les informations de la commande via webhook 
   // en local : https://dashboard.stripe.com/test/payments/pi_3M7KZBAWgD5DW0y41XXyavQS

    /**
  * @Route("webhook2.php", name="webhook")
  */
   public function webhook (LoggerInterface $logger, Request $request, OrderRepository $repo, EntityManagerInterface $entitymanager){
    //je surveille dans le terminal ce que webhook envoie
    //json_encode permet de transformer en chaîne
    $logger->critical(json_encode($request));
    
    //Je decode le json pour que ce soit lisible
    $info = json_decode($request->getContent(), true);
    $logger->critical(json_encode($info));
    $id = $info['id'];

    $stripe_event = $info['type'];

    if($stripe_event === 'checkout.session.completed'){

      //je récupère l'id du payment dans ma session stripe
      $order_id = $info['data']['object']['metadata']['order_id'];
      

      $client_name = $info['data']['object']['customer_details']['name'] ;
      $client_mail = $info['data']['object']['customer_details']['email'];
      
      $client_street =  $info['data']['object']['customer_details']['address']['line1'] ;
      $client_postal = $info['data']['object']['customer_details']['address']['postal_code'];
      $client_city = $info['data']['object']['customer_details']['address']['city'] ;
      //récupérer le $save_panier de payment controller
     // $id_panier = a recup av de payer;

      /*$order_info = $info[''] ;
      $order_product = $info[''] ;
      $order_product_quantity = $info[''] ;
      $order_product_price = $info[''] ;*/
      $order_price = $info['data']['object']['amount_total']  ;

      $logger->critical($order_id);
      //convertir la chaîne en entier si le json donne en chaîne   
      $order = $repo->findOneById(intval($order_id));

      $logger->critical(json_encode($order));
      

      //je relie mes infos stripe aux infos de mon entité
      $order->setIdPayment($id);
      //$order->setIdPanier($id_panier);

      $order->setName($client_name);
      $order->setEmail($client_mail);
      $client_address = $client_street.", ". $client_postal." ". $client_city ;

      $order->setAdress($client_address);

      $order->setPrice(intval($order_price));

       //je stock les infos en BDD
      $entitymanager->persist($order);
      $entitymanager->flush($order);
    }
    
    return new Response ('BLALBLA');
   }
   
  

}
