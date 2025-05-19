<?php

namespace App\Form;

use App\Entity\Dish;
use App\Entity\DishDay;
use App\Entity\DishMenu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Contracts\Translation\TranslatorInterface;

class DishType extends AbstractType
{        
    public function __construct(
        private TranslatorInterface $translator,                                          
    )   
    {             
    }
   

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {       
        $builder
            ->add('name', null, [
                'label' => ucfirst($this->translator->trans('name')) . ":"
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'cols'  => "30",
                    'rows'  => "10",
                ],
                'data' => $this->translator->trans($options['data']->getDescription() ?? '')               
            ])            
            ->add('price', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'step' => '0.01',
                    'min' =>    "0",
                    'max' =>    "5000",
                ],
                'label' => ucfirst($this->translator->trans('price')) . ":"              
            ])
            ->add('image', null, [
                'mapped'    => false,
                'label'     => false,
                'attr'      => [
                    'hidden'    => true,
                ],
            ])
            ->add('available', CheckboxType::class, [
                'label' => false,
                'attr' => [
                    'value' => 0,
                ],
                'required' => false,
            ])            
            ->add('dishDay', EntityType::class, [
                'class' => DishDay::class,
                'choice_label' => function(Dishday $dishDay) {
                    return ucfirst($this->translator->trans($dishDay->getCategoryName()));
                }
            ])
            ->add('dishMenu', EntityType::class, [
                'class' => DishMenu::class,
                'choice_label' => function(DishMenu $dishMenu) {
                    return ucfirst($this->translator->trans($dishMenu->getMenuCategory()));
                }
            ])          
            ->add('picture', null, [
                'mapped' => false,
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
