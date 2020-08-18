<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etats;
use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('datedebut', DateType::class, [
                'label' => 'Date et heure de la sortie :',
                'widget' => 'single_text',
                'required' => true,
                'format' => 'yyyy-MM-dd',
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
                'required' => false
            ])
            ->add('lieu' , LieuxType::class)
            ->add('campus', CampusType::class)
            ->add('enregistree', SubmitType::class, ['label' => 'Enregistrée'])
            ->add('publier', SubmitType::class, ['label' => 'Publier'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
