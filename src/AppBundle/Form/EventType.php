<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('description')
            ->add('eventDate')
            ->add('eventTime')
            ->add('place', EntityType::class, [
                'placeholder' => 'Избери локация',

                'class' => 'AppBundle\Entity\Place',

                'multiple' => false,

                'expanded' => false,

                'choice_label' => 'name'
            ])
            ->add('EventCategory', EntityType::class, [
                'placeholder' => 'Избери категория',

                'class' => 'AppBundle\Entity\EventCategory',

                'multiple' => false,

                'expanded' => false,

                'choice_label' => 'name'
            ])
            ->add('submit', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_event';
    }


}
