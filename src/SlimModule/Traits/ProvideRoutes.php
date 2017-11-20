<?php
namespace Tamce\SlimModule\Traits;

trait ProvideRoutes
{
    /**
     * Provide a easyway to define group of routes for slim app.
     *
     * @param array $conf       The array should has two keys:\
     *                          `prefix` (default is `''`) and `routes` (default is `[]`)\
     *                          each `routes` should look like this: '/users' => ['GET', SlimRouteable]
     *                          [
     *                              'prefix' => '',
     *                              'routes' => [
     *                                  '/users' => ['GET', function () { return 'Hello'; }]
     *                              ]
     *                          ]
     * @return $this
     */
    public function loadRoutes(array $conf)
    {
        if (empty($conf['prefix']))
            $conf['prefix'] = '';
        if (empty($conf['routes']))
            $conf['routes'] = [];

        $this->getApp()->group($conf['prefix'], function () use ($conf) {
            foreach ($conf['routes'] as $uri => $r) {
                $r[0] = is_array($r[0]) ? $r[0] : [$r[0]];
                $this->map($r[0], $uri, $r[1]);
            }
        });
        return $this;
    }
}

