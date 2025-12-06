<?php

namespace App\Form;

use App\Entity\DishDay;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class DishDayType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categoryName', null, [
                'label' => ucfirst($this->translator->trans('name')) . ":"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DishDay::class,
        ]);
    }
}
