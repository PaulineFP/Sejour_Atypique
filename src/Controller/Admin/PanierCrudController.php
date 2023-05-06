<?php

namespace App\Controller\Admin;

use App\Entity\Panier;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PanierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Panier::class;
    }
}
