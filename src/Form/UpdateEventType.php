<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom de la sortie :'
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => 'Date de début :',
                'html5'=>true,
                'widget'=>'single_text',
                'required'=>false
            ])
            ->add('duree', null, [
                'label' => 'Durée en minutes: '])
            ->add('dateCloture', DateTimeType::class, [
                'label' => 'Date de fin : ',
                'html5'=>true,
                'widget'=>'single_text',
                'required'=>false
            ])
            ->add('nbInscriptionsmax', null, [
                'label' => 'Nombre maximal des participants : '])
            ->add('descriptionsInfos', TextType::class, [
                'label' => 'Description : '])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nomCampus'])
            ->add('lieu', LieuType::class)
            ->add('enregistrer', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('supprimer', SubmitType::class, ['label' => 'Supprimer'])
            ->add('retourner', SubmitType::class, ['label' => 'Retour'])
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
