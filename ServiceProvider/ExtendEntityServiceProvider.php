<?php
/*
 * Copyright(c) 2000-2016 Daisy CO., LTD. All Rights Reserved.
 *
 * http://daisy.link/
 */

namespace Plugin\ExtendEntity\ServiceProvider;

use Eccube\Application;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;
use Symfony\Component\Yaml\Yaml;

class ExtendEntityServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        $this->initDoctrine($app);
    }

    public function initDoctrine(BaseApplication $app)
    {
        $app['plugin.extend_entity.repository.product'] = $app->share(
            function () use ($app) {
                return $app['orm.em']->getRepository('Plugin\ExtendEntity\Entity\Product');
            }
        );
    }

    public function boot(BaseApplication $app)
    {
    }
}