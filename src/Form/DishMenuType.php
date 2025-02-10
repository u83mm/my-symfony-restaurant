<?php

namespace App\Form;

use App\Entity\DishMenu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DishMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('menuCategory', null, [
                'label' => 'Category',
            ])
            ->add('menuEmoji', null, [
                'label' => 'Emoji',
                'attr' => [
                    'readonly' => true,
                    'class'    => 'show-emoji form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DishMenu::class,
        ]);
    }
}
