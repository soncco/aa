<?php

namespace Andean\TrenBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function portadaAction()
    {
        return $this->render('TrenBundle:Default:index.html.twig');
    }
}
