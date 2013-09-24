<?php

namespace Urbicande\IntrigueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingame', null, array(
                'label' => 'Ouverture de jeu (5 lignes)',
                'required' => false,
                'attr' => array('placeholder' => 'Ce que le héros et les actifs risquent de vivre en jeu grâce à cette intrigue : actions poursuivies, rebondissements provoqués, émotions et sensations dans lesquelles nous allons tenter de les plonger. Autrement dit, le potentiel ludique de l’intrigue.', 'class' => 'rte')
            ))
            ->add('motive', null, array(
                'label' => 'Intentions et motivations (5 lignes)',
                'required' => false,
                'attr' => array('placeholder' => 'Les motivations et intentions préliminaires, qui vont pousser le héros et les actifs à agir, vivre et ressentir des choses grâce à cette intrigue. On peut les diviser en deux grandes catégories : celles contenues dans les fiches de perso, et celles générées par des dilemmes nouveaux auxquels ils vont être confrontés durant la partie (à cause des rebondissements provoqués par nous)', 'class' => 'rte')
            ))
            ->add('resolution', null, array(
                'label' => 'Obstacles et résolutions',
                'required' => false,
                'attr' => array('placeholder' => 'Lister ici les résolutions possibles qui vous viennent à l’esprit. Plus une intrigue semble offrir d’alternatives de résolution plus elle sera intéressante pour ses protagonistes. Cette partie ne doit pas décrire un univers clos au sens mathématique. Les résolutions sont là pour s‘assurer que l‘intrigue peut se résoudre, sans exclure d‘autres fins/résolutions que celles que nous sommes capables d‘imaginer. Tout faire pour que l’intrigue fonctionne avec le moins d’intervention et de régulation possible de la part des organisateurs durant la partie : au besoin, les PNJ sont là pour ça. Tout faire (moralement, physiquement, matériellement, temporellement) pour éviter la mort d’un personnage joueur avant les dernières heures du jeu', 'class' => 'rte')
            ))
            ->add('description', null, array(
                'label' => 'Description narrative',
                'required' => false,
                'attr' => array('placeholder' => 'Narration complète des tenants et aboutissants de l’intrigue, c‘est-à-dire l’ensemble des éléments ayant conduits à la situation du début de jeu, en précisant le positionnement de tous les personnages impliqués par rapport à cette situation . Généralement, un pavé d’au moins une demi-page.', 'class' => 'rte')
            ))
            ->add('datas', 'collection', array(
                'type' => new DataType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Données Objectives',
                'options' => array('data_class' => 'Urbicande\IntrigueBundle\Entity\Data')
            ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\IntrigueBundle\Entity\Plot'
        ));
    }

    public function getName()
    {
        return 'urbicande_intriguebundle_plottype';
    }
}
