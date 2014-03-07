<?php

namespace Urbicande\IntrigueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\IntrigueBundle\Entity\ObjectType;
use Urbicande\IntrigueBundle\Form\ObjectTypeType;

/**
 * ObjectType controller.
 *
 */
class ObjectTypeController extends Controller
{
    /**
     * Lists all ObjectType entities.
     *
     */
    public function indexAction()
    {
        $types = $this->get('urbicande.objecttype_manager')->loadAll();

        return $this->render('UrbicandeIntrigueBundle:ObjectType:index.html.twig', array(
            'types' => $types,
        ));
    }

    /**
     * Finds and displays a ObjectType entity.
     *
     */
    public function showAction($id)
    {
        $type = $this->get('urbicande.objecttype_manager')->loadObjectType($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find ObjectType entity.');
        }

        return $this->render('UrbicandeIntrigueBundle:ObjectType:show.html.twig', array(
            'type'      => $type,
        ));
    }

    /**
     * Creates a new ObjectType entity.
     *
     */
    public function createAction(Request $request)
    {
        $type  = new ObjectType();
        $form = $this->createForm(new ObjectTypeType(), $type);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.objecttype_manager')->saveObjectType($type);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé un type d‘objet', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'Le type d‘objet a été créé');
            return $this->redirect($this->generateUrl('object_type_by_id', array('id' => $type->getId())));
        }

        return $this->render('UrbicandeIntrigueBundle:ObjectType:new.html.twig', array(
            'type' => $type,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ObjectType entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $type = $this->get('urbicande.objecttype_manager')->loadObjectType($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $logs = $repo->getLogEntries($intrigue);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find ObjectType entity.');
        }

        $editForm = $this->createForm(new ObjectTypeType(), $type);

        return $this->render('UrbicandeIntrigueBundle:ObjectType:edit.html.twig', array(
            'logs' => $logs,
            'type'      => $type,
            'form'   => $editForm->createView(),
        ));
    }

     /**
     * Reverts this object type to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $type = $em->find('Urbicande\IntrigueBundle\Entity\ObjectType', $id);
        $version = $request->get('version');

        $repo->revert($type, intval($version));
        $em->persist($type);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'Le type d\'objet a été restauré');
        return $this->redirect($this->generateUrl('object_type_by_id', array('id' => $id)));
    }

    /**
     * Edits an existing ObjectType entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $type = $this->get('urbicande.objecttype_manager')->loadObjectType($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find ObjectType entity.');
        }

        $editForm = $this->createForm(new ObjectTypeType(), $type);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.objecttype_manager')->saveObjectType($type);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité un type d‘objet', $this->container->getParameter('supervisor_email'));

            $this->get('session')->getFlashBag()->add('update', 'Le type d‘objet a été mis à jour');
            return $this->redirect($this->generateUrl('object_type_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandeIntrigueBundle:ObjectType:edit.html.twig', array(
            'type'      => $type,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a ObjectType entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $type = $this->get('urbicande.objecttype_manager')->loadObjectType($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find ObjectType entity.');
        }

        $this->get('urbicande.objecttype_manager')->removeObjectType($type);

        $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé un type d‘objet', $this->container->getParameter('supervisor_email'));
        $this->get('session')->getFlashBag()->add('delete', 'Le type d‘objet a été supprimé');
        return $this->redirect($this->generateUrl('object_type_list'));
    }

}
