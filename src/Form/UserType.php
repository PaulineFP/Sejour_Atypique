<?php

namespace App\Form;

use App\Entity\Users;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "attr"=> [
                    "class" => "form_name"
                ]
            ])
            ->add('username', TypesTextType::class, [
                "attr" => [
                    "class" => "form_username"
                ]
            ])
            ->add('email', EmailType::class, [
                "attr" => [
                   "class" => "form_mail" 
                ]
            ])
            ->add('phone', TelType::class, [
                "attr"=>[
                   "class" => "form_phone" 
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
