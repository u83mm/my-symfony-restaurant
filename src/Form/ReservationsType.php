<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ReservationsType extends AbstractType
{        
    // The session is used to get the locale for the placeholder
    private Session $session;
    private array $timeSelect = [            
        '12:00'  => '12:00',
        '12:30'  => '12:30',
        '13:00'  => '13:00',
        '13:30'  => '13:30',
        '14:00'  => '14:00',
        '14:30'  => '14:30',
        '15:00'  => '15:00',
    ];

    private array $peopleSelect = [        
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
    ];

    private string $timeSelectPlaceholder = '';
    private string $peopleSelectPlaceholder = '';

    public function __construct(private TranslatorInterface $translator)
    {
        // Set up the session
        $this->session = new Session();
        
        // Set up the time and people select placeholders
        $this->timeSelectPlaceholder = $this->session->get('_locale') == 'en' ? 'Select' : 'Seleccionar';
        $this->peopleSelectPlaceholder = $this->session->get('_locale') == 'en' ? 'Select' : 'Seleccionar';
    }    

   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {        
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('time', ChoiceType::class, [
                'choices' => $this->timeSelect,
                'placeholder' => $this->timeSelectPlaceholder,
            ])
            ->add('name', null, [
                'label' => ucfirst($this->translator->trans('name')) . ":"
            ])
            ->add('peopleQty', ChoiceType::class, [
                'choices' => $this->peopleSelect,
                'placeholder' => $this->peopleSelectPlaceholder,
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
