<?php

namespace Urbicande\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Urbicande\UserBundle\Form\UserType;

class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $users = $userManager->findUsers();

        return $this->render('UrbicandeUserBundle:User:index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Finds and displays a Personnage entity.
     *
     */
    public function showAction($username)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        
        $user = $userManager->findUserByUsername($username);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $this->render('UrbicandeUserBundle:User:show.html.twig', array(
            'user' => $user,
        ));
    }


    /**
     * Displays a form to edit an existing Personnage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('UrbicandeUserBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserType(), $user);

        return $this->render('UrbicandeUserBundle:User:edit.html.twig', array(
            'user'      => $user,
            'form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    { 
        $userManager = $this->container->get('fos_user.user_manager');
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('UrbicandeUserBundle:User')->find($id);
        $stat = $user->getStat();

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserType(), $user);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $stat->setAvatar($request->get('avatar'));
            
            $userManager->updateUser($user);
            $this->get('session')->getFlashBag()->add('update', 'Le compte a été mis à jour');
            return $this->redirect($this->generateUrl('Home'));
        }

        return $this->render('UrbicandeUserBundle:User:edit.html.twig', array(
            'user'      => $user,
            'form'   => $editForm->createView(),
        ));
    }
}
