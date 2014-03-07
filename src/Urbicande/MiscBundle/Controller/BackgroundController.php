<?php

namespace Urbicande\MiscBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Urbicande\MiscBundle\Entity\Background;
use Urbicande\MiscBundle\Form\BackgroundType;

/**
 * Background controller.
 *
 */
class BackgroundController extends Controller
{
    /**
     * Lists all Background entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UrbicandeMiscBundle:Background')->findAll();

        return $this->render('UrbicandeMiscBundle:Background:index.html.twig', array(
            'backs' => $entities,
        ));
    }

    /**
     * Finds and displays a Background entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UrbicandeMiscBundle:Background')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Background entity.');
        }

        return $this->render('UrbicandeMiscBundle:Background:show.html.twig', array(
            'back'      => $entity,
        ));
    }

    /**
     * Creates a new Background entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Background();
        $form = $this->createForm(new BackgroundType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('create', 'Le document de background a été créée');
            return $this->redirect($this->generateUrl('background_by_id', array('id' => $entity->getId())));
        }

        return $this->render('UrbicandeMiscBundle:Background:new.html.twig', array(
            'back' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Background entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $back = $em->getRepository('UrbicandeMiscBundle:Background')->find($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $logs = $repo->getLogEntries($back);

        if (!$back) {
            throw $this->createNotFoundException('Unable to find Background entity.');
        }

        $editForm = $this->createForm(new BackgroundType(), $back);

        return $this->render('UrbicandeMiscBundle:Background:edit.html.twig', array(
            'logs' => $logs,
            'back'      => $back,
            'form'   => $editForm->createView(),
        ));
    }

 /**
     * Reverts this background to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $back = $em->find('Urbicande\MiscBundle\Entity\Background', $id);
        $version = $request->get('version');

        $repo->revert($back, intval($version));
        $em->persist($back);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'Le document a été restauré');
        return $this->redirect($this->generateUrl('perso_by_id', array('id' => $id)));
    }

    /**
     * Edits an existing Background entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UrbicandeMiscBundle:Background')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Background entity.');
        }

        $editForm = $this->createForm(new BackgroundType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('update', 'Le document de background a été mis à jour');
            return $this->redirect($this->generateUrl('background_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandeMiscBundle:Background:edit.html.twig', array(
            'back'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Background entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UrbicandeMiscBundle:Background')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Background entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('update', 'Le document de background a été supprimé');
        return $this->redirect($this->generateUrl('background_list'));
    }

    /**
     * Generates an rtf file of the selected background entity
     * @param  Request $request
     * @param  int  $id      id of the Background
     * @return File
     */
    public function generateAction(Request $request, $id)
    {   
        $em = $this->getDoctrine()->getManager();
        $back = $em->getRepository('UrbicandeMiscBundle:Background')->find($id);

        //Loading rtf template file
        $rtf = file_get_contents(__DIR__.'/../Resources/templates/back_template.rtf', "rb");
        //Replacing placeholders with real values
        $rtf = str_replace('%title%', $back->getTitle(), $rtf);
        $rtf = str_replace('%body%', strip_tags($back->getBody()), $rtf);
        $rtf = str_replace('%writer%', $back->getWriter(), $rtf);
        
        //Rendering file to download
        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $back->getTitle());
        $response = new Response($rtf);
        $response->setStatusCode(200); 
        $response->headers->set('Content-Type', 'text/richtext'); 
        $response->headers->set('Content-Disposition', 
        sprintf('attachment;filename="%s.rtf"', $filename)); 

        // prints the HTTP headers followed by the content 
        $response->send(); 

        return $response; 
    }
}
