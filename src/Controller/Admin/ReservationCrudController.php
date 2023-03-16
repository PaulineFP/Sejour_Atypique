<?php

namespace App\Controller\Admin;

use App\Entity\Reservations;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class ReservationCrudController extends AbstractCrudController
{
    public const ACTION_DUPLICATE = 'diplicate';

    public static function getEntityFqcn(): string 
    {
        return reservations::class;
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
            AssociationField::new('users', 'nom')
            ->setRequired(true)
                ->setFormTypeOption('choice_label', 'id')
                ->formatValue(function($id, $entite){
                    if($entite->getUsers() == null){
                        return '';
                    }
                    return $entite -> getUsers()->getname();
                }),
            DateField::new('created_at', 'Réserver le'),
            TextField::new('reference', 'Référence'),
            AssociationField::new('hebergement', 'Hébergement associé')
            ->setRequired(true)
            ->setFormTypeOption('choice_label', 'title')
            ->formatValue(function($id, $entite){
                if($entite->getHebergement() == null){
                    return '';
                }
                return $entite -> getHebergement()->getTitle();
            }),
            NumberField::new('person_nb', 'Nombre de personne.s'),
            NumberField::new('child_nb', 'Nombre d\'enfant.s'),
            NumberField::new('night_nb', 'Nombre de nuit.s'),
            DateField::new('arrived', 'Date d\'arrivée'),
            MoneyField::new('price', 'Montant de la réservation')->setCurrency('EUR')
        ];
    }
}
