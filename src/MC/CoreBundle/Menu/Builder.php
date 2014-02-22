<?php
namespace MC\CoreBundle\Menu;


use JMS\SecurityExtraBundle\Metadata\Driver\AnnotationDriver;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContext;


class Builder
{
    /** @var ContainerInterface */
    private $container;


    /** @var Router */
    private $router;


    /**
     * @var SecurityContext
     */
    private $securityContext;

    /**
     * @var \JMS\SecurityExtraBundle\Metadata\Driver\AnnotationDriver
     */
    private $metadataReader;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router = $this->container->get('router');
        $this->securityContext = $this->container->get('security.context');
        $this->metadataReader = new AnnotationDriver(new \Doctrine\Common\Annotations\AnnotationReader());
    }

    /**
     * @param $class
     * @return \JMS\SecurityExtraBundle\Metadata\ClassMetadata
     */
    public function getMetadata($class)
    {
        return $this->metadataReader->loadMetadataForClass(new \ReflectionClass($class));
    }


    public function hasRouteAccess($routeName)
    {
        $token = $this->securityContext->getToken();
        if ($token->isAuthenticated()) {
            $route = $this->router->getRouteCollection()->get($routeName);
            $controller = $route->getDefault('_controller');
            list($class, $method) = explode('::', $controller, 2);

            $metadata = $this->getMetadata($class);
            if (!isset($metadata->methodMetadata[$method])) {
                return false;
            }

            foreach ($metadata->methodMetadata[$method]->roles as $role) {
                if ($this->securityContext->isGranted($role)) {
                    return true;
                }
            }
        }
        return false;
    }


    public function filterMenu(ItemInterface $menu)
    {
        foreach ($menu->getChildren() as $child) {
            /** @var \Knp\Menu\MenuItem $child */
            $routes = $child->getExtra('routes');
            if ($routes !== null) {
                $route = current(current($routes));

                if ($route && !$this->hasRouteAccess($route)) {
                    $menu->removeChild($child);
                }

            }
            $this->filterMenu($child);
        }
        return $menu;
    }


    public function createAdminMenu(FactoryInterface $factory)
    {
        $menu = $factory->createItem('root');
        // dashboard
        $menu->addChild('Dashboard', array(
                'route' => 'home'
            ))
        ;
        // quick links
        $menu->addChild('Quick links', array())->setAttribute('dropdown', true)
            ->addChild('New post', array(
                'route' => 'home'
            ))->getParent()
            ->addChild('New category', array(
                'route' => 'test'
            ))->getParent()
            ->addChild('New user', array(
                'route' => 'test1'
            ))->getParent()
            ->addChild('New link', array(
                'route' => 'test2'
            ))->getParent()
            ->addChild('New developer', array(
                'route' => 'home'
            ))->getParent()
            ->addChild('New project', array(
                'route' => 'home'
            ))->getParent()
            ->addChild('New testimonial', array(
                'route' => 'home'
            ))->getParent()
            ->addChild('New skill', array(
                'route' => 'home'
            ))->getParent()
        ;

        // blog
        $menu->addChild('Blog', array())->setAttribute('dropdown', true)
            ->addChild('Posts', array(
                'route' => 'home'
            ))->getParent()
            ->addChild('Categories', array(
                'route' => 'home'
            ))->getParent()
        ;
        $menu->addChild('Misc', array())->setAttribute('dropdown', true)
            ->addChild('Links', array('route' => 'home'))->getParent()
            ->addChild('Developers', array('route' => 'home'))->getParent()
            ->addChild('Skills', array('route' => 'home'))->getParent()
            ->addChild('Project', array('route' => 'home'))->getParent()
            ->addChild('Testimonials', array('route' => 'home'))->getParent()
            ->addChild('Users', array('route' => 'home'))->getParent();

        $this->filterMenu($menu);

        if ($this->container->get('session')->has('real_user_id')) {
            $menu->addChild('Deimpersonate', array('route' => 'home'));
        }
        $menu->addChild('Log out', array('route' => 'home'))->getParent();


        return $menu;
    }
}