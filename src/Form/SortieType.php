<?php

namespace App\Form;

use App\Entity\Sorties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie :',
                'required' => true,
            ])
            ->add('datedebut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie :',
                'widget' => 'single_text',
                'required' => true,
                'model_timezone' => 'Europe/Paris'

            ])
            ->add('datecloture', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Date limite de l\'inscription :',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('duree', IntegerType::class,[
                'label' => 'Durée :',
                'empty_data' => 0,
            ])
            ->add('nbinscriptionsmax', TextType::class, [
                'label' => 'Nombre de places :',
                'empty_data' => 0,
            ])
            ->add('descriptioninfos', TextareaType::class, [
                'label' => 'Description et infos :',
                'required' => false,
                'attr' => ['rows' => '5']
            ])
            ->add('lieu' , LieuxType::class)
            ->add('campus', CampusType::class)
            ->add('enregistree', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'mr-3 btn btn-primary']])
            ->add('publier', SubmitType::class, ['label' => 'Publier', 'attr' => ['class' => 'mr-3 btn btn-success']])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
