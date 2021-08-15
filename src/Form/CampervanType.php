<?php

namespace App\Form;

use App\Entity\Campervan;
use App\Entity\Station;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampervanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('carNumber', TextType::class, [
                'required' => true
            ])
            ->add('brand', TextType::class, [
                'required' => true,
            ])
            ->add('isOnTheRoad', CheckboxType::class, [
                'data' => false,
                'required' => false,
                'attr' => [
                    'value' => '0'
                ]
            ])
            ->add('atStation', EntityType::class, [
                'class' => Station::class,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Campervan::class,
        ]);
    }
}
