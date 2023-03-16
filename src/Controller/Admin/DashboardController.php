<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Countries;
use App\Entity\Department;
use App\Entity\Equipment;
use App\Entity\Hebergement;
use App\Entity\Media;
use App\Entity\Peculiarity;
use App\Entity\Order;
use App\Entity\Users;
use App\Entity\Reservations;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud; 
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $adminUrlGenerator;
    public function __construct(
        AdminUrlGenerator $adminUrlGenerator
    ) {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

     /**
     * @Route("/_ad-.", name="admin")
     */
    public function index(): Response
    {
        $url = $this->adminUrlGenerator 
        ->setController(HebergementCrudController::class)
        ->generateUrl();

    return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sejours Atypiques');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Gestion hébergements');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud( 'Ajouter un hebergement', 'fas fa-plus', Hebergement::class)
            ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les hebergements', 'fas fa-eye', Hebergement::class)
        ]);

        yield MenuItem::section('Gestion des médias');
        yield MenuItem::subMenu('Actions' ,'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud( 'Ajouter une image ', 'fas fa-plus', Media::class)
            ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les médias', 'fas fa-eye', Media::class)
        ]);

        
        yield MenuItem::section('Gestion catégories');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Crée une categorie', 'fas fa-plus', Categories::class)
            ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les categories', 'fas fa-eye', Categories::class)
        ]);

        yield MenuItem::section('Gestion particularités');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouté une particularité', 'fas fa-plus', Peculiarity::class)
            ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les particularités', 'fas fa-eye', Peculiarity::class)
        ]);

        yield MenuItem::section('Gestion des équipements');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter un équipement', 'fas fa-plus', Equipment::class)
                ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher tout les équipements', 'fas fa-eye', Equipment::class)
        ]);

        yield MenuItem::section('Gestion régions');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter une région', 'fas fa-plus', Countries::class)
            ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les régions', 'fas fa-eye', Countries::class)
        ]);

        yield MenuItem::section('Gestion départements');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter un département', 'fas fa-plus', Department::class)
            ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les départements', 'fas fa-eye', Department::class)
        ]);

        yield MenuItem::section('Traitement des commandes');
        yield MenuItem::linkToCrud('Afficher les commandes', 'fas fa-eye', Order::class);       ;
    

    
        yield MenuItem::section('Gestion client');  
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([ 
            MenuItem::linkToCrud('Ajouter un client', 'fas fa-plus', Users::class)
            ->setAction(Crud::PAGE_NEW),       
             MenuItem::linkToCrud('Afficher les clients', 'fas fa-eye', Users::class)
         ]);

         
        yield MenuItem::section('Gestion réservations');  
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([ 
            MenuItem::linkToCrud('Ajouter une réservation', 'fas fa-plus', Reservations::class)
            ->setAction(Crud::PAGE_NEW),       
             MenuItem::linkToCrud('Afficher les réservations', 'fas fa-eye', Reservations::class)
         ]);
    }
}