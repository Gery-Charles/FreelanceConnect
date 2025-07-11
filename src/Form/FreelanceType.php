<?php

namespace App\Form;

use App\Entity\Freelance;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FreelanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email',
                    'required' => true,
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom',
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom',
                'attr' => [
                    'placeholder' => 'Prenom',
                ]
            ])
            ->add('competances')
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Mot de passe',
                ]
            ])
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Freelance::class,
        ]);
    }
}
