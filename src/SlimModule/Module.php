<?php
namespace Tamce\SlimModule;

class Module implements Interfaces\Module
{
    protected $app;
    protected $config;

    public function load(\Slim\App $app, $config = null)
    {
        $this->app = $app;
        $this->config = null;
    }

    public function setup()
    {}

    public function getApp()
    {
        return $this->app;
    }
}
