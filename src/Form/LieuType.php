<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomLieu',null, [
        'label' => 'Nom du lieu :'])
            ->add('rue',null, [
                'label' => 'Rue :'])
            ->add('latitude',null, [
                'label' => 'Latitude :'])
            ->add('longitude',null, [
                'label' => 'Longitude :'])
            ->add('villes',EntityType::class, [
                'class' => Villes::class,
                'choice_label' => 'nomVille'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieux::class,
        ]);
    }
}
