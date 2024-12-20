<?php

namespace App\Form;

use App\Entity\Orders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tableNumber', ChoiceType::class, [
                'choices' => [
                    'Select' => "",
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
                    'Select' => "",
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
            ->add('aperitifs')
            ->add('aperitifsQty')
            ->add('aperitifsFinished')
            ->add('firsts')
            ->add('firstsQty')
            ->add('firstsFinished')
            ->add('seconds')
            ->add('secondsQty')
            ->add('secondsFinished')
            ->add('desserts')
            ->add('dessertsQty')
            ->add('dessertsFinished')
            ->add('drinks')
            ->add('drinksQty')
            ->add('drinksFinished')
            ->add('coffees')
            ->add('coffeesQty')
            ->add('coffeesFinished')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
