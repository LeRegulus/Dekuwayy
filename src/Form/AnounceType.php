<?php

namespace App\Form;

use App\Entity\Anounce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
            ->add('isAvailable', null, [
                'label' => 'Disponibilité :',
            ])
            ->add('coverImage', FileType::class, [
                'label' => 'Image de couverture :',
                'required' => false
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
