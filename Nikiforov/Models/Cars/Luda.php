<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/6/18
 * Time: 7:54 PM
 */

namespace Nikiforov\Models\Cars;

/**
 * Class Luda
 * @package Nikiforov\Models\Cars
 */
class Luda extends BaseCar
{
    /**
     * @inheritdoc
     */
    public function getRiskPercent()
    {
        // ломается в 3 раза чаще
        return parent::getRiskPercent() * 3;
    }
}