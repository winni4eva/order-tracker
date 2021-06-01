<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itemName', TextType::class, ['attr' => ['placeholder' => 'item name']])
            ->add('itemPrice', NumberType::class, ['attr' => ['placeholder' => 'price']])
            ->add('itemQuantity', TextType::class, ['attr' => ['placeholder' => 'quantity']])
            ->add('country', TextType::class, ['attr' => ['placeholder' => 'country']])
            ->add('state', TextType::class, ['attr' => ['placeholder' => 'state']])
            ->add('zip', TextType::class, ['attr' => ['placeholder' => 'zip code']])
            ->add('street', TextType::class, ['attr' => ['placeholder' => 'street']])
            ->add('phone', TextType::class, ['attr' => ['placeholder' => 'phone']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true
        ]);
    }
}
