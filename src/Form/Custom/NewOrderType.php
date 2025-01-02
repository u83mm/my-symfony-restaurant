<?php

declare(strict_types=1);

namespace App\Form\Custom;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewOrderType extends AbstractType
{
   private int|string $tableNumber;
   private int|string $peopleQty;

    public function __construct() 
    {
        $this->tableNumber = isset($_SESSION['_sf2_attributes']['data']['tableNumber']) ? $_SESSION['_sf2_attributes']['data']['tableNumber'] : "Select";
        $this->peopleQty = isset($_SESSION['_sf2_attributes']['data']['peopleQty']) ? $_SESSION['_sf2_attributes']['data']['peopleQty'] : "Select";
    }    

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {                
        $builder
            ->add('tableNumber', ChoiceType::class, [
                'choices' => [
                    "{$this->tableNumber}" => "",
                    '1'      => 1,
                    '2'      => 2,
                    '3'      => 3,
                    '4'      => 4,
                    '5'      => 5,
                    '6'      => 6,
                    '7'      => 7,
                    '8'      => 8,
                    '9'      => 9,
                    '10'     => 10,
                ],
            ])
            ->add('peopleQty', ChoiceType::class, [
                'choices' => [
                    "{$this->peopleQty}" => "",
                    '1'      => 1,
                    '2'      => 2,
                    '3'      => 3,
                    '4'      => 4,
                    '5'      => 5,
                    '6'      => 6,
                    '7'      => 7,
                    '8'      => 8,
                    '9'      => 9,
                    '10'     => 10,
                    '11'     => 11,
                    '12'     => 12,
                    '13'     => 13,
                    '14'     => 14,
                    '15'     => 15,
                ]
            ])            
            ->add('order', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success',
                ]
            ])           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,                  
        ]);
    }
}
