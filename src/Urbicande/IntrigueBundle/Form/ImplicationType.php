<?php

namespace Urbicande\IntrigueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('player', null, array('label' => 'Personnage', 'required' => false))
            ->add('groupe', null, array('label' => 'Groupe', 'required' => false))
            ->add('event', null, array('label' => 'Évènement', 'required' => false))
            ->add('degree', 'choice', array(
                'label' => 'Degré d‘implication', 
                'choices'   => array('Héros' => 'Héros', 'Actif' => 'Actif', 'Réactif' => 'Réactif', 'Figurant' => 'Figurant', 'Renfort' => 'Renfort'),
            ))
            ->add('synopsis', null, array('label' => 'Implication (1 ligne)'))
            ->add('theme', null, array('label' => 'Thèmes (séparés par des /)'))
            ->add('description', null, array(
                'label' => 'Informations pour le rédacteur', 
                'required' => false,
                'attr' => array('placeholder' => 'Ce sont des recommandations de rédaction. Elles ne devront pas apparaître littéralement dans la fiche, mais influeront sur sa rédaction. Il s’agit à la fois ce qui relève de l’état d’esprit inconscient du personnage ou bien de ce qu’il ignore encore, qu’il découvrira en cours de jeu et qui devrait permettre une rédaction de fiche en connaissance de cause', 'class' => 'rte')
            ))
            ->add('information', null, array(
                'label' => 'Information pour le personnage', 
                'required' => false,
                'attr' => array('placeholder' => 'Ses objectifs, ce dont il a conscience et tout ce qu’il sait ou croit savoir. Stylistiquement, le rédacteur de la fiche doit préempter sur le rédacteur de l’intrigue, ne perdez pas donc votre temps à trop rédiger cette partie.', 'class' => 'rte')
            ))
            ->add('objective', null, array(
                'label' => 'Objectifs PNJ', 
                'required' => false,
                'attr' => array('placeholder' => 'Ces derniers doivent savoir exactement ce que nous attendons d’eux pour que l’intrigue fonctionne, surtout si ça ne va pas totalement dans le sens de psychologie de leur personnage.', 'class' => 'rte')
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\IntrigueBundle\Entity\Implication'
        ));
    }

    public function getName()
    {
        return 'urbicande_intriguebundle_implicationtype';
    }
}
