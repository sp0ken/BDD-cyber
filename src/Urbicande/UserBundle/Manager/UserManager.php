<?php

namespace Urbicande\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager as Manager;

class UserManager extends Manager
{
  private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getRecords($username)
    {
      $records = $this->em->getRepository('Gedmo\Loggable\Entity\LogEntry')->findBy(array('username' => $username));
      return $records;
    }
}