<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('time', ChoiceType::class, [
                'choices' => [
                    'Select' => "",
                    '12:00'  => '12:00',
                    '12:30'  => '12:30',
                    '13:00'  => '13:00',
                    '13:30'  => '13:30',
                    '14:00'  => '14:00',
                    '14:30'  => '14:30',
                    '15:00'  => '15:00',
                ]
            ])
            ->add('name')
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
                    '16'     => 16,
                    '17'     => 17,
                    '18'     => 18,
                    '19'     => 19,
                    '20'     => 20
                ]
            ])
            ->add('email')
            ->add('comment')
            ->add('send', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-secondary',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
