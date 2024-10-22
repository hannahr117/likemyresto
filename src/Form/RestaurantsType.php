<?php

namespace App\Form;

use App\Entity\Owners;
use App\Entity\Restaurants;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('postal_code')
            ->add('description')
            ->add('owner', EntityType::class, [
                'class' => Owners::class,
                'choice_label' => function ($owner) {
                    return $owner->getFirstName() . ' ' . $owner->getLastName();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurants::class,
        ]);
    }
}
