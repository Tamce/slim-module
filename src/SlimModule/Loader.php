<?php
namespace Tamce\SlimModule;

use Tamce\SlimModule\Interfaces\Module as IModule;

class Loader
{
    protected $app;
    protected $loaded = [];

    public function __construct(\Slim\App $app)
    {
        $this->app = $app;
    }

    /**
     * Add a module to this loader
     *
     * @param string $class     The class name of the module to load, if class `$class` not exist, we also check `$class\Loader`
     * @param array $conf       Additional params to pass to the module when loading that module
     * @param string $name      Assign a name for the new loaded module.
     * @throws \Exception
     * @return $this
     */
    public function add($class, array $conf = [], $name = null)
    {
        if (!class_exists($class)) {
            if (class_exists($class.'\\Loader')) {
                $class = $class.'\\Loader';
            }
        }
        if (empty($name))
            $name = $class;

        $class = new $class;
        if (!($class instanceof IModule)) {
            throw new \Exception("Class `$class` has not implement interface: ".IModule::class);
        }
        if (!empty($this->loaded[$name])) {
            throw new \Exception("Name `$name` has been used!");
        }

        $class->load($this->app, $conf);
        $this->loaded[$name] = $class;
        return $this;
    }

    /**
     * Run setup command on each loaded module.
     *
     * @throws \Exception
     * @return $this
     */
    public function setup()
    {
        foreach ($this->loaded as $c) {
            $c->setup();
        }
        return $this;
    }
}
