<?php

namespace Urbicande\ChronoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start_date', 'date', array(
                'label' => 'Date de début l‘évènement (en chiffre)',
                'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'widget' => 'text'
                ))
            ->add('end_date', 'date', array(
                'label' => 'Date de fin l‘évènement (en chiffre, optionnel)',
                'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'widget' => 'text',
                'required' => false
                ))
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', null, array(
                'label' => 'Description',
                'required' => false,
                'attr' => array('placeholder' => 'Description de l‘évènement', 'class' => 'rte')
            ))
            ->add('players', 'entity', array(
                'label' => 'Ajouter cet évènement aux personnages',
                'multiple' => true,   // Multiple selection allowed
                'class'    => 'Urbicande\PersoBundle\Entity\Personnage',
                'required' => false,
            ))
            ->add('groupes', 'entity', array(
                'label' => 'Ajouter cet évènement aux groupes',
                'multiple' => true,   // Multiple selection allowed
                'class'    => 'Urbicande\PersoBundle\Entity\Groupe',
                'required' => false,
            ))
            ->add('intrigues', 'entity', array(
                'label' => 'Ajouter cet évènement aux intrigues',
                'multiple' => true,   // Multiple selection allowed
                'class'    => 'Urbicande\IntrigueBundle\Entity\Intrigue',
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\ChronoBundle\Entity\Event'
        ));
    }

    public function getName()
    {
        return 'urbicande_chronobundle_eventtype';
    }
}
