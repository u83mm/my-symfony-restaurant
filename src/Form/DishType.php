<?php

namespace App\Form;

use App\Entity\Dish;
use App\Entity\DishDay;
use App\Entity\DishMenu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Contracts\Translation\TranslatorInterface;

class DishType extends AbstractType
{        
    public function __construct(
        private TranslatorInterface $translator,
        private EntityManagerInterface $em,
        private array $dishDayChoices = [],
        private array $dishMenuChoices = []                  
        
    )   
    {   
        // Set up the option fields for the select elements       
        foreach ($this->em->getRepository(DishDay::class)->findAll() as $key => $value) {    
            $this->dishDayChoices[ucfirst($translator->trans($value->getCategoryName()))] = $key;
        }       

        foreach ($this->em->getRepository(DishMenu::class)->findAll() as $key => $value) {
            $this->dishMenuChoices[ucfirst($translator->trans($value->getMenuCategory()))] = $key;
        }
    }

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
            ->add('dishDay', ChoiceType::class, [                
                'choices' => $this->dishDayChoices
            ])
            ->add('dishMenu', ChoiceType::class, [
                'label' => 'Category',
                'choices' => $this->dishMenuChoices
            ])
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
