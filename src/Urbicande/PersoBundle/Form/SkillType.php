<?php

namespace Urbicande\PersoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', null, array(
                'label' => 'Description',
                'attr' => array('class' => 'rte')
            ))
            ->add('creation_point', null, array(
                'label' => 'Points de création',
                'attr' => array('value' => 0)
            ))
            ->add('writer', null, array('label' => 'Scénariste référent', 'required' => true))
            ->add('players', 'entity', array(
                'label' => 'Personnages ayant la compétence',
                'multiple' => true,   // Multiple selection allowed
                'class'    => 'Urbicande\PersoBundle\Entity\Personnage',
                'required' => false,
            ))
            ->add('intrigues', 'entity', array(
                'label' => 'Intrigues nécessitant la compétence',
                'multiple' => true,   // Multiple selection allowed
                'class'    => 'Urbicande\IntrigueBundle\Entity\Intrigue',
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\PersoBundle\Entity\Skill'
        ));
    }

    public function getName()
    {
        return 'urbicande_persobundle_skilltype';
    }
}
