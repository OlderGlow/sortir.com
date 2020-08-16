<?php


namespace App\Form;


use App\Data\SearchData;
use App\Entity\Campus;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                'label' => 'Campus',
                'placeholder' => 'Rechercher par Campus',
                'required' => false
            ])
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false
            ])

            ->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false
            ])

            ->add('sortieOrganisateur', CheckboxType::class,[
                'label' => 'Sorties dont je suis l\'organisateur/trice',
                'required' => false
            ])
            ->add('sortieInscrit', CheckboxType::class,[
                'label' => 'Sorties auxquelles je suis inscrit/e',
                'required' => false
            ])
            ->add('noInscrit', CheckboxType::class,[
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                'required' => false
            ])
            ->add('datePasse', CheckboxType::class,[
                'label' => 'Sorties passées',
                'required' => false
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