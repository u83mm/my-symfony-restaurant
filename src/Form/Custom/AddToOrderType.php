<?php

declare(strict_types=1);

namespace App\Form\Custom;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('qty', IntegerType::class, [
                'attr' => [
                    'min' => 0,                    
                ]
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Select'            => "",
                    'Aperitifs'         => 'aperitifs',
                    'Firsts'            => 'firsts',
                    'Seconds'           => 'seconds',
                    'Desserts'          => 'desserts',
                    'Drinks'            => 'drinks',
                    'Coffees / Liquors' => 'coffees',
                ]              
            ])
            ->add('order', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success',
                ]
            ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,            
        ]);
    }
}
