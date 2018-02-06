<?php
namespace Tamce\SlimModule;

use Tamce\SlimModule\Interfaces\Module as IModule;

class Loader
{
    protected $app;
    protected $loaded = [];
    protected $prefix;

    /**
     * Initialize a module loader
     *
     * @param \Slim\App $app    The instance of slim app
     * @param string $prefix    The prefix of each module class
     */
    public function __construct(\Slim\App $app, $prefix = '')
    {
        $this->app = $app;
        $this->prefix = $prefix;
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
    public function load($class, $conf = [], $name = null)
    {
        if (empty($name))
            $name = $class;
        $class = $this->prefix.$class;
        if (!class_exists($class)) {
            if (class_exists($class.'\\Loader')) {
                $class = $class.'\\Loader';
            }
        }

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
     * @param mixed name
     * @throws \Exception
     * @return $this
     */
    public function setup($name = null)
    {
        if (is_array($name)) {
            foreach ($name as $i) {
                $this->setup($i);
            }
        }
        if (empty($name)) {
            foreach ($this->loaded as $c) {
                $c->setup();
            }
        } else {
            if (empty($this->loaded[$name]))
                throw new \Exception('Name '.$name.' do not satisfy any class loaded!');
            $this->loaded[$name]->setup();
        }
        return $this;
    }

    /**
     * Determines that if a given class name has been loaded.
     * 
     * @param $class        Class name to be check
     * @return bool
     */
    public function isLoaded($class)
    {
        foreach ($this->loaded as $key => $value) {
            if ($value instanceof $class)
                return true;
        }
        return false;
    }

    /**
     * Returns the loaded classes' name.
     * 
     * @return array    The names of loaded classes
     */
    public function loaded()
    {
        return array_keys($this->loaded);
    }
}
