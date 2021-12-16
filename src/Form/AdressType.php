<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adress',TextType::class,[
                'label' => 'Rue et numéro'
            ])
            ->add('cp',TextType::class,[
                'label' => 'Code postal'
            ])
            ->add('city',TextType::class,[
                'label' => 'Ville'
            ])
            ->add('firstname',TextType::class,[
                'label' => 'Prenom'
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Nom'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
