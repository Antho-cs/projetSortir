<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etats;
use App\Entity\Lieux;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nommer la sortie :'])
            ->add('dateDebut', DateTimeType::class, [
                'label' => 'Date de début :'])
            ->add('duree', null, [
                'label' => 'Durée : '])
            ->add('dateCloture', DateTimeType::class, [
                'label' => 'Date de fin : '])
            ->add('nbInscriptionsmax', null, [
                'label' => 'Nombre maximale des participants : '])
            ->add('descriptionsInfos', TextType::class, [
                'label' => 'Description : '])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nomCampus'])
            ->add('lieu', LieuType::class)
            ->add('enregistrer', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('publier', SubmitType::class, ['label' => 'Publier'])
            ->add('annuler', SubmitType::class, ['label' => 'Annuler'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
