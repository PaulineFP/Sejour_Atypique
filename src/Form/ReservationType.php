<?php

namespace App\Form;

use App\Entity\Reservations;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class )
            ->add('created_at', DateType::class)
            ->add('person_nb', NumberType::class)
            ->add('child_nb', NumberType::class)
            ->add('night_nb', NumberType::class)
            ->add('arrived', DateType::class)
            //->add('price', MoneyType::class)
          
            ->add('users', UserType::class, [
                'data_class' => Users::class
            ])               
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
            // 'data_class' => Users::class,
            // 'data_class' => Hebergement::class
        ]);
    }
}

// https://espritweb.fr/comprendre-et-realiser-un-formulaire-symfony-en-10-minutes/?fbclid=IwAR3ADGVNd9XLS34P0TjZiLFbE8BgsvnYzt2CM6zi_iO7x0H_UrBzoX2r25k