<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public const ACTION_DUPLICATE = 'diplicate';

    public static function getEntityFqcn(): string 
    {
        return order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new(self::ACTION_DUPLICATE)
        ->linkToCrudAction('duplicateOrder')
        ->setCssClass('btn btn-info');

        return $actions
        ->add(Crud::PAGE_EDIT, $duplicate)
        ->reorder(Crud::PAGE_EDIT, [self::ACTION_DUPLICATE, Action::SAVE_AND_RETURN]);
    }

    public function configureFields(string $pageName): iterable
    {
        return[
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom et Prénom'),
            EmailField::new('email', 'E-mail'),
            TextField::new('adress', 'Adresse'),
            TextField::new('order_info', 'Informations de commande'),
            MoneyField::new('price', 'Prix Total')
                ->setCurrency('EUR')
                ->setCustomOption('storedAsCents', false),
            IdField::new('id_panier', 'Id du panier'),
            IdField::new('id_payment', 'Id de payement'),
            BooleanField::new('treated', 'Traitée')
        ];
    }
}
