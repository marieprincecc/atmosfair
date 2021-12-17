<?php

namespace App\Form;

use App\Entity\Orderbuy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class OrderbuyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('total',MoneyType::class,[
                'divisor' => 100,
                'currency' => 'EUR',
                ])
            ->add('totalTTC',MoneyType::class,[
                'divisor' => 100,
                'currency' => 'EUR',
                ])
            ->add('status',TextType::class,[
                'label' => 'status',                
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orderbuy::class,
        ]);
    }
}
