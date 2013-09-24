<?php

namespace Urbicande\IntrigueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SynopsisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
        ->add('context', null, array(
          'label' => 'Contexte (5 lignes)',
           'required' => false,
           'attr' => array('placeholder' => 'Le contexte général de l’intrigue et les principaux éléments de son background', 'class' => 'rte')
        ))
        ->add('ingame', null, array(
          'label' => 'Développement en jeu (5 lignes)',
           'required' => false,
           'attr' => array('placeholder' => 'Que va-t-il se passer en jeu pour les joueurs impliqués ? C‘est-à-dire, quelles actions vont-ils devoir accomplir, à quels obstacles/dilemmes/émotions/sensations vont-ils se confronter ?', 'class' => 'rte')
        ))
      ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\IntrigueBundle\Entity\Synopsis'
        ));
    }

    public function getName()
    {
        return 'urbicande_intriguebundle_synopsistype';
    }
}
