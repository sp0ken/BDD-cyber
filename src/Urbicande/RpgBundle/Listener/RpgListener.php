<?php
namespace Urbicande\RpgBundle\Listener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Gedmo\Loggable\Entity\LogEntry;
use Urbicande\UserBundle\Entity\User as User;
use Urbicande\UserBundle\Entity\Setting;
use Urbicande\RpgBundle\Entity\Stat;
use Urbicande\PersoBundle\Entity\PersonnageComment;
use Urbicande\IntrigueBundle\Entity\IntrigueComment;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * Listens to class updates and creation and grant corresponding xp
 * to the current user.
 */
class RpgListener
{	

    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
      $securityContext = $this->container->get('security.context');
      $session = $this->container->get('session');
      $user = $securityContext->getToken()->getUser();
	    $em = $eventArgs->getEntityManager();
      $uow = $em->getUnitOfWork();
      foreach ($uow->getScheduledEntityInsertions() AS $entity) {
        if(!$entity instanceof LogEntry && !$entity instanceof User && $user instanceof User) {
          if($entity instanceof IntrigueComment || $entity instanceof PersonnageComment) {
            $user->getStat()->addXp(5);
          } else {
            $user->getStat()->addXp(25);
          }
        }
      }

      foreach ($uow->getScheduledEntityUpdates() AS $entity) {
        if(!$entity instanceof LogEntry && !$entity instanceof User && $user instanceof User && !$entity instanceof Setting  && !$entity instanceof Stat) {
          $user->getStat()->addXp(10);
        }
      }

      foreach ($uow->getScheduledEntityDeletions() AS $entity) {
        $user->getStat()->addXp(5);
      }

      if($user instanceof User) {
        $level = floor($user->getStat()->getXp()/100)+1;
        $caracPoints = $user->getStat()->getCaracPoint();
        if($level != $user->getStat()->getLevel()) {
              $user->getStat()->setLevel($level);
              $user->getStat()->setCaracPoint($caracPoints+1);
              $session->getFlashBag()->add('create', 'Félicitation, vous avez gagné un niveau !');
        }
        $uow->persist($user->getStat());
        $uow->computeChangeSet($em->getClassmetadata('Urbicande\RpgBundle\Entity\Stat'), $user->getStat());
      }    
    }
}