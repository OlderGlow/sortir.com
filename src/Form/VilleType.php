<?php

namespace App\Form;

use App\Entity\Villes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal :',
            ])
            ->add('nomVille', TextType::class, [
                'label' => 'Ville :'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Villes::class,
        ]);
    }
}
