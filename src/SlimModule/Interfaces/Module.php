<?php
namespace Tamce\SlimModule\Interfaces;

use Slim\App;

interface Module
{
    /**
     * Called when users ask to run a `setup` command from cli
     * You can create tables in the database or setup other things you want.
     * Notice that when `setup` function is called, the `load` function must has already been called.
     *
     * @throws Exception
     * @return void
     */
    public function setup();

    /**
     * Called when this module is attaching to slim.
     * You can load other files you need or configurate your module here.
     *
     * @param \Slim\App $app    Slim app instance
     * @param array     $config Extra config passed when load a module.
     * @return void
     */
    public function load(App $app, $config);

    /**
     * Return the \Slim\App instance attached to this module.
     *
     * @return \Slim\App
     */
    public function getApp();
}
