<?php

namespace App\Form;

use App\Entity\Etats;
use App\Entity\Lieux;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nommer la sortie :'])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début :'])
            ->add('duree', null, [
                'label' => 'Durée : '])
            ->add('dateCloture', null, [
                'label' => 'Date de fin : '])
            ->add('nbInscriptionsmax', DateType::class, [
                'label' => 'Nombre maximale des participants : '])
            ->add('descriptionsInfos', null, [
                'label' => 'Description : '])
            ->add('etat')
            ->add('urlPhoto',ButtonType::class, [
                'label' => 'Ajouter une photo',
                'attr' =>[
                    'action'=> '#',
                    'class' => 'imgLoader'
                ]])
            ->add('etat', EntityType::class, [
                'class' => Etats::class,
                'choice_label' => 'libelle'])
            ->add('lieu', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nomLieu'])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
