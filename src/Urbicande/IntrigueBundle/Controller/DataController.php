<?php

namespace Urbicande\IntrigueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\IntrigueBundle\Entity\Data;
use Urbicande\IntrigueBundle\Form\DataType;

/**
 * Data controller.
 *
 */
class DataController extends Controller
{
    /**
     * Lists all Data entities.
     *
     */
    public function indexAction()
    {
        $datas = $this->get('urbicande.data_manager')->loadAll();

        return $this->render('UrbicandeIntrigueBundle:Data:index.html.twig', array(
            'datas' => $datas,
        ));
    }

    /**
     * Finds and displays a Data entity.
     *
     */
    public function showAction($id)
    {
        $data = $this->get('urbicande.data_manager')->loadData($id);

        if (!$data) {
            throw $this->createNotFoundException('Unable to find Data entity.');
        }

        return $this->render('UrbicandeIntrigueBundle:Data:show.html.twig', array(
            'data'      => $data,
        ));
    }

    /**
     * Displays a form to edit an existing Data entity.
     *
     */
    public function editAction($id)
    {
      $data = $this->get('urbicande.data_manager')->loadData($id);

      if (!$data) {
          throw $this->createNotFoundException('Unable to find Data entity.');
      }

      $editForm = $this->createForm(new DataType(), $data);

      return $this->render('UrbicandeIntrigueBundle:Data:edit.html.twig', array(
          'data'      => $data,
          'form'   => $editForm->createView(),
      ));
    }

    /**
     * Edits an existing Data entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
      $data = $this->get('urbicande.data_manager')->loadData($id);

      if (!$data) {
          throw $this->createNotFoundException('Unable to find Data entity.');
      }

      $editForm = $this->createForm(new DataType(), $data);
      $editForm->bind($request);

      if ($editForm->isValid()) {
          $data->setDocuments($data->getDocuments());
          $this->get('urbicande.data_manager')->saveData($data);

          $this->get('session')->getFlashBag()->add('update', 'La donnée a été mise à jour');
          return $this->redirect($this->generateUrl('data_by_id', array('id' => $id)));
      }

      return $this->render('UrbicandeIntrigueBundle:Data:edit.html.twig', array(
          'data'      => $data,
          'form'   => $editForm->createView(),
      ));
    }

    /**
     * Deletes a Data entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
      $data = $this->get('urbicande.data_manager')->loadData($id);
      $plot = $entity->getPlot();

      if (!$data) {
          throw $this->createNotFoundException('Unable to find Data entity.');
      }

      $this->get('urbicande.data_manager')->removeData($data);

      $this->get('session')->getFlashBag()->add('delete', 'La donnée a été supprimée');
      return $this->redirect($this->generateUrl('intrigue_by_id', array('id' => $plot->getIntrigue()->getId())));
    }

    /**
     * Remove a given data from a given knower.
     *
     */
    public function removeKnowerAction($dataId, $knowerId)
    {
      $data = $this->get('urbicande.data_manager')->loadData($dataId);
      $perso = $this->get('urbicande.perso_manager')->loadPerso($knowerId);

      if (!$data) {
          throw $this->createNotFoundException('Unable to find Data entity.');
      }
      if (!$perso) {
          throw $this->createNotFoundException('Unable to find Personnage entity.');
      }

      $entity->removeKnower($perso);
      $this->get('urbicande.data_manager')->saveData($data);
      
      $this->get('session')->getFlashBag()->add('delete', $perso.' ne connait plus la donnée');
      return $this->redirect($this->generateUrl('data_by_id', array('id' => $entity->getId())));
    }

    /**
     * Remove a given data from a given document.
     *
     */
    public function removeDocumentAction($dataId, $documentId)
    {
      $data = $this->get('urbicande.data_manager')->loadData($dataId);
      $object = $this->get('urbicande.object_manager')->loadObject($documentId);

      if (!$data) {
          throw $this->createNotFoundException('Unable to find Data entity.');
      }

      if (!$object) {
          throw $this->createNotFoundException('Unable to find Document entity.');
      }

      $entity->removeDocument($object);
      $this->get('urbicande.data_manager')->saveData($data);
      
      $this->get('session')->getFlashBag()->add('delete', $object.' ne contient plus la donnée');
      return $this->redirect($this->generateUrl('data_by_id', array('id' => $entity->getId())));
    }
}
