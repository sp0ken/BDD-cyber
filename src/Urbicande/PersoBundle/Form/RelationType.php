<?php

namespace Urbicande\PersoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class RelationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('knower', null, array('label' => 'Personnage qui connait', 'required' => true))
            ->add('type', 'entity', array(
                'label' => 'Type',
                'class' => 'UrbicandePersoBundle:RelationType',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC');
                },
                'required' => false
            ))
            ->add('knowee', null, array('label' => 'Personnage connu', 'required' => true))
            ->add('detail', null, array(
                'label' => 'Détail de cette relation en particulier', 
                'required' => false,
                'attr' => array('placeholder' => 'Les détails de cette relation en particulier', 'class' => 'rte')
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\PersoBundle\Entity\Relation'
        ));
    }

    public function getName()
    {
        return 'urbicande_persobundle_relationtype';
    }
}
