<?php
/*
 * Copyright(c) 2000-2016 Daisy CO., LTD. All Rights Reserved.
 *
 * http://daisy.link/
 */

namespace Plugin\ExtendEntity;

use Eccube\Application;

class Event
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param \Eccube\Event\EventArgs $event
     */
    public function onAdminProductEditInitialize($event)
    {
        $app = $this->app;
        $Product = $event->getArgument('Product');
        if (strlen($Product->getId())) {
            /** @var \Plugin\ExtendEntity\Entity\Product $ExProduct */
            $ExProduct = $app['plugin.extend_entity.repository.product']->find($Product->getId());
            echo $ExProduct->getProduct()->getId();
            echo $ExProduct->getName();
        }
    }
}
