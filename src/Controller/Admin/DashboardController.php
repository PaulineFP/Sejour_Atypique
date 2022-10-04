<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Countries;
use App\Entity\Hebergement;
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
        
        yield MenuItem::section('Gestion catégories');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Crée une categorie', 'fas fa-plus', Categories::class)
            ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les categories', 'fas fa-eye', Categories::class)
        ]);

        yield MenuItem::section('Gestion régions');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter une région', 'fas fa-plus', Countries::class)
            ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les régions', 'fas fa-eye', Countries::class)
        ]);
       
    }
}