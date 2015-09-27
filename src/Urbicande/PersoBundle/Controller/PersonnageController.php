<?php

namespace Urbicande\PersoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Urbicande\PersoBundle\Entity\Personnage;
use Urbicande\ChronoBundle\Entity\Chronology;
use Urbicande\PersoBundle\Form\PersonnageType;
use ZipArchive;

/**
 * Personnage controller.
 *
 */
class PersonnageController extends Controller
{
    /**
     * Lists all Personnage entities.
     *
     */
    public function indexAction()
    {
        $persos = $this->get('urbicande.perso_manager')->loadAll();
        
       return $this->render('UrbicandePersoBundle:Personnage:index.html.twig', array(
            'persos' => $persos
        ));
    }

    /**
     * Finds and displays a Personnage entity.
     *
     */
    public function showAction($id)
    {
        $perso = $this->get('urbicande.perso_manager')->loadPerso($id);

        if (!$perso) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }

        return $this->render('UrbicandePersoBundle:Personnage:show.html.twig', array(
            'perso'      => $perso,
        ));
    }


    /**
     * Creates a new Personnage entity.
     *
     * @Template("UrbicandePersoBundle:Personnage:new.html.twig")
     */
    public function createAction(Request $request)
    {   
        $perso  = new Personnage();
        $form = $this->createForm(new PersonnageType(), $perso);
        $form->bind($request);

        if ($form->isValid()) {
            $perso->setEvents($perso->getEvents(), true);
            $this->get('urbicande.perso_manager')->savePerso($perso);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé un personnage', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'Le personnage a été créé');
            return $this->redirect($this->generateUrl('perso_by_id', array('id' => $perso->getId())));
        }

       return $this->render('UrbicandePersoBundle:Personnage:new.html.twig', array(
            'entity' => $perso,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Reverts this personnage to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $perso = $em->find('Urbicande\PersoBundle\Entity\Personnage', $id);
        $version = $request->get('version');

        $repo->revert($perso, intval($version));
        $em->persist($perso);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'Le personnage a été restauré');
        return $this->redirect($this->generateUrl('perso_by_id', array('id' => $id)));
    }

    /**
     * Displays a form to edit an existing Personnage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $perso = $this->get('urbicande.perso_manager')->loadPerso($id);
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $logs = $repo->getLogEntries($perso);

        if (!$perso) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }

        $editForm = $this->createForm(new PersonnageType(), $perso);

        return $this->render('UrbicandePersoBundle:Personnage:edit.html.twig', array(
            'logs' => $logs,
            'perso'      => $perso,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Personnage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $perso = $this->get('urbicande.perso_manager')->loadPerso($id);

        if (!$perso) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }

        $editForm = $this->createForm(new PersonnageType(), $perso);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $perso->setEvents($perso->getEvents());
            $this->get('urbicande.perso_manager')->savePerso($perso);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité un personnage', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('update', 'Le personnage a été mis à jour');
            return $this->redirect($this->generateUrl('perso_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandePersoBundle:Personnage:edit.html.twig', array(
            'perso' => $perso,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Personnage entity.
     *
     */
    public function deleteAction($id)
    {

        $perso = $this->get('urbicande.perso_manager')->loadPerso($id);

        if (!$perso) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }

        $this->get('urbicande.perso_manager')->removePerso($perso);

        $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé un personnage', $this->container->getParameter('supervisor_email'));
        $this->get('session')->getFlashBag()->add('delete', 'Le personnage a été supprimé');
        return $this->redirect($this->generateUrl('perso_list'));
    }

    /**
     * Remove a skill from the chosen player.
     *
     */
    public function removeSkillAction($persoId, $skillId)
    {
        $perso = $this->get('urbicande.perso_manager')->loadPerso($persoId);
        $skill = $this->get('urbicande.skill_manager')->loadSKill($skillId);

        if (!$perso) {
            throw $this->createNotFoundException('Unable to find Personnage entity.');
        }
        if (!$skill) {
            throw $this->createNotFoundException('Unable to find Skill entity.');
        }

        $perso->removeSkill($skill);
        $this->get('urbicande.perso_manager')->savePerso($perso);
        
        $this->get('session')->getFlashBag()->add('delete', $perso.' n‘a plus la compétence '.$skill->getName());
        return $this->redirect($this->generateUrl('perso_by_id', array('id' => $perso->getId())));
    }

    /**
     * Creates a word file of the selected character.
     *
     */
    public function exportAction($id)
    {
      $perso = $this->get('urbicande.perso_manager')->loadPerso($id);
      if (!$perso) {
        throw $this->createNotFoundException('Unable to find Personnage entity.');
      }
      $filename = $this->container->getParameter('export_filename').' '.addslashes($perso);

      $response = new Response(
        $this->renderView('UrbicandePersoBundle:Personnage:export.html.twig', array('perso'=>$perso)),
        200
      );
      $response->headers->set('Content-Type', 'application/msword; charset="utf-8"');
      $response->headers->set('Content-disposition', 'attachment; filename="'.$filename.'.doc"');

      return $response;
    }

    /**
     * Creates a zip file of all exported characters files.
     *
     */
    public function exportAllAction() {
      $persos = array();
      $persos = $this->get('urbicande.perso_manager')->loadAll();
      
      $zip = new \ZipArchive();
      $zipName = 'Fiches-'.time().'.zip';
      $file = $this->get('kernel')->getRootDir() . '/../web/resources/'.$zipName;
      $zip->open($this->get('kernel')->getRootDir() . '/../web/resources/'.$zipName,  \ZipArchive::CREATE);
      foreach ($persos as $perso) {
        $filename = $this->container->getParameter('export_filename').' '.addslashes($perso);
        $zip->addFromString($filename.'.doc',  $this->renderView('UrbicandePersoBundle:Personnage:export.html.twig', array('perso'=>$perso))); 
      }
      $zip->close();

      chmod($file, 0755);
      $zipOpen=fopen($file, "r");//astuce ici
      $content=stream_get_contents($zipOpen);// et ici
      //$response = new BinaryFileResponse($file);
      return new Response($content, 200, array(
        'Content-Transfert-encoding: binary',
        'Content-Type' => 'application/zip',
        'Content-Disposition' => 'attachment; filename="'.$zipName,
        'Content-Length: '.filesize($zipName)
      ));
    }
}
