<?php

namespace App\Form;

use App\Entity\Dish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class DishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')            
            ->add('price', NumberType::class, [
                'html5' => true,                
            ])
            ->add('available', CheckboxType::class, [
                'label' => false,
                'attr' => [
                    'value' => 0,
                ],
                'required' => false,
            ])
            ->add('dishDay')
            ->add('dishMenu')
            ->add('picture', FileType::class, [
                'label'     => 'Select Image',                
                'required'  => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypesMessage' => 'Please upload a valid IMG',
                    ])
                ]
            ])            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dish::class,
        ]);
    }
}
