<?php

namespace Urbicande\IntrigueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\IntrigueBundle\Entity\IntrigueType;
use Urbicande\IntrigueBundle\Form\IntrigueTypeType;

/**
 * IntrigueType controller.
 *
 */
class IntrigueTypeController extends Controller
{
    /**
     * Lists all IntrigueType entities.
     *
     */
    public function indexAction()
    {
        $types = $this->get('urbicande.intriguetype_manager')->loadAll();

        return $this->render('UrbicandeIntrigueBundle:IntrigueType:index.html.twig', array(
            'types' => $types,
        ));
    }

    /**
     * Finds and displays a IntrigueType entity.
     *
     */
    public function showAction($id)
    {
        $type = $this->get('urbicande.intriguetype_manager')->loadIntrigueType($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find IntrigueType entity.');
        }

        return $this->render('UrbicandeIntrigueBundle:IntrigueType:show.html.twig', array(
            'type'      => $type,
        ));
    }

    /**
     * Creates a new IntrigueType entity.
     *
     */
    public function createAction(Request $request)
    {
        $type  = new IntrigueType();
        $form = $this->createForm(new IntrigueTypeType(), $type);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.intriguetype_manager')->saveIntrigueType($type);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé un type d‘intrigue', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'Le type d‘intrigue a été créé');
            return $this->redirect($this->generateUrl('intrigue_type_by_id', array('id' => $type->getId())));
        }

        return $this->render('UrbicandeIntrigueBundle:IntrigueType:new.html.twig', array(
            'type' => $type,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing IntrigueType entity.
     *
     */
    public function editAction($id)
    {
        $type = $this->get('urbicande.intriguetype_manager')->loadIntrigueType($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find IntrigueType entity.');
        }

        $editForm = $this->createForm(new IntrigueTypeType(), $type);

        return $this->render('UrbicandeIntrigueBundle:IntrigueType:edit.html.twig', array(
            'type'      => $type,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing IntrigueType entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $type = $this->get('urbicande.intriguetype_manager')->loadIntrigueType($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find IntrigueType entity.');
        }

        $editForm = $this->createForm(new IntrigueTypeType(), $type);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.intriguetype_manager')->saveIntrigueType($type);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité un type d‘intrigue', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('update', 'Le type d‘intrigue a été mis à jour');
            return $this->redirect($this->generateUrl('intrigue_type_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandeIntrigueBundle:IntrigueType:edit.html.twig', array(
            'type'      => $type,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a IntrigueType entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
      $type = $this->get('urbicande.intriguetype_manager')->loadIntrigueType($id);

      if (!$type) {
          throw $this->createNotFoundException('Unable to find IntrigueType entity.');
      }

      $this->get('urbicande.intriguetype_manager')->removeIntrigueType($type);

      $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé un type d‘intrigue', $this->container->getParameter('supervisor_email'));

      $this->get('session')->getFlashBag()->add('delete', 'Le type d‘intrigue a été supprimé');
      return $this->redirect($this->generateUrl('intrigue_type_list'));
    }
}
