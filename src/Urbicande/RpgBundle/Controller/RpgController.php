<?php

namespace Urbicande\RpgBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbicande\RpgBundle\Entity\Stat;

class RpgController extends Controller
{
    public function addCaracAction(Request $request)
    {
      if($request->isXmlHttpRequest())  {
        $carac = $request->get('carac');
        $user = $this->getUser();
        switch ($carac) {
          case 'u':
            $user->getStat()->setUfologie($user->getStat()->getUfologie() + 1);
            break;
          case 'r':
            $user->getStat()->setRelecture($user->getStat()->getRelecture() + 1);
            break;
          case 'b':
            $user->getStat()->setBlague($user->getStat()->getBlague() + 1);
            break;
          case 'i':
            $user->getStat()->setImagination($user->getStat()->getImagination() + 1);
            break;
        }
        $user->getStat()->setCaracPoint($user->getStat()->getCaracPoint() - 1);
        $this->container->get('fos_user.user_manager')->updateUser($user);
        
        $response = new JsonResponse();
        $response->setData(array('data' => 'ok'));
        return $response;
      } else {
        return $this->redirect($this->generateUrl('Home'));
      }
    }

    public function updateAction()
    {
      if($this->getUser()->getEmail() == 'jcoquery@gmail.com') {
        $users = $this->container->get('fos_user.user_manager')->findUsers();
        foreach ($users as $key => $user) {
          $xp = 0;
          $records = $this->container->get('urbicande.user_manager')->getRecords($user->getUsername());
          foreach ($records as $key => $record) {
            switch ($record->getAction()) {
              case 'create':
                $xp = $xp + 25;
                break;
              case 'update':
                $xp = $xp + 10;
                break;
              case 'remove':
                $xp = $xp - 25;
                break;
              default:
                $xp = $xp;
                break;
            }
          }
          if($user->getStat()) {
            $user->getStat()->resetStat($xp);
          } else {
            $stat = new Stat($xp);
            $stat->setAvatar('avatar'.rand(1,16));
            $stat->setUser($user);
            $user->setStat($stat);
          }
          $this->container->get('fos_user.user_manager')->updateUser($user);
        }
      }
      return $this->redirect($this->generateUrl('Home'));
    }
}
