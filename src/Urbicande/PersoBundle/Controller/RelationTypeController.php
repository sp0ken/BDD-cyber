<?php

namespace Urbicande\PersoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\PersoBundle\Entity\RelationType;
use Urbicande\PersoBundle\Form\RelationTypeType;

/**
 * RelationType controller.
 *
 */
class RelationTypeController extends Controller
{
    /**
     * Lists all RelationType entities.
     *
     */
    public function indexAction()
    {
        $types = $this->get('urbicande.relationtype_manager')->loadAll();

        return $this->render('UrbicandePersoBundle:RelationType:index.html.twig', array(
            'types' => $types,
        ));
    }

    /**
     * Finds and displays a RelationType entity.
     *
     */
    public function showAction($id)
    {
        $type = $this->get('urbicande.Relationtype_manager')->loadRelationType($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find RelationType entity.');
        }

        return $this->render('UrbicandePersoBundle:RelationType:show.html.twig', array(
            'type'      => $type,
        ));
    }

    /**
     * Creates a new RelationType entity.
     *
     */
    public function createAction(Request $request)
    {
        $type  = new RelationType();
        $form = $this->createForm(new RelationTypeType(), $type);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.Relationtype_manager')->saveRelationType($type);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé un type de relation', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'Le type de relation a été créé');
            return $this->redirect($this->generateUrl('relation_type_by_id', array('id' => $type->getId())));
        }

        return $this->render('UrbicandePersoBundle:RelationType:new.html.twig', array(
            'entity' => $type,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RelationType entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $type = $this->get('urbicande.relationtype_manager')->loadRelationType($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $logs = $repo->getLogEntries($type);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find RelationType entity.');
        }

        $editForm = $this->createForm(new RelationTypeType(), $type);

        return $this->render('UrbicandePersoBundle:RelationType:edit.html.twig', array(
            'logs' => $logs,
            'type'      => $type,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Reverts this Relation type to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $type = $em->find('Urbicande\PersoBundle\Entity\RelationType', $id);
        $version = $request->get('version');

        $repo->revert($type, intval($version));
        $em->persist($type);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'Le type de relation a été restauré');
        return $this->redirect($this->generateUrl('relation_type_by_id', array('id' => $id)));
    }

    /**
     * Edits an existing RelationType entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $type = $this->get('urbicande.Relationtype_manager')->loadRelationType($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find RelationType entity.');
        }

        $editForm = $this->createForm(new RelationTypeType(), $type);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.relationtype_manager')->saveRelationType($type);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité un type de relation', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('update', 'Le type de relation a été mis à jour');
            return $this->redirect($this->generateUrl('relation_type_edit', array('id' => $id)));
        }

        return $this->render('UrbicandePersoBundle:RelationType:edit.html.twig', array(
            'entity'      => $type,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a RelationType entity.
     *
     */
    public function deleteAction($id)
    {
      $type = $this->get('urbicande.relationtype_manager')->loadRelationType($id);

      if (!$type) {
          throw $this->createNotFoundException('Unable to find RelationType entity.');
      }

      $this->get('urbicande.relationtype_manager')->removeRelationType($id);

      $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé un type de relation', $this->container->getParameter('supervisor_email'));
      $this->get('session')->getFlashBag()->add('delete', 'Le type de relation a été supprimé');
      return $this->redirect($this->generateUrl('relation_type_list'));
    }

}
