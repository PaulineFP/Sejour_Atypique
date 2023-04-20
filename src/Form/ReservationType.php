<?php

namespace App\Form;

use App\Entity\Reservations;
use App\Entity\Users;
use App\Entity\Hebergement;
use Doctrine\ORM\Query\Expr\Func;
use PhpParser\Builder\Function_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TypeTextType::class, ['by_reference' => true] )
            ->add('created_at', DateType::class, ['by_reference' => true])
            ->add('person_nb', NumberType::class)
            ->add('child_nb', NumberType::class)
            ->add('night_nb', NumberType::class)
            ->add('arrived', DateType::class)
            ->add('price', MoneyType::class)
            ->add('hebergement', EntityType::class, [
                'class' => Hebergement::class,
                'choice_value' => function (?Hebergement $hebergement) {
                    return $hebergement ? $hebergement->getId() : '';
                }
            ])
            ->add(
                $builder->create('users', FormType::class, ['by_reference' => false])
                    ->add('name', TypeTextType::class)
                    ->add('username', TypeTextType::class)
                    ->add('email', EmailType::class)
                    ->add('phone', TelType::class)
                    ->add('reservations', TypeTextType::class, ['by_reference' => true])
            )    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
            'data_class' => Users::class,
            'data_class' => Hebergement::class
        ]);
    }
}
