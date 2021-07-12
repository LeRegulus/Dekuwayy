<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,[
                'label' => 'Prenom:',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre Prenom',
                    ]),
                ],
            ] )
            ->add('lastName', null,[
                'label' => 'Nom:',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre Nom',
                    ]),
                ],
            ] )
            ->add('address', null,[
                'label' => 'Adresse:',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre Adresse',
                    ]),
                ],
            ] )
            ->add('profilImage', FileType::class, [
                'label' => 'Photo de Profile :',
                'required' => false
            ])
            ->add('phon', TelType::class, [
                'label' => 'Numero de Telephone:',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
