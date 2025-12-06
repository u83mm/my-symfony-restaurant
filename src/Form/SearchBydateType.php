<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class SearchBydateType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label'  => ucfirst($this->translator->trans('date'))
            ])
            ->add('time', ChoiceType::class, [
                'choices'   => [
                    ucfirst($this->translator->trans('select')) => "",
                    '12:00'  => '12:00',
                    '12:30'  => '12:30',
                    '13:00'  => '13:00',
                    '13:30'  => '13:30',
                    '14:00'  => '14:00',
                    '14:30'  => '14:30',
                    '15:00'  => '15:00',
                ],
                'required'  => false,
                'label'     => ucfirst($this->translator->trans('time'))
            ])
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
            // Configure your form options here
        ]);
    }
}
