<?php

namespace Urbicande\PersoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Urbicande\ChronoBundle\Form\ChronologyType;


class PersonnageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('number', null, array(
                'label' => 'Numéro',
                'attr' => array('min' => 1)
            ))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices'   => array('C' => 'Créé', 'S' => 'Pitché', 'D' => 'Développé', 'R' => 'Relu'),
                'required'  => true,
            ))
            ->add('name', null, array('label' => 'Nom'))
            ->add('sex', 'choice', array(
                'label' => 'Sexe',
                'choices' => array('NA' => 'Indéterminé', 'F' => 'Femme', 'H' => 'Homme')
            ))
            ->add('age', null, array(
                'required' => false,
                'attr' => array('min' => 1)
            ))
            ->add('level', null, array(
                'label' => 'Niveau ',
                'required' => false,
            ))
            ->add('job', null, array('required' => false))
            ->add('income', null, array('label' => 'Revenus (/an)', 'required' => false))
            ->add('concept', null, array(
                'label' => 'Concept',
                'attr' => array('placeholder' => 'Une courte présentation du concept du personnage', 'class' => 'rte')
            ))
            ->add('description', null, array(
                'label' => 'Présentation',
                'required' => false,
                'attr' => array('placeholder' => 'L‘histoire du personnage', 'class' => 'rte')
            ))
            ->add('costume', null, array(
                'label' => 'Costume', 
                'required' => false,
                'attr' => array('placeholder' => 'Les indications de costume')
            ))
            ->add('writer', null, array('label' => 'Scénariste référent'))
            ->add('groupes', 'entity', array(
                'class' => 'UrbicandePersoBundle:Groupe',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.name', 'ASC');
                },
                'label' => 'Ajouter le personnage à des groupes',
                'multiple' => true,   // Multiple selection allowed
                'property' => 'name', // Assuming that the entity has a "name" property
                'class'    => 'Urbicande\PersoBundle\Entity\Groupe',
                'required' => false,
            ))
            ->add('events', 'entity', array(
                'label' => 'Ajouter le personnage à des évènements',
                'multiple' => true,   // Multiple selection allowed
                'property' => 'name', // Assuming that the entity has a "name" property
                'class'    => 'Urbicande\ChronoBundle\Entity\Event',
                'required' => false,
            ))
            ->add('intrigues', 'entity', array(
                'label' => 'Ajouter le personnage à des intrigues',
                'multiple' => true,   // Multiple selection allowed
                'property' => 'intrigue.name', // Assuming that the entity has a "name" property
                'class'    => 'Urbicande\IntrigueBundle\Entity\Implication',
                'required' => false,
            ))
            ->add('skills', 'entity', array(
                'label' => 'Ajouter des compétences',
                'multiple' => true,   // Multiple selection allowed
                'class'    => 'Urbicande\PersoBundle\Entity\Skill',
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\PersoBundle\Entity\Personnage',
            'csrf_protection' => true
        ));
    }

    public function getName()
    {
        return 'urbicande_persobundle_personnagetype';
    }
}
