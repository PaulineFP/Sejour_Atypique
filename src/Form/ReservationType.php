<?php

namespace App\Form;

use App\Entity\Reservations;
use App\Entity\Users;
use Doctrine\ORM\Query\Expr\Func;
use PhpParser\Builder\Function_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference')
            ->add('created_at')
            ->add('person_nb')
            ->add('child_nb')
            ->add('night_nb')
            ->add('arrived')
            ->add('price')
            ->add('hebergement')
            ->add('users')
            ->add('name', EntityType::class, array(
                // Recherche les choix de l'entité 
                'class' => Users::class,
                // Permet d’intégrer/rechercher la bonne valeur au bonne endroit
                'choice_value' => function (?Users $users) {
                    return $users ? $users->getName() : '';
                }, 
                //Pour ajouter le champs qui ne fait pas partie de l'entité de base
                'mapped' => false           
                ) 
            )
            ->add('username', EntityType::class, array(
                'class' => Users::class,
                'choice_value' => function (?Users $users) {
                    return $users ? $users->getUsername() : '';
                }, 
                'mapped' => false           
                ) 
            )
            ->add('email', EntityType::class, array(
                'class' => Users::class,
                'choice_value' => function (?Users $users) {
                    return $users ? $users->getEmail() : '';
                }, 
                'mapped' => false           
                ) 
            )
            ->add('phone', EntityType::class, array(
                'class' => Users::class,
                'choice_value' => function (?Users $users) {
                    return $users ? $users->getPhone() : '';
                }, 
                'mapped' => false           
                ) 
            )
            ->add('reservations', EntityType::class, array(
                'class' => Users::class,
                'choice_value' => function (?Users $users) {
                    return $users ? $users->getReservations() : '';
                }, 
                'mapped' => false           
                ) 
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
            //Voir si c est bien ca si dessous
            'data_class' => Users::class,
        ]);
    }
}
