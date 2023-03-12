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
            ->add('description', null, [
                'attr' => [
                    'cols'  => "30",
                    'rows'  => "10",
                ]
            ])            
            ->add('price', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'step' => '0.01',
                    'min' =>    "0",
                    'max' =>    "5000",
                ],               
            ])
            ->add('image', null, [
                'mapped'    => false,
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
            ->add('picture', null, [
                'label' => false,
                'attr' => [
                    'hidden' => true
                ]
            ])
            ->add('select_picture', FileType::class, [
                'label'     => 'Select Image',                
                'required'  => false,
                'mapped'    => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypesMessage' => 'Please upload a valid IMG',
                    ])
                ],
                'data_class' => null,
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
