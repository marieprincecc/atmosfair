<?php

namespace App\Form;

use App\Entity\Orderdetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class OrderdetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity',IntegerType::class,[
                'label' => 'Quantité'                
                ])
            ->add('priceTotal', MoneyType::class,[
                'divisor' => 100,
                'currency' => 'EUR',
                ])
            
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orderdetails::class,
        ]);
    }
}
