<?php

declare(strict_types=1);

namespace App\Form\Custom;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToOrderType extends AbstractType
{     
    private array $select = [];
    private Session $session;
    
    public function __construct()
    {
        // Set up the select options   
        $this->session = new Session();         
        $this->select = $this->setup();              
    }

    public function setup() : array
    {
        // Get the locale from the session                       
        $this->select = $this->session->get('_locale') == 'en' ? [
            'Select' => "",
                'Aperitifs'         => 'aperitifs',
                'Firsts'            => 'firsts',
                'Seconds'           => 'seconds',
                'Desserts'          => 'desserts',
                'Drinks'            => 'drinks',
                'Coffees / Liquors' => 'coffees',
            ] : [                                        
            'Seleccionar' => "",
                'Aperitivos'        => 'aperitifs', 
                'Primeros'          => 'firsts',
                'Segundos'          => 'seconds',
                'Postres'           => 'desserts',
                'Bebidas'           => 'drinks',
                'Cafés / Licores'   => 'coffees',
            ];

        return $this->select;
    }    
   
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {        
        $builder
                ->add('qty', IntegerType::class, [
                'attr' => [
                    'min' => 0,                    
                ]
            ])
            ->add('category', ChoiceType::class, [
                'choices' => $this->select,             
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
