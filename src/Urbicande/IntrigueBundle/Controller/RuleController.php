<?php

namespace Urbicande\IntrigueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\IntrigueBundle\Entity\Rule;
use Urbicande\IntrigueBundle\Form\RuleType;

/**
 * Rule controller.
 *
 */
class RuleController extends Controller
{
    /**
     * Lists all Rule entities.
     *
     */
    public function indexAction()
    {
      $rules = $this->get('urbicande.rule_manager')->loadAll();

      return $this->render('UrbicandeIntrigueBundle:Rule:index.html.twig', array(
        'rules' => $rules,
      ));
    }

    /**
     * Finds and displays a Rule entity.
     *
     */
    public function showAction($id)
    {
      $rule = $this->get('urbicande.rule_manager')->loadRule($id);

      if (!$rule) {
        throw $this->createNotFoundException('Unable to find Rule entity.');
      }

      return $this->render('UrbicandeIntrigueBundle:Rule:show.html.twig', array(
        'rule'      => $rule,
      ));
    }


    /**
     * Creates a new Rule entity.
     *
     */
    public function createAction(Request $request)
    {
      $rule  = new Rule();
      $form = $this->createForm(new RuleType(), $rule);
      $form->bind($request);

      if ($form->isValid()) {
        $this->get('urbicande.rule_manager')->saveRule($rule);

        $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a créé une règle', $this->container->getParameter('supervisor_email'));
        $this->get('session')->getFlashBag()->add('create', 'La règle a été créée');
        return $this->redirect($this->generateUrl('rule_by_id', array('id' => $rule->getId())));
      }

      return $this->render('UrbicandeIntrigueBundle:Rule:new.html.twig', array(
        'rule' => $rule,
        'form'   => $form->createView(),
      ));
    }

    /**
     * Displays a form to edit an existing Rule entity.
     *
     */
    public function editAction($id)
    {
      $rule = $this->get('urbicande.rule_manager')->loadRule($id);

      if (!$rule) {
        throw $this->createNotFoundException('Unable to find Rule entity.');
      }

      $editForm = $this->createForm(new RuleType(), $rule);

      return $this->render('UrbicandeIntrigueBundle:Rule:edit.html.twig', array(
        'rule'      => $rule,
        'form'   => $editForm->createView(),
      ));
    }

     /**
     * Reverts this rule to a previous version
     * @param  Request $request 
     * @param  integer  $id      Id of the object
     */
    public function revertAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $rule = $em->find('Urbicande\IntrigueBundle\Entity\Rule', $id);
        $version = $request->get('version');

        $repo->revert($rule, intval($version));
        $em->persist($rule);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('revert', 'La règle a été restaurée');
        return $this->redirect($this->generateUrl('rule_by_id', array('id' => $id)));
    }

    /**
     * Edits an existing Rule entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
      $rule = $this->get('urbicande.rule_manager')->loadRule($id);

      if (!$rule) {
        throw $this->createNotFoundException('Unable to find Rule entity.');
      }

      $editForm = $this->createForm(new RuleType(), $rule);
      $editForm->bind($request);

      if ($editForm->isValid()) {
        $this->get('urbicande.rule_manager')->saveRule($rule);

        $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a édité une règle', $this->container->getParameter('supervisor_email'));
        $this->get('session')->getFlashBag()->add('update', 'La règle a été mise à jour');
        return $this->redirect($this->generateUrl('rule_by_id', array('id' => $id)));
      }

      return $this->render('UrbicandeIntrigueBundle:Rule:edit.html.twig', array(
          'rule'      => $rule,
          'form'   => $editForm->createView(),
      ));
    }

    /**
     * Deletes a Rule entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
      $rule = $this->get('urbicande.rule_manager')->loadRule($id);

      if (!$rule) {
          throw $this->createNotFoundException('Unable to find Rule entity.');
      }

      $this->get('urbicande.rule_manager')->removeRule($rule);

      $this->get('urbicande.mail_manager')->sendAlertMail($this->getUser(), 'a supprimé une règle', $this->container->getParameter('supervisor_email'));
      $this->get('session')->getFlashBag()->add('update', 'La règle a été supprimée');
      return $this->redirect($this->generateUrl('rule_list'));
    }

    /**
     * Generate a .rtf file of the rule
     * @param  Request $request
     * @param  int  $id      Id of the rule to generate
     * @return text/richtext Rtf file
     */
    public function generateAction(Request $request, $id)
    {   
        $rule = $this->get('urbicande.rule_manager')->loadRule($id);

        //Loading rtf template file
        $rtf = file_get_contents(__DIR__.'/../Resources/templates/rule_template.rtf', "rb");
        //Replacing placeholders with real values
        $rtf = str_replace('%title%', $rule->getName(), $rtf);
        $rtf = str_replace('%number%', $rule->getNumber(), $rtf);
        $rtf = str_replace('%body%', strip_tags($rule->getDescription()), $rtf);
        $rtf = str_replace('%writer%', $rule->getWriter(), $rtf);
        
        //Rendering file to download
        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $rule->getName());
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
