<?php

namespace Urbicande\PersoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\PersoBundle\Entity\PersonnageComment;
use Urbicande\PersoBundle\Form\PersonnageCommentType;

/**
 * PersonnageComment controller.
 *
 */
class PersonnageCommentController extends Controller
{
    /**
     * Creates a new PersonnageComment entity.
     *
     */
    public function createAction(Request $request, $persoId)
    {   
        $perso = $this->get('urbicande.perso_manager')->loadPerso($persoId);

        if (!$perso) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }

        $comment  = new PersonnageComment();
        $form = $this->createForm(new PersonnageCommentType(), $comment);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.personnagecomment_manager')->savePersonnageComment($comment, $perso, null, $this->getUser());

            $this->get('urbicande.mail_manager')->sendPersoCommentMail($this->getUser(), $perso->getWriter(), $comment);
            $this->get('session')->getFlashBag()->add('create', 'Le commentaire a été posté');
            return $this->redirect($this->generateUrl('perso_by_id', array('id' => $perso->getId())));
        }

        return $this->render('UrbicandePersoBundle:PersonnageComment:new.html.twig', array(
            'entity' => $comment,
            'perso' => $perso,
            'form'   => $form->createView(),
        ));
    }

    public function createAJAXAction(Request $request)
    {
      if($request->isXmlHttpRequest())  {
        $userManager = $this->container->get('fos_user.user_manager');
        
        $comment  = new PersonnageComment();
        $comment->setComment($request->get('comment'));
        $comment->setPerso($request->get('persoId'));
        $comment->setUser($this->getUser());

        $comment_manager = $this->get('urbicande.personnagecomment_manager');
        $comment_manager->savePersonnageComment($comment);
         //
        $response = new JsonResponse();
        $response->setData(array('comment' => $comment->__toString()));
        return $response;
      } else {
        return $this->redirect($this->generateUrl('Home'));
      }
    }

    /**
     * Creates a new PersonnageComment entity responding to an existing one.
     *
     */
    public function respondAction(Request $request, $persoId, $commentId)
    {   
        $perso = $this->get('urbicande.perso_manager')->loadPerso($persoId);
        $parentComment = $this->get('urbicande.personnagecomment_manager')->loadPersonnageComment($commentId);

        if (!$perso) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }
        if (!$parentComment) {
            throw $this->createNotFoundException('Unable to find PersonnageComment entity.');
        }

        $comment  = new PersonnageComment();
        $form = $this->createForm(new PersonnageCommentType(), $comment);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('urbicande.personnagecomment_manager')->savePersonnageComment($comment, $perso, $parentComment, $this->getUser());

            $this->get('urbicande.mail_manager')->sendPersoCommentMail($this->getUser(), $perso->getWriter(), $comment);
            $this->get('urbicande.mail_manager')->sendPersoCommentResponseMail($this->getUser(), $parentComment->getUser(), $comment);
            $this->get('session')->getFlashBag()->add('create', 'Le commentaire a été posté');
            return $this->redirect($this->generateUrl('perso_by_id', array('id' => $perso->getId())));
        }

        return $this->render('UrbicandePersoBundle:PersonnageComment:response.html.twig', array(
            'entity' => $comment,
            'perso' => $perso,
            'parentComment' => $parentComment,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PersonnageComment entity.
     *
     */
    public function editAction($id)
    {
        $comment = $this->get('urbicande.personnagecomment_manager')->loadPersonnageComment($id);

        if (!$comment) {
            throw $this->createNotFoundException('Unable to find PersonnageComment entity.');
        }

        $editForm = $this->createForm(new PersonnageCommentType(), $comment);

        return $this->render('UrbicandePersoBundle:PersonnageComment:edit.html.twig', array(
            'persoComment'      => $comment,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing PersonnageComment entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $comment = $this->get('urbicande.personnagecomment_manager')->loadPersonnageComment($id);

        if (!$comment) {
            throw $this->createNotFoundException('Unable to find PersonnageComment entity.');
        }

        $editForm = $this->createForm(new PersonnageCommentType(), $comment);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->get('urbicande.personnagecomment_manager')->savePersonnageComment($comment);

            $this->get('session')->getFlashBag()->add('update', 'Le commantaire a été mis à jour');
            return $this->redirect($this->generateUrl('perso_by_id', array('id' => $comment->getPerso()->getId())));
        }

        return $this->render('UrbicandePersoBundle:PersonnageComment:edit.html.twig', array(
            'persoComment'      => $comment,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a PersonnageComment entity.
     *
     */
    public function deleteAction($id)
    {
        $comment = $this->get('urbicande.personnagecomment_manager')->loadPersonnageComment($id);

        if (!$comment) {
            throw $this->createNotFoundException('Unable to find PersonnageComment entity.');
        }
        $perso = $comment->getPerso();

        $this->get('urbicande.personnagecomment_manager')->removePersonnageComment($comment);
        
        $this->get('session')->getFlashBag()->add('delete', 'Le commantaire a été supprimé');
        return $this->redirect($this->generateUrl('perso_by_id', array('id' => $perso->getId())));
    }

}
