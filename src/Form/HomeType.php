<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class, [
                'class'=> Campus::class,
                'choice_label'=>'nomCampus',
                'label'=> 'Campus: ',
                'placeholder'=>'Veuillez choisir un campus...',
                'required'=>false
            ])
            ->add('nomSortie', TextType::class, [
                'label'=>'Nom de la sortie : ',
                'required'=>false
            ])
            ->add('dateDebut', DateType::class, [
                'label'=> 'Entre: ',
                'html5'=>true,
                'widget'=>'single_text',
                'required'=>false
            ])
            ->add('dateCloture', DateType::class, [
                'label'=> 'Et: ',
                'html5'=>true,
                'widget'=>'single_text',
                'required'=>false,
                'constraints'=>[
                    new GreaterThan(['propertyPath'=>'parent.all[dateDebut].data'])
                ]
            ])
            ->add('organisateur', CheckboxType::class, ['label'=>'Sorties dont je suis l\'organisateur',
                'required'=>false])
            ->add('inscrit', CheckboxType::class, ['label'=>'Sorties auxquelles je suis inscrit',
                'required'=>false])
            ->add('noninscrit', CheckboxType::class, ['label'=>'Sorties auxquelles je ne suis pas inscrit',
                'required'=>false])
            ->add('outdated', CheckboxType::class, ['label'=>'Sorties pass??es',
                'required'=>false])
            ->add('search', SubmitType::class, [
                'label'=>'Rechercher'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
