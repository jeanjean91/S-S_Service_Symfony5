<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('adresse')
            ->add('region')
            ->add('tel')
             ->add('service') 
            /* ->add('service', CollectionType::class, array(
        'entry_type'   => ServiceFormType::class,
         'label' => false,
         'allow_add'    => true,
        'allow_delete' => true 
      )) */
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
