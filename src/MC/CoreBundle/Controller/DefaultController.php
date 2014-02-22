<?php

namespace MC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("", name="home")
     * @Template("MCCoreBundle:Default:index.html.twig")
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY ")
     */
    public function indexAction()
    {
        return $this->render('MCCoreBundle:Default:index.html.twig', []);
    }

    /**
     * @Route("/test", name="test")
     * @Template("MCCoreBundle:Default:index.html.twig")
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY ")
     */
    public function testAction()
    {
        return $this->render('MCCoreBundle:Default:index.html.twig', []);
    }

    /**
     * @Route("/test1", name="test1")
     * @Template("MCCoreBundle:Default:index.html.twig")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function test1Action()
    {
        return $this->render('MCCoreBundle:Default:index.html.twig', []);
    }

    /**
     * @Route("/test2", name="test2")
     * @Template("MCCoreBundle:Default:index.html.twig")
     * @Secure(roles="ROLE_USER ")
     */
    public function test2Action()
    {
        return $this->render('MCCoreBundle:Default:index.html.twig', []);
    }
}
