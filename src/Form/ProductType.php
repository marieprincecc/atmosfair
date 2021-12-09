<?php

namespace App\Form;

use App\Entity\Rooms;
use App\Entity\Product;
use App\Entity\Polluting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class,[
            'label' => 'Nom du produit'
            ])

        ->add('description',TextType::class,[
            'label' => 'Description du produit'
            ])

            ->add('greatness',IntegerType::class,[
                'label' => 'Taille'                
                ])

            ->add('pot',IntegerType::class,[
                'label' => 'Diametre du pot'                
                ])

            ->add('toxicity',TextType::class,[
                'label' => 'Toxicité',                
                ])

            ->add('familly',TextType::class,[
                'label' => 'Famille',                
                ])
            ->add('price',MoneyType::class,[
                'divisor' => 100,
                'currency' => 'EUR',
                ])

            ->add('water' ,IntegerType::class,[
                'label' => 'Besoin en haut',                
                ])
            ->add('entretient' ,IntegerType::class,[
                'label' => 'Difficulté d\'entretient',                
                ])

            ->add('file',FileType::class,[
                'label' => 'Ajouter une image',
                'mapped' => false,
                'constraints' => [
                new File([
                'maxSize' => '1m'
                ])
                ],
                ])

            ->add('pollutings' ,EntityType::class,[
                'label' => 'Polluant',  
                'class' => Polluting::class,
                'expanded' => true,
                'multiple' => true              
                ])

            ->add('rooms' ,EntityType::class,[
                'label' => 'Salles',  
                'class' => Rooms::class,  
                'expanded' => true, 
                'multiple' => true           
                ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
