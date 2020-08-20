<?php


namespace App\Form;


use App\Data\SearchData;
use App\Entity\Campus;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nomCampus',
                'label' => false,
                'placeholder' => 'Rechercher par Campus',
                'required' => false
            ])
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher par mots...'
                ]
            ])
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false,
                'label' => 'Date de début'
            ])

            ->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false,
                'label' => 'Date de fin'
            ])

            ->add('sortieOrganisateur', ChoiceType::class,[
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'choices' => [
                    'Sorties dont je suis l\'organisateur/trice' => true
                ]
            ])
            ->add('sortieInscrit', ChoiceType::class,[
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'choices' => [
                    'Sorties auxquelles je suis inscrit/e' => true
                ]
            ])
            ->add('noInscrit', ChoiceType::class,[
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'choices' => [
                    'Sorties auxquelles je ne suis pas inscrit/e' => true
                ]
            ])
            ->add('datePasse', ChoiceType::class,[
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'choices' => [
                    'Sorties passées' => true
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}