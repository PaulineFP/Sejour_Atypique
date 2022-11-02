<?php

namespace App\Controller\Admin;

use App\Entity\Peculiarity;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PeculiarityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return peculiarity::class;
    }

}
