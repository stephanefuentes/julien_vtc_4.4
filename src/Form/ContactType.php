<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                "label" => "Prénom",
                "attr" => [
                    "placeholder" => "Votre prénom",
                    "maxlength" => "70"
                ]
            ])
            ->add('lastName', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "placeholder" => "Votre nom",
                    "maxlength" => "70"
                ]
            ])
            ->add('email', EmailType::class, [
                "label" => "Email",
                "attr" => [
                    "placeholder" => "Votre email",
                    "maxlength" => "170"
                ] 
                
            ])
            ->add('commentaire', TextareaType::class, [
                "label" => "Commentaire",
                "attr" => [
                    "placeholder" => "Votre commentaire",
                    "rows" => "10",
                    "maxlength" => "2500" 
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
