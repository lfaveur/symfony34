<?php

namespace AppBundle\Form;

use AppBundle\Entity\Departement;
use AppBundle\Entity\Region;
use AppBundle\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('region', EntityType::class,array(
                'class' => 'AppBundle\Entity\Region',
                'placeholder' => 'Séléctionner une région',
                'mapped' => false,
                'required' => false
            ));
        $builder->get('region')->addEventListener(FormEvents::POST_SUBMIT,
            function(FormEvent $event){
                $form = $event->getForm();
                $this->addDepartementField($form->getParent(),$form->getData());
                
        });
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function(FormEvent $event){
                $data = $event->getData();
                $ville = $data->getVille();
                $form = $event->getForm();

                /** @var Ville $ville */
                if($ville){
                    $departement = $ville->getDepartement();
                    $region = $departement->getRegion();
                    $this->addDepartementField($form,$region);
                    $this->addVilleField($form,$departement);
                    $form->get('region')->setData($region);
                    $form->get('departement')->setData($departement);
                } else {
                    $this->addDepartementField($form,null);
                    $this->addVilleField($form,null);
                }
            }
        );
    }

    /**
     * @param FormInterface $form
     * @param Region|null $region
     */
    private function addDepartementField(FormInterface $form,?Region $region){
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'departement',
            EntityType::class,
            null,
            array(
                'class' => 'AppBundle\Entity\Departement',
                'placeholder' => $region ? 'Séléctionner un département' : 'Séléctionner une région',
                'mapped' => false,
                'required' => false,
                'auto_initialize' => false,
                'choices' => $region ? $region->getDepartements() : []
            )
        );

        $builder->addEventListener(FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $this->addVilleField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    /**
     * @param FormInterface $form
     * @param Departement|null $departement
     */
    private function addVilleField(FormInterface $form, ?Departement $departement){
        $form->add('ville', EntityType::class,[
            'class' => 'AppBundle\Entity\Ville',
            'placeholder' => $departement ? 'Sélectionner une ville' : 'Selectionner d\'abord un departement',
            'choices' => $departement ? $departement->getVilles() : []
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Medecin'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_medecin';
    }


}
