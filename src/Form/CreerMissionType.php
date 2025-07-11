<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Mission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreerMissionType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('duree')
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'site e-commerce' => 'site e-commerce',
                    'application mobile' => 'application mobile',
                    'logo professionnel' => 'logo professionnel',
                    'stratégie SEO' => 'stratégie SEO',
                    'article de blog' => 'article de blog',
                    'dashboard analytique' => 'dashboard analytique'
                ],
                'placeholder' => 'Choisissez une catégorie',
            ])
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
