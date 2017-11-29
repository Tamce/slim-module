<?php
namespace Tamce\SlimModule;
use Psr\Container\ContainerInterface as Container;

class Controller
{
    protected $session;
    protected $log;
    protected $container;
    public function __construct(Container $container)
    {
        $this->session = $container->get('session');
        $this->log = $container->get('log');
        $this->container = $container;
    }
}
