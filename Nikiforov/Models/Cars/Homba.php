<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/6/18
 * Time: 7:54 PM
 */

namespace Nikiforov\Models\Cars;

/**
 * Class Homba
 * @package Nikiforov\Models\Cars
 */
class Homba extends BaseCar
{
    /**
     * @inheritdoc
     */
    public function getLitersPerHundredKilometers()
    {
        // на 30% экономичнее
        return parent::getLitersPerHundredKilometers() * 0.7;
    }
}