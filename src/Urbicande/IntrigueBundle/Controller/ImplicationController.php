<?php

namespace Urbicande\IntrigueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\IntrigueBundle\Entity\Implication;
use Urbicande\IntrigueBundle\Form\ImplicationType;

/**
 * Implication controller.
 *
 */
class ImplicationController extends Controller
{
    /**
     * Lists all Implication entities.
     *
     */
    public function indexAction()
    {
        $implications = $this->get('urbicande.implication_manager')->loadAll();

        return $this->render('UrbicandeIntrigueBundle:Implication:index.html.twig', array(
            'implications' => $implications,
        ));
    }

    /**
     * Finds and displays a Implication entity.
     *
     */
    public function showAction($id)
    {
        $implication = $this->get('urbicande.implication_manager')->loadImplication($id);

        if (!$implication) {
            throw $this->createNotFoundException('Unable to find Implication entity.');
        }

        return $this->render('UrbicandeIntrigueBundle:Implication:show.html.twig', array(
            'implication'      => $implication,
        ));
    }

    /**
     * Creates a new Implication entity.
     *
     */
    public function createAction(Request $request)
    {
        $implication  = new Implication();
        $form = $this->createForm(new ImplicationType(), $implication);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.implication_manager')->saveImplication($implication);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé une implication', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'L‘implication a été créée');
            return $this->redirect($this->generateUrl('implication_by_id', array('id' => $implication->getId())));
        }

        return $this->render('UrbicandeIntrigueBundle:Implication:new.html.twig', array(
            'implication' => $implication,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Implication entity.
     *
     */
    public function editAction($id)
    {
        $implication = $this->get('urbicande.implication_manager')->loadImplication($id);

        if (!$implication) {
            throw $this->createNotFoundException('Unable to find Implication entity.');
        }

        $editForm = $this->createForm(new ImplicationType(), $implication);

        return $this->render('UrbicandeIntrigueBundle:Implication:edit.html.twig', array(
            'implication'      => $implication,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Implication entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $implication = $this->get('urbicande.implication_manager')->loadImplication($id);

        if (!$implication) {
            throw $this->createNotFoundException('Unable to find Implication entity.');
        }

        $editForm = $this->createForm(new ImplicationType(), $implication);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.implication_manager')->saveImplication($implication);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité une implication', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('update', 'L‘implication a été mise à jour');
            return $this->redirect($this->generateUrl('implication_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandeIntrigueBundle:Implication:edit.html.twig', array(
            'implication'      => $implication,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Implication entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $implication = $this->get('urbicande.implication_manager')->loadImplication($id);

        if (!$implication) {
            throw $this->createNotFoundException('Unable to find Implication entity.');
        }

        $this->get('urbicande.implication_manager')->removeImplication($implication);

        $this->get('session')->getFlashBag()->add('delete', 'L‘implication a été supprimée');
        return $this->redirect($this->generateUrl('implication_list'));
    }

}
