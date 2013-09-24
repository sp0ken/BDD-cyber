<?php

namespace Urbicande\IntrigueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\IntrigueBundle\Entity\IntrigueComment;
use Urbicande\IntrigueBundle\Form\IntrigueCommentType;

/**
 * IntrigueComment controller.
 *
 */
class IntrigueCommentController extends Controller
{

    /**
     * Creates a new IntrigueComment entity.
     *
     */
    public function createAction(Request $request, $intrigueId)
    {   
        $intrigue = $this->get('urbicande.intrigue_manager')->loadIntrigue($intrigueId);

        if (!$intrigue) {
            throw $this->createNotFoundException('Unable to find Intrigue entity.');
        }

        $comment  = new IntrigueComment();
        $form = $this->createForm(new IntrigueCommentType(), $comment);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.intriguecomment_manager')->saveIntrigueComment($comment, $intrigue, $this->getUser());

            $this->get('urbicande.mail_manager')->sendIntrigueCommentMail($this->getUser(), $comment->getIntrigue()->getWriter(), $comment);
            $this->get('session')->getFlashBag()->add('create', 'Le commentaire a été posté');
            return $this->redirect($this->generateUrl('intrigue_by_id', array('id' => $comment->getIntrigue()->getId())));
        }

        return $this->render('UrbicandeIntrigueBundle:IntrigueComment:new.html.twig', array(
            'entity' => $comment,
            'intrigue' => $intrigue,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing IntrigueComment entity.
     *
     */
    public function editAction($id)
    {
        $intrigueComment = $this->get('urbicande.intriguecomment_manager')->loadIntrigueComment($id);

        if (!$intrigueComment) {
            throw $this->createNotFoundException('Unable to find IntrigueComment entity.');
        }

        $editForm = $this->createForm(new IntrigueCommentType(), $intrigueComment);

        return $this->render('UrbicandeIntrigueBundle:IntrigueComment:edit.html.twig', array(
            'intrigueComment'      => $intrigueComment,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing IntrigueComment entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $intrigueComment = $this->get('urbicande.intriguecomment_manager')->loadIntrigueComment($id);

        if (!$intrigueComment) {
            throw $this->createNotFoundException('Unable to find IntrigueComment entity.');
        }

        $editForm = $this->createForm(new IntrigueCommentType(), $intrigueComment);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.intriguecomment_manager')->saveIntrigueComment($intrigueComment);

            $this->get('session')->getFlashBag()->add('update', 'Le commentaire a été mis à jour');
            return $this->redirect($this->generateUrl('intrigue_by_id', array('id' => $intrigueComment->getIntrigue()->getId())));
        }

        return $this->render('UrbicandeIntrigueBundle:IntrigueComment:edit.html.twig', array(
            'intrigueComment'      => $intrigueComment,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a IntrigueComment entity.
     *
     */
    public function deleteAction($id)
    {
        $intrigueComment = $this->get('urbicande.intriguecomment_manager')->loadIntrigueComment($id);
        $intrigue = $intrigueComment->getIntrigue();
        
        if (!$intrigueComment) {
            throw $this->createNotFoundException('Unable to find IntrigueComment entity.');
        }

        $this->get('urbicande.intriguecomment_manager')->removeIntrigueComment($intrigueComment);
        
        $this->get('session')->getFlashBag()->add('delete', 'Le commentaire a été supprimé');
        return $this->redirect($this->generateUrl('intrigue_by_id', array('id' => $intrigue->getId())));
    }

}
