<?php

namespace Urbicande\IntrigueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\IntrigueBundle\Entity\Object;
use Urbicande\IntrigueBundle\Form\ObjectType;

/**
 * Object controller.
 *
 */
class ObjectController extends Controller
{
    /**
     * Lists all Object entities.
     *
     */
    public function indexAction()
    {
        $objects = $this->get('urbicande.object_manager')->loadAll();

        return $this->render('UrbicandeIntrigueBundle:Object:index.html.twig', array(
            'objects' => $objects,
        ));
    }

    /**
     * Finds and displays a Object entity.
     *
     */
    public function showAction($id)
    {
        $object = $this->get('urbicande.object_manager')->loadObject($id);

        if (!$object) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }

        return $this->render('UrbicandeIntrigueBundle:Object:show.html.twig', array(
            'object'      => $object,
        ));
    }

    /**
     * Creates a new Object entity.
     *
     */
    public function createAction(Request $request)
    {
        $object  = new Object();
        $form = $this->createForm(new ObjectType(), $object);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.object_manager')->saveObject($object);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé un objet', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'L‘objet a été créé');
            return $this->redirect($this->generateUrl('object_by_id', array('id' => $object->getId())));
        }

        return $this->render('UrbicandeIntrigueBundle:Object:new.html.twig', array(
            'object' => $object,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Object entity.
     *
     */
    public function editAction($id)
    {
        $object = $this->get('urbicande.object_manager')->loadObject($id);

        if (!$object) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }

        $editForm = $this->createForm(new ObjectType(), $object);

        return $this->render('UrbicandeIntrigueBundle:Object:edit.html.twig', array(
            'object'      => $object,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Object entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $object = $this->get('urbicande.object_manager')->loadObject($id);

        if (!$object) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }

        $editForm = $this->createForm(new ObjectType(), $object);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.object_manager')->saveObject($object);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité un objet', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('update', 'L‘objet a été mis à jour');
            return $this->redirect($this->generateUrl('object_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandeIntrigueBundle:Object:edit.html.twig', array(
            'object'      => $object,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Object entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $object = $this->get('urbicande.object_manager')->loadObject($id);

        if (!$object) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }

        $this->get('urbicande.object_manager')->removeObject($object);

        $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé un objet', $this->container->getParameter('supervisor_email'));
        $this->get('session')->getFlashBag()->add('delete', 'L‘objet a été supprimé');
        return $this->redirect($this->generateUrl('object_list'));
    }

}
