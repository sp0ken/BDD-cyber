<?php

namespace Urbicande\MiscBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * Statistics controller.
 *
 */
class StatsController extends Controller
{
    /**
     * Statistics page
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $genderChart = $em->getRepository('UrbicandePersoBundle:Personnage')->countGender();
        $statusChart = $em->getRepository('UrbicandePersoBundle:Personnage')->countStatus();
        $groupChart = $this->countGroupMember($em);
        $persoChart = $this->countIntrigue($em);

        return $this->render('UrbicandeMiscBundle:Stats:index.html.twig', array(
            'genderChart' => $genderChart,
            'statusChart' => $statusChart,
            'groupChart' => $groupChart,
            'persoChart' => $persoChart,
        ));
    }

    /**
     * Count the number of members for each groups
     * @param  Doctrine Manager $em
     * @return Array
     */
    private function countGroupMember($em)
    {
        $groupes = $em->getRepository('UrbicandePersoBundle:Groupe')->findAll();
        $groupChart = array();
        foreach ($groupes as $key => $groupe) {
            $groupChart[$key]['nb_members'] = count($groupe->getMembers());
            $groupChart[$key]['name'] = addslashes(html_entity_decode($groupe->getName(), ENT_QUOTES, 'UTF-8'));
        }

        return $groupChart;
    }

    /**
     * Count the number of plots for each characters and writers
     * (Ugly as hell, formatted in a strange way for the charts)
     * @todo Rewrite this monster
     * @param  Doctrine Manager  $em
     * @return Array
     */
    private function countIntrigue($em)
    {
        $persos = $em->getRepository('UrbicandePersoBundle:Personnage')->findAll();
        $users = $em->getRepository('UrbicandeUserBundle:User')->findAll();
        $typeArray = $em->getRepository('UrbicandeIntrigueBundle:IntrigueType')->findAll();
        $types = array();
        foreach ($typeArray as $key => $type) {
            $types[$type->getName()]['persos'] = array();
            $types[$type->getName()]['users'] = array();
            $types[$type->getName()]['name'] = addslashes(html_entity_decode($type->getName(), ENT_QUOTES, 'UTF-8'));
        }
        foreach ($persos as $key => $perso) {
            foreach ($types as $key2 => $intrigue) {
                $types[$key2]['persos'][$perso->getName()] = array();
                $types[$key2]['persos'][$perso->getName()]['nb_intrigue'] = $perso->countIntrigue($key2);
                $types[$key2]['persos'][$perso->getName()]['name'] = addslashes(html_entity_decode($perso->getName(), ENT_QUOTES, 'UTF-8'));
            }
        }
        foreach ($users as $key => $user) {
            foreach ($types as $key2 => $intrigue) {
                $types[$key2]['users'][$user->getUsername()] = array();
                $types[$key2]['users'][$user->getUsername()]['nb_intrigue'] = $user->countIntrigue($key2);
                $types[$key2]['users'][$user->getUsername()]['name'] = addslashes(html_entity_decode($user->getUsername(), ENT_QUOTES, 'UTF-8'));
            }
        }

        return $types;
    }
}
