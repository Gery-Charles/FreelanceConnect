<?php

namespace App\Form;

use App\Entity\Mission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MissionImgType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ image déjà existante (optionnel)
            ->add('imageName', ChoiceType::class, [
                'choices' => $options['existing_images'],
                'required' => false,
                'label' => 'Choisir une image existante',
                'placeholder' => 'Aucune image sélectionnée',
            ])
            // Upload d'image
            ->add('imageFile', VichImageType::class, [
                'mapped' => true,
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'download_label' => 'Télécharger',
                'image_uri' => true,
            ])
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
            'existing_images' => [],
        ]);
    }
}