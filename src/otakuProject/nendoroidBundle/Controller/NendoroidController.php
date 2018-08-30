<?php

namespace otakuProject\nendoroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use otakuProject\nendoroidBundle\Entity\Nendoroid;
use otakuProject\nendoroidBundle\Entity\Serie;
use otakuProject\nendoroidBundle\Entity\User;
use otakuProject\nendoroidBundle\Entity\rangeNumber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use otakuProject\nendoroidBundle\Form\NendoroidType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NendoroidController extends Controller
{
  // views
  public function nendoroidsListAction()
  {
    return $this->render('otakuProjectnendoroidBundle:nendoroidViews:list.html.twig');
  }

  public function userProfilAction($username)
  {
    $loggedInUser = $this->getUser()->getUsername();

    $em = $this->getDoctrine()->getManager();
    $repositoryUser = $em->getRepository('otakuProjectUserBundle:User');
    $userToSee = $repositoryUser->findByUsername($username);

    if($loggedInUser == $userToSee[0])
    {
      $currentUser = "true";
    }
    else 
    {
      $currentUser = "false";
    }
    
    return $this->render('otakuProjectnendoroidBundle:nendoroidViews:userInfo.html.twig', 
    ['currentUser' => $currentUser, 'usernamesProfil' => $userToSee[0]]);
  }

  // get data
  public function getNendoroidsAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $repositoryNendo = $em->getRepository(Nendoroid::class);

    $range = $request->request->get('rangeId');
    switch ($range) 
    {
      case 'all'    : $nendoroids = $repositoryNendo->findAll()           ; break;
      case '001-100': $nendoroids = $repositoryNendo->findByRangeNumber(1); break;
      case '101-200': $nendoroids = $repositoryNendo->findByRangeNumber(2); break;
      case '201-300': $nendoroids = $repositoryNendo->findByRangeNumber(3); break;
      case '301-400': $nendoroids = $repositoryNendo->findByRangeNumber(4); break;
      case '401-500': $nendoroids = $repositoryNendo->findByRangeNumber(5); break;
      case '501-600': $nendoroids = $repositoryNendo->findByRangeNumber(6); break;
      case '601-700': $nendoroids = $repositoryNendo->findByRangeNumber(7); break;
      case '701-800': $nendoroids = $repositoryNendo->findByRangeNumber(8); break;
      case '801-900': $nendoroids = $repositoryNendo->findByRangeNumber(9); break;
    }
    
    foreach ($nendoroids as $nendoroid) 
    {
      $arrayNendoroids[] = ['id' => $nendoroid->getId(), 'name' => $nendoroid->getName(), 'number' => $nendoroid->getNumber()];
    }
    return new JsonResponse(['nendoroids' => $arrayNendoroids]);
  }  

  public function getUsersAction()
  {
    $em = $this->getDoctrine()->getManager();
    $repositoryUsers = $em->getRepository('otakuProjectUserBundle:User');
    $users = $repositoryUsers->findAll();

    foreach ($users as $user) 
    {
      $arrayUsers[] = ['id' => $user->getId(), 'username' => $user->getUsername()];
    }
    return new JsonResponse(['users' => $arrayUsers]);    
  }

  public function getUserListsAction(Request $request)
  {
    $usernameTargetLists = $request->request->get('usernameTargetLists');

    $em = $this->getDoctrine()->getManager();
    $repositoryUsers = $em->getRepository('otakuProjectUserBundle:User');
    $user = $repositoryUsers->findByUsername($usernameTargetLists);

    // $loggedInUser = $this->getUser();

    $loveList       = $user[0]->getNendoroidsLove();
    $collectionList = $user[0]->getNendoroidsCollection();
    $likeList       = $user[0]->getNendoroidsLike();

    if($loveList->isEmpty())
    {
      $loveListArray[] = ['list' => 'none', 'notice' => 'The love list is empty.'];
    }
    else 
    {
      foreach ($loveList as $nendoroid) 
      {
        $loveListArray[] = ['id' => $nendoroid->getId(), 'name' => $nendoroid->getName(), 'number' => $nendoroid->getNumber(), 'list' => 'love'];
      }
    } 

    if ($collectionList->isEmpty())
    {
      $collectionListArray[] = ['list' => 'none', 'notice' => 'The collection list is empty.'];
    }
    else
    {
      foreach ($collectionList as $nendoroid) 
      {
        $collectionListArray[] = ['id' => $nendoroid->getId(), 'name' => $nendoroid->getName(), 'number' => $nendoroid->getNumber(), 'list' => 'collection'];
      }
    }

    if($likeList->isEmpty())
    {
      $likeListArray[] = ['list' => 'none', 'notice' => 'The like list is empty.'];
    }
    else
    {
      foreach ($likeList as $nendoroid) 
      {
        $likeListArray[] = ['id' => $nendoroid->getId(), 'name' => $nendoroid->getName(), 'number' => $nendoroid->getNumber(), 'list' => 'like'];
      }
    }

    $allList =  array_merge($loveListArray , $collectionListArray , $likeListArray);

    return new JsonResponse(['nendoroids' => $allList]); 
  }

  public function searchAjaxAction(Request $request)
  {
    $keyword = $request->request->get('key');

    $em = $this->getDoctrine()->getManager();
    $repositoryNendo = $em->getRepository(Nendoroid::class);
    $nendoroids = $repositoryNendo->likeSearch($keyword);

    foreach ($nendoroids as $nendoroid) 
    {
      $arrayNendo[] = ['id' => $nendoroid->getId(), 'name' => $nendoroid->getName(), 'name' => $nendoroid->getName(), 'number' => $nendoroid->getNumber()];
    }
    return new JsonResponse(['nendoroids' => $arrayNendo]);    
  }

  // add/remove lists
  public function nendoroidAjaxAction(Request $request)
  {
    $user = $this->getUser();

    $em = $this->getDoctrine()->getManager();
    $repositoryNendo = $em->getRepository(Nendoroid::class); 
    $selectedNendo = $request->request->get("idNendo");
    $nendoroid = $repositoryNendo->find($selectedNendo);
    
    $action = $request->request->get("action");
    switch ($action) {
      case 'addLike': 
        $user->addNendoroidLike($nendoroid);
        $response[] = ["message" => "You liked this Nendoroid."]; 
    break;
      case 'addLove': 
        $user->addNendoroidLove($nendoroid);
        $response[] = ["message" => "You shown your interest for this Nendoroid."]; 
    break;
      case 'addCollection': 
        $user->addNendoroidCollection($nendoroid);
        $response[] = ["message" => "Nendoroid added to your collection."]; 
    break;
      case 'removeLike': 
        $user->removeNendoroidLike($nendoroid);
        $response[] = ["message" => "You doesnt like it anymore."]; 
    break;
      case 'removeLove': 
        $user->removeNendoroidLove($nendoroid); 
        $response[] = ["message" => "This Nendoroid doesnt interest you anymore."];
    break;
      case 'removeCollection': 
        $user->removeNendoroidCollection($nendoroid);
        $response[] = ["message" => "Nendoroid removed from your collection."]; 
    break;
    }

    $em->persist($nendoroid);
    $em->flush();
    
    return new JsonResponse(['message' => $response]);
  } 
}