<?php

namespace Urbicande\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\UserBundle\Manager\BaseManager;

class MailManager extends BaseManager
{
    protected $mailer;

    protected $templating;

    public function __construct(\Swift_Mailer $mailer, \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendPersoCommentMail(\Urbicande\UserBundle\Entity\User $commenter, \Urbicande\UserBundle\Entity\User $commentee, $comment)
    {
      if ($commentee != $commenter) {
        $message = \Swift_Message::newInstance()
          ->setSubject('[cyber] '.$commenter. ' a commenté votre personnage')
          ->setFrom('noreply@urbicande.fr')
          ->setTo($commentee->getEmail())
          ->setBody(
            $this->templating->render(
              'UrbicandePersoBundle:Email:persoComment.html.twig',
              array(
                'commenter' => $commenter,
                'commentee' => $commentee,
                'comment' => $comment,
              )
          ))
          ->setContentType("text/html");
        if($commentee->getSetting()->getHasNotification()){
          return $this->mailer->send($message);
        } else {
          return false;
        }
      }
    }

    public function sendIntrigueCommentMail(\Urbicande\UserBundle\Entity\User $commenter, \Urbicande\UserBundle\Entity\User $commentee, $comment)
    {
      if ($commentee != $commenter) {
        $message = \Swift_Message::newInstance()
          ->setSubject('[cyber] '.$commenter. ' a commenté votre intrigue')
          ->setFrom('noreply@urbicande.fr')
          ->setTo($commentee->getEmail())
          ->setBody(
            $this->templating->render(
              'UrbicandeIntrigueBundle:Email:intrigueComment.html.twig',
              array(
                'commenter' => $commenter,
                'commentee' => $commentee,
                'comment' => $comment,
              )
          ))
          ->setContentType("text/html");
        if($commentee->getSetting()->getHasNotification()){
          return $this->mailer->send($message);
        } else {
          return false;
        }
      }
    }

    public function sendAlertMail(\Urbicande\UserBundle\Entity\User $author, $action, $recipient)
    {
      $message = \Swift_Message::newInstance()
          ->setSubject('[cyber] '.$author.' '.$action)
          ->setFrom('noreply@urbicande.fr')
          ->setTo($recipient)
          ->setBody($author.' a bien bossé aujourd‘hui');
          return $this->mailer->send($message);
    }
}