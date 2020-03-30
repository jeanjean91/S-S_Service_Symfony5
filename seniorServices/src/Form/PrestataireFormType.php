<?php

namespace App\Form;

use App\Entity\Prestataire;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;



use Symfony\Component\Form\CallbackTransformer;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\Type;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use  Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PrestataireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('domaine_activite' ,ChoiceType::class, [

                'attr'=> [

                    ' placeHolder' => 'secteure activiter'
                ],
                'choices' => [
                    'Sante' => 'Sante',
                    'Aide à domicile '=> 'Aide à  domicile',
                    'Traduction' => 'traduction',
                    'Jardinage' => 'Jardinage',
                    'Transport'=> 'Transport'
                ]
            ])
            ->add('specialite')
            /*->add('email')*/
            ->add('user')

            ->add('societe')
            ->add('siret')
            ->add('adresse')
            ->add('tel')
            ->add('pieceIdentite')
            ->add('cv')
            ->add('numSecuSocial')
            ->add('rib');
            /*->add('password',  PasswordType::class);*/
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prestataire::class,
        ]);
    }
}
