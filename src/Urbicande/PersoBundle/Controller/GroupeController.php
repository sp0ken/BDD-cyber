<?php

namespace Urbicande\PersoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\PersoBundle\Entity\Groupe;
use Urbicande\PersoBundle\Form\GroupeType;

/**
 * Groupe controller.
 *
 */
class GroupeController extends Controller
{
    /**
     * Lists all Groupe entities.
     *
     */
    public function indexAction()
    {
        $groupes = $this->get('urbicande.groupe_manager')->loadAll();

        return $this->render('UrbicandePersoBundle:Groupe:index.html.twig', array(
            'groupes' => $groupes,
        ));
    }

    /**
     * Finds and displays a Groupe entity.
     *
     */
    public function showAction($id)
    {
        $groupe = $this->get('urbicande.groupe_manager')->loadGroupe($id);

        if (!$groupe) {
            throw $this->createNotFoundException('Unable to find Groupe entity.');
        }

        return $this->render('UrbicandePersoBundle:Groupe:show.html.twig', array(
            'groupe'      => $groupe,    
        ));
    }

    /**
     * Creates a new Groupe entity.
     *
     */
    public function createAction(Request $request)
    {
        $groupe  = new Groupe();
        $form = $this->createForm(new GroupeType(), $groupe);
        $form->bind($request);

        if ($form->isValid()) {
            $groupe->setMembers($groupe->getMembers(), true);
            $this->get('urbicande.groupe_manager')->saveGroupe($groupe);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé un groupe', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'Le groupe a été créé');
            return $this->redirect($this->generateUrl('groupe_by_id', array('id' => $groupe->getId())));
        }

        return $this->render('UrbicandePersoBundle:Groupe:new.html.twig', array(
            'groupe' => $groupe,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Groupe entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $groupe = $this->get('urbicande.groupe_manager')->loadGroupe($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $logs = $repo->getLogEntries($groupe);

        if (!$groupe) {
            throw $this->createNotFoundException('Unable to find Groupe entity.');
        }

        $editForm = $this->createForm(new GroupeType(), $groupe);

        return $this->render('UrbicandePersoBundle:Groupe:edit.html.twig', array(
            'groupe'      => $groupe,
            'logs'        => $logs,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Reverts this groupe to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $groupe = $em->find('Urbicande\PersoBundle\Entity\Groupe', $id);
        $version = $request->get('version');

        $repo->revert($groupe, intval($version));
        $em->persist($groupe);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'Le groupe a été restauré');
        return $this->redirect($this->generateUrl('groupe_by_id', array('id' => $id)));
    }

    /**
     * Edits an existing Groupe entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $groupe = $this->get('urbicande.groupe_manager')->loadGroupe($id);

        if (!$groupe) {
            throw $this->createNotFoundException('Unable to find Groupe entity.');
        }

        $editForm = $this->createForm(new GroupeType(), $groupe);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $groupe->setMembers($groupe->getMembers());
            $this->get('urbicande.groupe_manager')->saveGroupe($groupe);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité un groupe', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('update', 'Le groupe a été mis à jour');
            return $this->redirect($this->generateUrl('groupe_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandePersoBundle:Groupe:edit.html.twig', array(
            'groupe'      => $groupe,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Groupe entity.
     *
     */
    public function deleteAction($id)
    {
        $groupe = $this->get('urbicande.groupe_manager')->loadGroupe($id);

        if (!$groupe) {
            throw $this->createNotFoundException('Unable to find Groupe entity.');
        }

        $this->get('urbicande.groupe_manager')->removeGroupe($groupe);

        $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé un groupe', $this->container->getParameter('supervisor_email'));
        $this->get('session')->getFlashBag()->add('delete', 'Le groupe a été supprimé');
        return $this->redirect($this->generateUrl('groupe_list'));
    }


    /**
     * Remove a member from the chosen groupe.
     *
     */
    public function removeMemberAction($groupeId, $memberId)
    {
        $groupe = $this->get('urbicande.groupe_manager')->loadGroupe($groupeId);
        $perso = $this->get('urbicande.perso_manager')->loadPerso($memberId);

        if (!$groupe) {
            throw $this->createNotFoundException('Unable to find Groupe entity.');
        }
        if (!$perso) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }

        $groupe->removeMember($perso);
        $this->get('urbicande.groupe_manager')->saveGroupe($groupe);
        
        $this->get('session')->getFlashBag()->add('delete', $perso.' ne fait plus partis du groupe '.$groupe);
        return $this->redirect($this->generateUrl('groupe_by_id', array('id' => $groupe->getId())));
    }
}
