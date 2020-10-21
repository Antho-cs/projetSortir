<?php

namespace App\Form;

use App\Entity\Participants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\SubmitButton;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpProfileUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Pseudo')
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('mail')
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nomCampus',
            ])
            ->add('password',RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe ne correspond pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options'  => ['label' => 'password'],
                'second_options' => ['label' => 'Confirmation password'],
            ])
            ->add('urlPhoto', FileType::class, ['label'=>'Choisissez votre avatar:',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[new Image([
                        'maxSize' => '8024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Seuls les formats PNG et JPG sont acceptés' ,
                    ])]
            ])
            ->add('enregistrer', SubmitType::class, [
                'label'=> 'Enregistrer'
            ])
            ->add('retour', SubmitType::class, [
                'label'=> 'Retour'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}
