<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/6/18
 * Time: 7:57 PM
 */

namespace Nikiforov\Interfaces;

use Nikiforov\Models\Driver;


interface CarInterface
{
    /**
     * Возвращает пробег, км
     * @return int
     */
    public function getKm();

    /**
     * Возвращает расход топлива, литров на 100 км
     * @return float
     */
    public function getFuelConsumed();

    /**
     * Машина сломана по состоянию на дату $date?
     * @param int $date unix timestamp
     * @return bool
     */
    public function getIsBroken($date);

    /**
     * Возвращает водителя
     * @return Driver
     */
    public function getDriver();

    /**
     * Назначает водителя
     * @param Driver $driver
     * @return mixed
     */
    public function setDriver($driver);

    /**
     * Имитирует поездку на $km километров
     * @param $km
     * @return mixed
     */
    public function ride($km);

    /**
     * Возвращает бренд автомобиля
     * @return string
     */
    public function getBrand();

    /**
     * Случайная неисправность
     * @param int $date, дата проверки, unix timestamp
     * @return bool
     */
    public function randomMalfunction($date);

    /**
     * Число поломок
     * @return int
     */
    public function getMalfunctionCount();
}