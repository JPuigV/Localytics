<?php

namespace Jpuig\LocalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JpuigLocalyticsBundle:Default:index.html.twig');
    }
}
