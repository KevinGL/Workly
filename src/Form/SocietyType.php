<?php

namespace App\Form;

use App\Entity\Society;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocietyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ["label" => "Nom"])
            ->add("contactedAt", DateType::class, ["label" => "Contactée le", "required" => false])
            ->add("toRelaunchAt", DateType::class, ["label" => "À relancer le", "required" => false])
            ->add("relaunchedAt", DateType::class, ["label" => "Relancée le", "required" => false])
            ->add('phoneNumber', TextType::class, ["label" => "Numéro"])
            ->add('email', TextType::class, ["label" => "Adresse email"])
            ->add('linkedIn', TextType::class, ["label" => "Lien LinkedIn"])
            ->add('recruit', ChoiceType::class,
            [
                "label" => "Recrute ?",
                "choices" =>
                [
                    "Pas encore contactée" => "Pas encore contactée",
                    "Oui" => "Oui",
                    "Non" => "Non",
                    "Réponse vague" => "Réponse vague"
                ],
                "data" => "Pas encore contactée",
                "expanded" => true,
                "multiple" => false,
            ])
            ->add("about", TextareaType::class, ["label" => "Infos supplémentaires", "required" => false])
            ->add("answer", TextareaType::class, ["label" => "Bilan de l'échange", "required" => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Society::class,
        ]);
    }
}
