<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/6/18
 * Time: 6:40 PM
 */

namespace Nikiforov\Models\Cars;

use Nikiforov\Models\Driver;
use Nikiforov\Interfaces\ParkItemInterface;
use Nikiforov\Interfaces\CarInterface;

/**
 * Class Car
 * @package Nikiforov\Models
 */
class BaseCar implements ParkItemInterface, CarInterface
{
    /**
     * Пробег, км
     * @var int
     */
    private $km;

    /**
     * Водитель
     * @var Driver
     */
    private $driver;

    /**
     * Уникальный идентификатор автомобиля в парке
     * @var int
     */
    private $id;

    /**
     * Ожидаемое время окончания ремонта, unix timestamp
     * @var int
     */
    private $inRepairUntilTime = null;

    /**
     * Счетчик потраченного топлива
     * @var float
     */
    private $fuelConsumed = 0;

    /**
     * Car constructor.
     * @param $km
     */
    public function __construct($km)
    {
        $this->km = $km;
    }

    /**
     * Возвращает id
     * @return int
     */
    public function getId()
    {
        return  $this->id;
    }

    /**
     * Устанавливает id
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Возвращает водителя
     * @return Driver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Устанавливает водителя
     * @param Driver $driver
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    /**
     * Возвращает пробег
     * @return int
     */
    public function getKm()
    {
        return $this->km;
    }

    /**
     * Расход топлива на 100 км пути, литров
     * @return float|int
     */
    public function getLitersPerHundredKilometers()
    {
        return 10;
    }

    /**
     * Возвращает количество литров потраченного топлива
     * @return float
     */
    public function getFuelConsumed()
    {
        return $this->fuelConsumed;
    }

    /**
     * Проверяет сломана ли машина
     * @param int $date
     * @return bool
     */
    public function getIsBroken($date)
    {
        // машина в ремонте?
        if ($this->inRepairUntilTime) {
            if ($date >= $this->inRepairUntilTime) {
                // машина готова, забираем из ремонта
                $this->inRepairUntilTime = null;
                return false;
            }
            return  true;
        }

        // машина вдруг сломалась?
        if ($this->randomMalfunction()) {
            // ставим в ремонт на 3 дня
            $this->inRepairUntilTime = strtotime('+ 3 days', $date);
            return true;
        }
        return false;
    }

    /**
     * Моделирует поездку на дистанцию $km
     * @param int $km
     */
    public function ride($km)
    {
        $this->fuelConsumed += $km / 100 * $this->getLitersPerHundredKilometers() * $this->driver->getFuelSavingFactor();
        $this->km += $km;
    }

    /**
     * Вероятность поломки машины в течение смены, %
     * @return float
     */
    public function getRiskPercent()
    {
        return 0.5 + $this->km / 1000;
    }

    /**
     * Случайная неисправность
     * @return bool
     */
    private function randomMalfunction()
    {
        $max = floor($this->getRiskPercent() / 1000);
        $rand = mt_rand(0, 1000);

        return $rand >= 0 && $rand <= $max;
    }
}