<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AddressFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email',EmailType :: class,[
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none my-3'
               ) ,
            'label' => 'Email:',
            'required' => true,
        ])
        ->add('password', RepeatedType::class,[
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none my-3'
               ) ,
            'type' => PasswordType::class,
            'required' => true,
            'first_options' => [
                'label' => 'Password :',
            ],
            'second_options' => [
                'label' => 'Repeat your password :',
                'attr' => array(
                    'class' => 'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none my-3')
            ]

        ])
        ->add('phone', TelType::class, [
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none my-3'
               ) ,
            'label' => 'Phone :',
            'required' => false,
        ])
        ->add('firstname',TextType::class, [
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none my-3'
               ) ,
            'label' => 'Firstname :',
            'required' => false,
        ])
        ->add('lastname', TextType::class, [
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none my-3'
               ) ,
            'label' => 'Lastname :',
            'required' => false,
        ])
        ->add('address', AddressFormType::class, [
            'attr' => array(
                'class' => 'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none my-3'
               ) ,
            'label' => 'Your Address',
            'required' => false,
        ])
        // ->add('send', SubmitType::class, [
        //     'label' => 'Submit',
        // ])
       
    ;

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
