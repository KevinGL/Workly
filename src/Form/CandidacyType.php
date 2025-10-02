<?php

namespace App\Form;

use App\Entity\Candidacy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidacyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('job', TextType::class, ["label" => "Poste proposé"])
            ->add('link', TextType::class, ["label" => "Lien offre d'emploi"])
            ->add('society', TextType::class, ["label" => "Société"])
            ->add('location', TextType::class, ["label" => "Localisation"])
            ->add('about', TextareaType::class, ["label" => "Infos supplémentaires", "required" => false])
            ->add('appliedAt', DateType::class, ["label" => "Postulé le"])
            ->add('toRelaunchAt', DateType::class, ["label" => "À relancer le"]);

            if($options["show_advanced"])
            {
                $builder->add('relaunchedAt', DateType::class, ["label" => "Relancée le"])
                        ->add('answer', ChoiceType::class,
                        [
                            "label" => "Réponse ?",
                            "choices" =>
                            [
                                "Pas encore de réponse" => "Pas encore de réponse",
                                "Entretien d'embauche" => "Entretien d'embauche",
                                "Candidature rejetée" => "Candidature rejetée"
                            ],
                            "data" => "Pas encore de réponse",
                            "expanded" => true,
                            "multiple" => false,
                        ]);
            }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidacy::class,
            "show_advanced" => true
        ]);
    }
}
