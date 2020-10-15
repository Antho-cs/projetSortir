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
            ->add('lieu', LieuType::class)
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nomCampus']);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
