<?php

namespace App\Form;

use App\Entity\Etats;
use App\Entity\Lieux;
use App\Entity\Sorties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nommer la sortie :'])
            ->add('dateDebut', null, [
                'label' => 'Date de début :'])
            ->add('duree', null, [
                'label' => 'Durée : '])
            ->add('dateCloture', null, [
                'label' => 'Date de fin : '])
            ->add('nbInscriptionsmax', null, [
                'label' => 'Nombre maximale des participants : '])
            ->add('descriptionsInfos', null, [
                'label' => 'Description : '])
            ->add('etat')
            ->add('urlPhoto', null, [
                'label' => 'Ajouter une photo'])
            ->add('etat', EntityType::class, [
                'class' => Etats::class,
                'choice_label' => 'libelle'])
            ->add('lieu', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nomLieu'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
