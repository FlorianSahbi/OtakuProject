<?php

namespace otakuProject\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('otakuProjectUserBundle:Default:index.html.twig');
    }
}
