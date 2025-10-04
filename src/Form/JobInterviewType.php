<?php

namespace App\Form;

use App\Entity\JobInterview;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobInterviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('job')
            ->add('society')
            ->add('about', TextareaType::class,
            [
                "required" => false,
                "empty_data" => ""
            ])
            ->add("address", TextType::class)
            ->add("zipCode", TextType::class)
            ->add("city", TextType::class)
        ;

        if($options["edit"])
        {
            $builder->add('answer', ChoiceType::class,
            [
                "choices" =>
                [
                    "Pas de réponse" => "Pas de réponse",
                    "Refusé" => "Refusé",
                    "Embauché" => "Embauché"
                ],
                "expanded" => true,
                "multiple" => false,
            ]);
        }

        $builder->add('candidacyType')
            ->add('date')
            ->add('phoneNumber')
            ->add('email')
            ->add('linkedIn')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobInterview::class,
            "edit" => false
        ]);
    }
}
