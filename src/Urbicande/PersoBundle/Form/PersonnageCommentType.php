<?php

namespace Urbicande\PersoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonnageCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', null, array('attr' => array('class' => 'rte')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\PersoBundle\Entity\PersonnageComment'
        ));
    }

    public function getName()
    {
        return 'urbicande_persobundle_personnagecommenttype';
    }
}
