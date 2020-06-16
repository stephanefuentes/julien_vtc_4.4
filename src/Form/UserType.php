<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                "label" => "Prénom",
                "attr" => [
                    "placeholder" => "Votre prénom"
                ]
            ])

            ->add('lastName', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "placeholder" => "Votre nom"
                ]
            ])
            ->add('email', EmailType::class, [
                "label" => "Email ",
                "attr" => [
                    "placeholder" => "Votre email ici"
                ]
            ])
            // ->add('roles')
            ->add('password', PasswordType::class, [
                "label" => "Mot de passe",
                "attr" => [
                    "placeholder" => "Votre mot de passe"
                ]
            ])
           
            ->add('phone', TelType::class, [
                "label" => "Numéro de téléphone",
                "attr" => [
                    "placeholder" => "Votre numéro de téléphone"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
