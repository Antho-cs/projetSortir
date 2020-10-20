<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('datedebut', DateType::class, [
                'label'=> 'Date de début : ',
                'html5'=>true,
                'widget'=>'single_text',
                'required'=>false
            ])
            ->add('datecloture', DateType::class, [
                'label'=> 'Date de fin d\'inscription : ',
                'html5'=>true,
                'widget'=>'single_text',
                'required'=>false
            ])
            ->add('condition', ChoiceType::class, [
                'label'=>'Condition :',
                'placeholder'=>'Veuillez choisir une condition...',
                'required'=>false
            ])
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
