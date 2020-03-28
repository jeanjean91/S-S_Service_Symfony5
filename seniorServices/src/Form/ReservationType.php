<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('adresse')
            ->add('region')
            ->add('tel')
            ->add('service')
            ->add('User')
           /* ->add('date',DateType::class)*/
            ->add('date',DateType::class, array(
                    'label' => false,
                    'widget' => 'single_text',
                    'attr' => ['class' => 'datepicker'],
                    'required' => false
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
