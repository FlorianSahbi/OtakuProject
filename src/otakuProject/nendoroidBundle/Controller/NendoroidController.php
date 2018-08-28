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
  public function listAction()
  {
    return $this->render('otakuProjectnendoroidBundle:nendoroidViews:list.html.twig');
  }

  public function getUserListsAjaxAction()
  {
    $loggedInUser = $this->getUser();

    $loveList       = $loggedInUser->getNendoroidsLove();
    $collectionList = $loggedInUser->getNendoroidsCollection();
    $likeList       = $loggedInUser->getNendoroidsLike();

    if($loveList->isEmpty())
    {
      $loveListArray[] = ['notice' => 'no Nendoroids here'];
    }
    else 
    {
      foreach ($loveList as $nendoroid) 
      {
        $loveListArray[] = ['id' => $nendoroid->getId(), 'number' => $nendoroid->getNumber(), 'list' => 'love'];
      }
    } 

    if ($collectionList->isEmpty())
    {
      $collectionListArray[] = ['notice' => 'no Nendoroids here'];
    }
    else
    {
      foreach ($collectionList as $nendoroid) 
      {
        $collectionListArray[] = ['id' => $nendoroid->getId(), 'number' => $nendoroid->getNumber(), 'list' => 'collection'];
      }
    }

    if($likeList->isEmpty())
    {
      $likeListArray[] = ['notice' => 'no Nendoroids here'];
    }
    else
    {
      foreach ($likeList as $nendoroid) 
      {
        $likeListArray[] = ['id' => $nendoroid->getId(), 'number' => $nendoroid->getNumber(), 'list' => 'like'];
      }
    }

    $allList =  array_merge($loveListArray , $collectionListArray , $likeListArray);

    return new JsonResponse(['nendoroids' => $allList]); 
  }

  public function userInfoAction($username)
  {
    $loggedInUser = $this->getUser()->getUsername();
    $em = $this->getDoctrine()->getManager();
    $repositoryUser = $em->getRepository('otakuProjectUserBundle:User');
    $userToSee = $repositoryUser->findByUsername($username);

    if($loggedInUser == $userToSee[0]){
      $currentUser = "true";
    }
    else {
      $currentUser = "false";
    }

    $loveList       = $userToSee[0]->getNendoroidsLove();
    $collectionList = $userToSee[0]->getNendoroidsCollection();
    $likeList       = $userToSee[0]->getNendoroidsLike();
    
    return $this->render('otakuProjectnendoroidBundle:nendoroidViews:userInfo.html.twig', 
    ['likeList' => $likeList, 'loveList' => $loveList, 'collectionList' => $collectionList, 'currentUser' => $currentUser, 'usernamesProfil' => $userToSee[0]]);
  }

  public function generateListAction()
  {
    $em = $this->getDoctrine()->getManager();
    $repositoryNendo = $em->getRepository(Nendoroid::class);
    // $nendoroids = $repositoryNendo->findAll(); // Too much figure too load, not usefull
    $nendoroids = $repositoryNendo->findByRangeNumber(9);


    foreach ($nendoroids as $nendoroid) 
    {
      $arrayNendoroids[] = ['id' => $nendoroid->getId(), 'name' => $nendoroid->getName(), 'number' => $nendoroid->getNumber()];
    }
    return new JsonResponse(['nendoroids' => $arrayNendoroids]);    
  }

  public function generateUsersAjaxAction()
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

  public function generateListRangeAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $repositoryNendo = $em->getRepository(Nendoroid::class);

    $range = $request->request->get('range');
    switch ($range) 
    {
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

  public function searchAjaxAction(Request $request)
  {
    $keyword = $request->request->get('key');
    $em = $this->getDoctrine()->getManager();
    $repositoryNendo = $em->getRepository(Nendoroid::class);
    $nendoroids = $repositoryNendo->likeSearch($keyword);

    foreach ($nendoroids as $nendoroid) 
    {
      $arrayNendo[] = ['id' => $nendoroid->getId(), 'name' => $nendoroid->getName(), 'number' => $nendoroid->getNumber()];
    }
    return new JsonResponse(['nendoroids' => $arrayNendo]);    
  }

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
        $response[] = ["message" => "You liked this Nendoroid"]; 
    break;
      case 'addLove': 
        $user->addNendoroidLove($nendoroid);
        $response[] = ["message" => "You shown your interest for this Nendoroid"]; 
    break;
      case 'addCollection': 
        $user->addNendoroidCollection($nendoroid);
        $response[] = ["message" => "Nendoroid added to your collection"]; 
    break;
      case 'removeLike': 
        $user->removeNendoroidLike($nendoroid);
        $response[] = ["message" => 'You doesnt like it anymore']; 
    break;
      case 'removeLove': 
        $user->removeNendoroidLove($nendoroid); 
        $response[] = ["message" => 'This Nendoroid doesnt interest you anymore'];
    break;
      case 'removeCollection': 
        $user->removeNendoroidCollection($nendoroid);
        $response[] = ["message" => "Nendoroid removed from your collection"]; 
    break;
    }

    $em->persist($nendoroid);
    $em->flush();
    
    $response[] = ["message" => 'Figurine bien aime'];
    return new JsonResponse(['message' => $response]);
  } 

  public function redirectUserAjaxAction(Request $request) {
    $username = $request->request->get("user");
    return $this->redirectToRoute('otaku_project_user', array('username' => $username));
  }

}

// En attente //

  // public function editAction(Request $request, $idNendo)
  // {
  //   $em = $this->getDoctrine()->getManager();
  //   $repositoryNendo = $em->getRepository(Nendoroid::class);
  //   $nendoroid = $repositoryNendo->find($idNendo);

  //   $form = $this->createForm(NendoroidType::class, $nendoroid);

  //   if($request->isMethod('POST')) 
  //   {
  //     $form->handleRequest($request);

  //     if($form->isValid()) 
  //     {
  //       $em = $this->getDoctrine()->getManager();
  //       $em->persist($nendoroid);
  //       $em->flush();

  //       return $this->redirectToRoute('otaku_project_list');
  //     }
  //   }
  //   return $this->render('otakuProjectnendoroidBundle:nendoroidViews:add.html.twig', array('form' => $form->createView()));
  // }