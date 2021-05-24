<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\OrderShippingDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class TestOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('total', NumberType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('discount', TextType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('state', TextType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('orderItems', CollectionType::class, [
                'constraints' => [
                    new NotNull()
                ],
                'entry_type'   => OrderItem::class,
            ])
            ->add('orderShippingDetail', CollectionType::class, [
                'constraints' => [
                    new NotNull()
                ],
                'entry_type'   => OrderShippingDetail::class,
            ]);
    }

    public function consifgureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}