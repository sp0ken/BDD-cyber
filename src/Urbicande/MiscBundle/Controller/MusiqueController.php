<?php

namespace Urbicande\MiscBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Urbicande\MiscBundle\Entity\Musique;
use Urbicande\MiscBundle\Form\MusiqueType;

/**
 * Musique controller.
 *
 */
class MusiqueController extends Controller
{
    /**
     * Lists all Musique entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UrbicandeMiscBundle:Musique')->findAll();

        return $this->render('UrbicandeMiscBundle:Musique:index.html.twig', array(
            'musiques' => $entities,
        ));
    }

    /**
     * Finds and displays a Musique entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UrbicandeMiscBundle:Musique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Musique entity.');
        }

        return $this->render('UrbicandeMiscBundle:Musique:show.html.twig', array(
            'musique'      => $entity,
        ));
    }

    /**
     * Creates a new Musique entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Musique();
        $form = $this->createForm(new MusiqueType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('create', 'La musique a été créée');
            return $this->redirect($this->generateUrl('musique_by_id', array('id' => $entity->getId())));
        }

        return $this->render('UrbicandeMiscBundle:Musique:new.html.twig', array(
            'musique' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Musique entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $musique = $em->getRepository('UrbicandeMiscBundle:Musique')->find($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $logs = $repo->getLogEntries($musique);

        if (!$musique) {
            throw $this->createNotFoundException('Unable to find Musique entity.');
        }

        $editForm = $this->createForm(new MusiqueType(), $musique);

        return $this->render('UrbicandeMiscBundle:Musique:edit.html.twig', array(
            'musique'      => $musique,
            'logs'         => $logs,
            'form'   => $editForm->createView(),
        ));
    }

     /**
     * Reverts this musique to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $musique = $em->find('Urbicande\MiscBundle\Entity\Musique', $id);
        $version = $request->get('version');

        $repo->revert($musique, intval($version));
        $em->persist($musique);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'La musique a été restaurée');
        return $this->redirect($this->generateUrl('musique_by_id', array('id' => $id)));
    }

    /**
     * Edits an existing Musique entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UrbicandeMiscBundle:Musique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Musique entity.');
        }

        $editForm = $this->createForm(new MusiqueType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('update', 'La musique a été mis à jour');
            return $this->redirect($this->generateUrl('musique_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandeMiscBundle:Musique:edit.html.twig', array(
            'musique'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Musique entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UrbicandeMiscBundle:Musique')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Musique entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('update', 'La musique a été supprimée');
        return $this->redirect($this->generateUrl('musique_list'));
    }

}
