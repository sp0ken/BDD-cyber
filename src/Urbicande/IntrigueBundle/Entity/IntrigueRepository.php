<?php

namespace Urbicande\IntrigueBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * IntrigueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IntrigueRepository extends EntityRepository
{ 
  /**
   * Retourne toutes les intrigues d'un scénariste
   * @param  int $userId Id du scénariste
   * @return Doctrine_Collection
   */
  public function getByUser($userId)
  {
    $query = $this->createQueryBuilder('i');

    $query->leftJoin('i.writer', 'w');

    $query->where('w.id = :user')
          ->setParameter('user', $userId)
          ->orderBy('i.name', 'ASC');

    return $query->getQuery()->getResult();
  }
    /**
   * Compte le nombre d'intrigue par statut 
   * @return Array
   */
  public function countStatus()
  {
    $em = $this->getEntityManager();
    $query = $em->createQuery('SELECT i.status, COUNT(i.id) AS nb_status FROM Urbicande\IntrigueBundle\Entity\Intrigue i GROUP BY i.status ORDER BY i.status DESC');
    
    $query->useResultCache(true);
    $query->setResultCacheLifetime(3600);

    $results = $query->getResult();
    return $results;
  }

  /**
   * Compte le nombre d'intrigue pour un perso et un type donné
   * @param  int $userId Id du scénariste
   * @return Doctrine_Collection
   */
  public function countByUserAndType($userName, $typeName)
  {
    $query = $this->createQueryBuilder('i');

    $query->leftJoin('i.type', 't');

    $query->where('w.id = :user')
          ->setParameter('user', $userId)
          ->orderBy('i.name', 'ASC');

    return $query->getQuery()->getResult();
  }
}
