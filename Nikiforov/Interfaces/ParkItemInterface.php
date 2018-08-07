<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/6/18
 * Time: 7:13 PM
 */

namespace Nikiforov\Interfaces;

/**
 * Interface ParkItemInterface
 * @package classes
 */
interface ParkItemInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     */
    public function setId($id);
}