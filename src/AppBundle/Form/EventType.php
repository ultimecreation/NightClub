<?php

namespace AppBundle\Form;

use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
        ->add('title',TextType::class,array('label'=>'Titre'))
        ->add('date',DateTimeType::class,array('label'=>'Date'))
        ->add('description',TextareaType::class,array('label'=>'Description'))
        ->add('image',FileType::class,array('label'=>'Image','data_class'=> null,'required'=>false))
        ->add('displayEvent',ChoiceType::class,array(
            'label'=>'Publication',
            'choices'=>array('Oui'=>1,'Non'=>0)
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=> Event::class,
        ));
    }
}