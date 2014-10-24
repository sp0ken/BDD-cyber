<?php

namespace Urbicande\HomeBundle\Manager;

use Doctrine\ORM\EntityManager;
use Urbicande\HomeBundle\Manager\BaseManager;
use Gedmo\Tool\Wrapper\EntityWrapper;

class LogManager extends BaseManager
{
    protected $em;
    protected $exception = array('Urbicande\PersoBundle\Entity\PersonnageComment', 'Urbicande\IntrigueBundle\Entity\IntrigueComment', 'Urbicande\ChronoBundle\Entity\Timing', 'Urbicande\IntrigueBundle\Entity\Synopsis', 'Urbicande\IntrigueBundle\Entity\Plot');

    const CREATE = 'a créé';
    const REMOVE = 'a supprimé';
    const UPDATE = 'a mis à jour';
    const COMMENT = 'a commenté';
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadAll() {
       return $this->getRepository()->findBy(array(), array('loggedAt' => 'DESC'), 200);
    }

    public function loadHome() {
       return $this->getRepository()->findBy(array(), array('loggedAt' => 'DESC'), 10);
    }

    /**
     * Formats log entries to make them display friendlier
     * @param  Doctrine_Collection $logs
     * @return Array
     */
    public function format($logs)
    {
      $formattedLogs = array();
      foreach ($logs as $key => $log) {
        $formattedLogs[$key]['date'] = $log->getLoggedAt();
        $formattedLogs[$key]['author'] = ucfirst($log->getUsername());
        $object = $this->em->getRepository($log->getObjectClass())->find($log->getObjectId());
        //If object is in the exception list (list of object where we are rather interested in their parent)
        if (in_array($log->getObjectClass(), $this->exception) && isset($object)) {
          $formattedLogs[$key]['object'] = $object->getParent();
          $formattedLogs[$key]['route'] = $this->getObjectRoute($object->getParent()->getClass());
          $formattedLogs[$key]['id'] = $object->getParent()->getId();
        } else if(isset($object)) {
          $formattedLogs[$key]['object'] = $object;
          $formattedLogs[$key]['route'] = $this->getObjectRoute($log->getObjectClass());
          $formattedLogs[$key]['id'] = $log->getObjectId();
        } else { //If object does not exist anymore (mainly when dealing with deletion)
          $formattedLogs[$key]['object'] = $this->getObjectName($log->getObjectClass());
        }
        //If the object in the log is a comment we change its action to comment (rather than create)
        if ($log->getObjectClass() == 'Urbicande\PersoBundle\Entity\PersonnageComment' && $log->getAction() != constant('self::REMOVE')) {
          $formattedLogs[$key]['action'] = constant('self::COMMENT');
          $formattedLogs[$key]['object'] = 'un personnage';
        } elseif ($log->getObjectClass() == 'Urbicande\IntrigueBundle\Entity\IntrigueComment' && $log->getAction() != constant('self::REMOVE')) {
            $formattedLogs[$key]['action'] = constant('self::COMMENT');
            $formattedLogs[$key]['object'] = 'une intrigue';
        } else {
          $formattedLogs[$key]['action'] = constant('self::'.strtoupper($log->getAction()));
        }
      }
      return $formattedLogs;
    }

    /**
     * Returns a print friendly name for each object class
     * @param  String $objectClass
     * @return String
     */
    public function getObjectName($objectClass)
    {
        switch ($objectClass) {
            case 'Urbicande\ChronoBundle\Entity\Event':
                return 'un évènement';
                break;
            case 'Urbicande\ChronoBundle\Entity\Sceno':
                return 'une scénographie';
                break;
            case 'Urbicande\ChronoBundle\Entity\Timing':
                return 'le timing d‘un évènement';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Data':
                return 'une donnée';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Implication':
                return 'une implication d‘intrigue';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Intrigue':
                return 'une intrigue';
                break;
            case 'Urbicande\IntrigueBundle\Entity\IntrigueComment':
                return 'un commentaire d‘intrigue';
                break;
            case 'Urbicande\IntrigueBundle\Entity\IntrigueType':
                return 'un type d‘intrigue';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Object':
                return 'un objet';
                break;
            case 'Urbicande\IntrigueBundle\Entity\ObjectType':
                return 'un type d‘objet';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Plot':
                return 'le détail d‘une intrigue';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Rule':
                return 'une règle';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Synopsis':
                return 'le synopsis d‘une intrigue';
                break;
            case 'Urbicande\MiscBundle\Entity\Background':
                return 'un document de back';
                break;
            case 'Urbicande\PersoBundle\Entity\Groupe':
                return 'un groupe';
                break;
            case 'Urbicande\PersoBundle\Entity\Personnage':
                return 'un personnage';
                break;
            case 'Urbicande\PersoBundle\Entity\PersonnageComment':
                return 'un commentaire de personnage';
                break;
            case 'Urbicande\PersoBundle\Entity\PersonnageType':
                return 'un type de personnage';
                break;
            case 'Urbicande\PersoBundle\Entity\RelationType':
                return 'un type de relation';
                break;
            case 'Urbicande\PersoBundle\Entity\Relation':
                return 'une relation';
                break;
            case 'Urbicande\PersoBundle\Entity\Level':
                return 'un niveau';
                break;
            case 'Urbicande\PersoBundle\Entity\Skill':
                return 'une compétence';
                break;
            default:
                return 'un truc mystère';
                break;
        }
    }

    /**
     * Returns the route to show each object
     * @param  String $objectClass
     * @return String
     */
    public function getObjectRoute($objectClass)
    {
        switch ($objectClass) {
            case 'Urbicande\ChronoBundle\Entity\Event':
                return 'event_by_id';
                break;
            case 'Urbicande\ChronoBundle\Entity\Sceno':
                return 'sceno_by_id';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Data':
                return 'data_by_id';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Implication':
                return 'implication_by_id';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Intrigue':
                return 'intrigue_by_id';
                break;
            case 'Urbicande\IntrigueBundle\Entity\IntrigueType':
                return 'intrigue_type_by_id';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Object':
                return 'object_by_id';
                break;
            case 'Urbicande\IntrigueBundle\Entity\ObjectType':
                return 'object_type_by_id';
                break;
            case 'Urbicande\IntrigueBundle\Entity\Rule':
                return 'rule_by_id';
                break;
            case 'Urbicande\MiscBundle\Entity\Background':
                return 'background_by_id';
                break;
            case 'Urbicande\PersoBundle\Entity\Groupe':
                return 'groupe_by_id';
                break;
            case 'Urbicande\PersoBundle\Entity\Personnage':
                return 'perso_by_id';
                break;
            case 'Urbicande\PersoBundle\Entity\Level':
                return 'level_by_id';
                break;
            case 'Urbicande\PersoBundle\Entity\PersonnageType':
                return 'perso_type_by_id';
                break;
            case 'Urbicande\PersoBundle\Entity\RelationType':
                return 'relation_type_by_id';
                break;
            case 'Urbicande\PersoBundle\Entity\Relation':
                return 'relation_by_id';
                break;
            case 'Urbicande\PersoBundle\Entity\Skill':
                return 'skill_by_id';
                break;
            default:
                return false;
                break;
        }
    }

    public function getRepository()
    {
        return $this->em->getRepository('Gedmo\Loggable\Entity\LogEntry');
    }
}