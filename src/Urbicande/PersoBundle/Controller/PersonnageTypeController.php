<?php

namespace Urbicande\PersoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\PersoBundle\Entity\PersonnageType;
use Urbicande\PersoBundle\Form\PersonnageTypeType;

/**
 * PersonnageType controller.
 *
 */
class PersonnageTypeController extends Controller
{
    /**
     * Lists all PersonnageType entities.
     *
     */
    public function indexAction()
    {
        $types = $this->get('urbicande.personnagetype_manager')->loadAll();

        return $this->render('UrbicandePersoBundle:PersonnageType:index.html.twig', array(
            'types' => $types,
        ));
    }

    /**
     * Finds and displays a PersonnageType entity.
     *
     */
    public function showAction($id)
    {
        $type = $this->get('urbicande.personnagetype_manager')->loadPersonnageType($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find PersonnageType entity.');
        }

        return $this->render('UrbicandePersoBundle:PersonnageType:show.html.twig', array(
            'type'      => $type,
        ));
    }

    /**
     * Creates a new PersonnageType entity.
     *
     */
    public function createAction(Request $request)
    {
        $type  = new PersonnageType();
        $form = $this->createForm(new PersonnageTypeType(), $type);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.personnagetype_manager')->savePersonnageType($type);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé un type de personnage', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'Le type de personnage a été créé');
            return $this->redirect($this->generateUrl('perso_type_by_id', array('id' => $type->getId())));
        }

        return $this->render('UrbicandePersoBundle:PersonnageType:new.html.twig', array(
            'entity' => $type,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PersonnageType entity.
     *
     */
    public function editAction($id)
    {
        $type = $this->get('urbicande.personnagetype_manager')->loadPersonnageType($id);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find PersonnageType entity.');
        }

        $editForm = $this->createForm(new PersonnageTypeType(), $type);

        return $this->render('UrbicandePersoBundle:PersonnageType:edit.html.twig', array(
            'type'      => $type,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing PersonnageType entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $type = $this->get('urbicande.personnagetype_manager')->loadPersonnageType($type);

        if (!$type) {
            throw $this->createNotFoundException('Unable to find PersonnageType entity.');
        }

        $editForm = $this->createForm(new PersonnageTypeType(), $type);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.personnagetype_manager')->savePersonnageType($type);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité un type de personnage', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('update', 'Le type de personnage a été mis à jour');
            return $this->redirect($this->generateUrl('personnagetype_edit', array('id' => $id)));
        }

        return $this->render('UrbicandePersoBundle:PersonnageType:edit.html.twig', array(
            'entity'      => $type,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a PersonnageType entity.
     *
     */
    public function deleteAction($id)
    {
      $type = $this->get('urbicande.personnagetype_manager')->loadPersonnageType($type);

      if (!$type) {
          throw $this->createNotFoundException('Unable to find PersonnageType entity.');
      }

      $this->get('urbicande.personnagetype_manager')->removePersonnageType($type);

      $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé un type de personnage', $this->container->getParameter('supervisor_email'));
      $this->get('session')->getFlashBag()->add('delete', 'Le type de personnage a été supprimé');
      return $this->redirect($this->generateUrl('perso_type_list'));
    }

}
