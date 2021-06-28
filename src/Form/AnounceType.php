<?php

namespace App\Form;

use App\Entity\Anounce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnounceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre :'
            ])
            ->add('desription', TextareaType::class, [
                'label' => 'Description :'
            ])
            ->add('price', null, [
                'label' => 'Prix:'
            ])
            ->add('address', null, [
                'label' => 'Adresse :'
            ])
            ->add('rooms', null, [
                'label' => 'Nombre de Chambres :'
            ])
            ->add('isAvailable', ChoiceType::class, [
                'label' => 'Disponibilité :',
                'choices'  => [
                    'Disponible' => true,
                    'Non Disponible' => false,
                ]
            ])
            ->add('intro', null, [
                'label' => 'Introduction:'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Anounce::class,
        ]);
    }
}
