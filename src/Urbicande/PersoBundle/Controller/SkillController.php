<?php

namespace Urbicande\PersoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\PersoBundle\Entity\Skill;
use Urbicande\PersoBundle\Form\SkillType;

/**
 * Skill controller.
 *
 */
class SkillController extends Controller
{
    /**
     * Lists all Skill entities.
     *
     */
    public function indexAction()
    {
        $skills = $this->get('urbicande.skill_manager')->loadAll();

        return $this->render('UrbicandePersoBundle:Skill:index.html.twig', array(
            'skills' => $skills,
        ));
    }

    /**
     * Finds and displays a Skill entity.
     *
     */
    public function showAction($id)
    {
        $skill = $this->get('urbicande.skill_manager')->loadSkill($id);

        if (!$skill) {
            throw $this->createNotFoundException('Unable to find Skill entity.');
        }

        return $this->render('UrbicandePersoBundle:Skill:show.html.twig', array(
            'skill'      => $skill,
        ));
    }


    /**
     * Creates a new Skill entity.
     *
     */
    public function createAction(Request $request)
    {
        $skill  = new Skill();
        $form = $this->createForm(new SkillType(), $skill);
        $form->bind($request);

        if ($form->isValid()) {
            $skill->setPlayers($skill->getPlayers(), true);
            $this->get('urbicande.skill_manager')->saveSkill($skill);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé une compétence', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('create', 'La compétence a été créée');
            return $this->redirect($this->generateUrl('skill_by_id', array('id' => $skill->getId())));
        }

        return $this->render('UrbicandePersoBundle:Skill:new.html.twig', array(
            'entity' => $skill,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Skill entity.
     *
     */
    public function editAction($id)
    {
        $skill = $this->get('urbicande.skill_manager')->loadSkill($id);

        if (!$skill) {
            throw $this->createNotFoundException('Unable to find Skill entity.');
        }

        $editForm = $this->createForm(new SkillType(), $skill);

        return $this->render('UrbicandePersoBundle:Skill:edit.html.twig', array(
            'skill'      => $skill,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Skill entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $skill = $this->get('urbicande.skill_manager')->loadSkill($id);

        if (!$skill) {
            throw $this->createNotFoundException('Unable to find Skill entity.');
        }

        $editForm = $this->createForm(new SkillType(), $skill);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $skill->setPlayers($skill->getPlayers());
            $this->get('urbicande.skill_manager')->saveSkill($skill);

            $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité une compétence', $this->container->getParameter('supervisor_email'));
            $this->get('session')->getFlashBag()->add('update', 'La compétence a été mise à jour');
            return $this->redirect($this->generateUrl('skill_by_id', array('id' => $id)));
        }

        return $this->render('UrbicandePersoBundle:Skill:edit.html.twig', array(
            'skill'      => $skill,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Skill entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $skill = $this->get('urbicande.skill_manager')->loadSkill($id);

        if (!$skill) {
            throw $this->createNotFoundException('Unable to find Skill entity.');
        }

        $this->get('urbicande.skill_manager')->removeSkill($skill);

        $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé une compétence', $this->container->getParameter('supervisor_email'));
        $this->get('session')->getFlashBag()->add('delete', 'La compétence a été supprimée');
        return $this->redirect($this->generateUrl('skill_list'));
    }
}
