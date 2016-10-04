<?php
/*
 * Copyright(c) 2000-2016 Daisy CO., LTD. All Rights Reserved.
 *
 * http://daisy.link/
 */

namespace Plugin\ExtendEntity\Entity;

/**
 * Product
 */
class Product extends \Eccube\Entity\Product
{
    /** @var \Eccube\Entity\Product */
    protected $Product;

    /**
     * @return string
     */
    public function getName()
    {
        return parent::getName() . parent::getName();
    }

    /**
     * @return \Eccube\Entity\Product
     */
    public function getProduct()
    {
        return $this->Product;
    }

    /**
     * @param \Eccube\Entity\Product $Product
     * @return Product
     */
    public function setProduct($Product)
    {
        $this->Product = $Product;
        return $this;
    }
}
