<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\DependencyInjection\Compiler\RepeatedPass;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
            ->add('email',EmailType::class,array('label'=>'Email'))
            ->add('username',TextType::class,array('label'=>'Nom Utilisateur'))
            ->add('roles',CollectionType::class,array(
                'label'=>'Role',
                'entry_type'=> ChoiceType::class,
                'entry_options'=>array('choices'=>array('User'=>'ROLE_USER','Admin'=>'ROLE_ADMIN'))
            ))
            ->add('password',RepeatedType::class,array(
                'type' => PasswordType::class,
                'first_options' =>array('label' => 'Mot de Passe'),
                'second_options' => array('label' => 'Confirmer le Mot de Passe')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }
}