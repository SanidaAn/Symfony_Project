<?php

namespace App\Form;

use App\Entity\Pizza;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('description', TextType::class,[
                'label' => 'Description',
                'required' => true,])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'required' => true,
            ])
            ->add('imageUrl', UrlType::class, [
                'label' => 'Image',
                'required' => true,
            ])
            // ->add('send', SubmitType::class, [
            //     'label' => 'envoyer',
            // ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pizza::class,
        ]);
    }
}
