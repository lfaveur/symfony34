<?php

namespace AppBundle\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use ReCaptcha\ReCaptcha;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('dateParution')
            ->add('text', CKEditorType::class, array(
                'config_name' => 'my_config',
                'config'      => array('uiColor' => '#ffffff'),
            ))
//            ->add('themes', CollectionType::class,
//                array (
//                    'allow_add' => true,
//                    'prototype' => true,
//                    'attr' => array(
//                        'class' => 'my-selector',
//                    ),
//                )
//            )
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Livre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_livre';
    }


}
