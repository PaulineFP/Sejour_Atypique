<?php

namespace App\Form;

use App\Entity\Hebergement;
use App\Entity\Reservations;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', HiddenType::class, [
                "attr"=> [
                    "class"=> "from_date"
                ]
            ])
            ->add('created_at', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('person_nb', NumberType::class)
            ->add('child_nb', NumberType::class)
            ->add('night_nb', NumberType::class)
            ->add('arrived', DateTimeType::class, [
                "attr"=> [
                    "class"=>"form_arrived"
                ]
            ])
            ->add('price', EntityType::class, [
                'class' => Hebergement::class,
                'choice_label' => 'PromoTotal'
            ])
            ->add('hebergement ', EntityType::class, [
                'class' => Hebergement::class,
                'choice_label' => 'id'
                //GetId
            ])
            ->add('users') // Voir pour crée ou modifier en fonction
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
