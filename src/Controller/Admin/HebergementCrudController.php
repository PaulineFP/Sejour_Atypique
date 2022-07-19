<?php

namespace App\Controller\Admin;

use App\Entity\Hebergement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HebergementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hebergement::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
