<?php

namespace otakuProject\nendoroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('otakuProjectnendoroidBundle:Default:index.html.twig');
    }
}
