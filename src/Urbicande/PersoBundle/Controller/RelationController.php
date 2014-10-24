<?php

namespace Urbicande\PersoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\PersoBundle\Entity\Relation;
use Urbicande\PersoBundle\Form\RelationType;

/**
 * Level controller.
 *
 */
class RelationController extends Controller
{
    /**
     * Lists all Level entities.
     *
     */
    public function indexAction()
    {
        $relations = $this->get('urbicande.relation_manager')->loadAll();
        $json = $this->get('urbicande.perso_manager')->getJsonRelations();

        return $this->render('UrbicandePersoBundle:Relation:index.html.twig', array(
            'relations' => $relations,
            'json' => $json
        ));
    }

    /**
     * Finds and displays a Relation entity.
     *
     */
    public function showAction($id)
    {
        $relation = $this->get('urbicande.relation_manager')->loadRelation($id);

        if (!$relation) {
            throw $this->createNotFoundException('Unable to find Relation entity.');
        }

        return $this->render('UrbicandePersoBundle:Relation:show.html.twig', array(
            'relation'      => $relation,
        ));
    }

    /**
     * Creates a new Relation entity.
     *
     */
    public function createAction(Request $request)
    {
        $relation  = new Relation();
        $form = $this->createForm(new RelationType(), $relation);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.relation_manager')->saveRelation($relation);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé une relation', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'La relation a été créée');
            return $this->redirect($this->generateUrl('relation_by_id', array('id' => $relation->getId())));
        }

        return $this->render('UrbicandePersoBundle:Relation:new.html.twig', array(
            'entity' => $relation,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Relation entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $relation = $this->get('urbicande.relation_manager')->loadRelation($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $logs = $repo->getLogEntries($relation);

        if (!$relation) {
            throw $this->createNotFoundException('Unable to find Relation entity.');
        }

        $editForm = $this->createForm(new RelationType(), $relation);

        return $this->render('UrbicandePersoBundle:Relation:edit.html.twig', array(
            'logs'    => $logs,
            'relation'   => $relation,
            'form'    => $editForm->createView(),
        ));
    }

    /**
     * Reverts this evel to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $relation = $em->find('Urbicande\PersoBundle\Entity\Relation', $id);
        $version = $request->get('version');

        $repo->revert($relation, intval($version));
        $em->persist($relation);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'La relation a été restaurée');
        return $this->redirect($this->generateUrl('relation_by_id', array('id' => $id)));
    }

    /**
     * Edits an existing Relation entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $relation = $this->get('urbicande.relation_manager')->loadRelation($id);

        if (!$relation) {
            throw $this->createNotFoundException('Unable to find Relation entity.');
        }

        $editForm = $this->createForm(new RelationType(), $relation);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.relation_manager')->saveRelation($relation);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité une relation', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('update', 'La relation a été mise à jour');
            return $this->redirect($this->generateUrl('relation_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandePersoBundle:Relation:edit.html.twig', array(
            'entity'      => $relation,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Relation entity.
     *
     */
    public function deleteAction($id)
    {
      $relation = $this->get('urbicande.relation_manager')->loadRelation($id);

      if (!$relation) {
          throw $this->createNotFoundException('Unable to find Relation entity.');
      }

      $this->get('urbicande.relation_manager')->removeRelation($relation);

      $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé une relation', $this->container->getParameter('supervisor_email'));
      $this->get('session')->getFlashBag()->add('delete', 'La relation a été supprimée');
      return $this->redirect($this->generateUrl('relation_list'));
    }

}
