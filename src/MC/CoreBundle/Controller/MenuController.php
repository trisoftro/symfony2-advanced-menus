<?php

namespace MC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/menu")
 */
class MenuController extends Controller
{
    /**
     * @Route("", name="menu")
     * @Template("MCCoreBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        return array('name' => uniqid());
    }
}
