<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeveralCandidaciesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('candidacies', CollectionType::class,
        [
            "label" => "Nouvelles candidatures",
            'entry_type'   => CandidacyType::class,
            'entry_options' =>
            [
                'show_advanced' => false
            ],
            'allow_add'    => true,
            'by_reference' => false
        ])
        ->add("save", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
