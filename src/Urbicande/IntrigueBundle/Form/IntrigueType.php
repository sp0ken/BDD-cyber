<?php

namespace Urbicande\IntrigueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Urbicande\ChronoBundle\Form\ChronologyType;
use Urbicande\PersoBundle\Form\SkillType;

class IntrigueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Nom'))
            ->add('writer', null, array('label' => 'Assigner à'))
            ->add('number', null, array('label' => 'Numéro'))
            ->add('type')
            ->add('status', 'choice', array(
                'choices'   => array('C' => 'Créé', 'S' => 'Pitché', 'D' => 'Développé', 'R' => 'Relu'),
                'required'  => true,
            ))
            ->add('synopsis', new SynopsisType())
            ->add('plot', new PlotType())
            ->add('implications', 'collection', array(
                'type' => new ImplicationType(),
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Implications'
            ))
            ->add('events', 'entity', array(
                'label' => 'Ajouter des évènements à cette intrigue',
                'multiple' => true,   // Multiple selection allowed
                'property' => 'name', // Assuming that the entity has a "name" property
                'class'    => 'Urbicande\ChronoBundle\Entity\Event',
                'required' => false,
            ))
            ->add('objects', 'entity', array(
                'label' => 'Ajouter des objets à cette intrigue',
                'multiple' => true,   // Multiple selection allowed
                'class'    => 'Urbicande\IntrigueBundle\Entity\Object',
                'required' => false,
            ))
            ->add('skills', 'collection', array(
                'type' => new SkillType(),
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Compétences'
            ))
            ->add('rules', 'collection', array(
                'type' => new RuleType(),
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Règles'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\IntrigueBundle\Entity\Intrigue'
        ));
    }

    public function getName()
    {
        return 'urbicande_intriguebundle_intriguetype';
    }
}
