<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomLieu', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nomLieu',
                'label' => 'Lieu :',
                'placeholder' => 'Choisissez votre lieu...'
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue :',
            ])
            ->add('latitude', TextType::class, [
                'label' => 'Latitude :',
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Longitude :',
            ])
            ->add('ville', VilleType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieux::class,
        ]);
    }
}
