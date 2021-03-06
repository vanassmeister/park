<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/6/18
 * Time: 6:40 PM
 */

namespace Nikiforov\Models;

use Nikiforov\Interfaces\CarInterface;
use Nikiforov\Interfaces\ParkItemInterface;
use Nikiforov\Models\Cars\BaseCar;

/**
 * Class Park
 * @package classes
 */
class Park
{
    /**
     * Число машиномест в парке
     * @var int
     */
    private $places;

    /**
     * Машины
     * @var CarInterface[]
     */
    private $cars = [];

    /**
     * Счетчик для идентификаторов машин
     * @var int
     */
    private $carsCounter = 0;

    /**
     * Водители
     * @var Driver[]
     */
    private $drivers = [];

    /**
     * Счетчик для идентификаторов водителей
     * @var int
     */
    private $driversCounter = 0;

    /**
     * Дата текущей смены
     * @var int
     */
    private $date;

    /**
     * Park constructor.
     * @param int $places
     */
    public function __construct($places)
    {
        $this->places = $places;
        $this->date = time();
    }

    /**
     * Добавить авто
     * @param CarInterface $car
     * @throws \Exception
     */
    public function addCar(CarInterface $car)
    {
        if (count($this->cars) == $this->places) {
            throw new \Exception("No place to add Car");
        }

        $id = ++$this->carsCounter;

        /** @var ParkItemInterface $car */
        $car->setId($id);
        $this->cars[$id] = $car;
    }

    /**
     * Добавить водителя
     * @param Driver $driver
     */
    public function addDriver(Driver $driver)
    {
        $id = ++$this->driversCounter;
        $driver->setId($id);
        $this->drivers[$id] = $driver;
        $driver->setPark($this);
    }

    /**
     * Удалить машину
     * @param int $carId
     */
    public function removeCar($carId)
    {
        /** @var BaseCar $car */
        $car = $this->cars[$carId];
        $car->setDriver(null);
        unset($this->cars[$carId]);
    }

    /**
     * Удалить водителя
     * @param int $driverId
     */
    public function removeDriver($driverId)
    {
        /** @var Driver $driver */
        $driver = $this->drivers[$driverId];
        $driver->releaseCar();
        $driver->setPark(null);
        unset($this->drivers[$driverId]);
    }

    /**
     * Добавить машиноместо
     */
    public function addPlace()
    {
        ++$this->places;
    }

    /**
     * Удалить машиноместо
     */
    public function removePlace()
    {
        if ($this->places > 0) {
            --$this->places;
        }
    }

    /**
     * Выдать свободную исправную машину в прокат
     * @return CarInterface
     */
    public function getCarForRent()
    {
        foreach ($this->cars as $car) {
            if (!$car->getDriver() && !$car->getIsBroken($this->date)) {
                return $car;
            }
        }

        return null;
    }

    /**
     * Назначить машины водителям
     */
    public function assignDriversToCars()
    {
        foreach ($this->drivers as $driver) {
            if ($driver->getCar()) {
                continue;
            }

            $car = $this->getCarForRent();
            if (!$car) {
                // машин нет
                break;
            }

            $driver->setCar($car);
        }
    }

    /**
     * Выдать заказ водителю
     * @return int дистанция, км
     */
    public function getOrderKm()
    {
        return mt_rand(5, 10);
    }

    /**
     * Имитирует рабочий день таксопарка
     * @param int $date
     */
    public function work($date)
    {
        $this->date = $date;
        $this->assignDriversToCars();
        foreach ($this->drivers as $driver) {
            $driver->completeOrders();
        }

    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return CarInterface[]
     */
    public function getCars()
    {
        return $this->cars;
    }

    /**
     * @return Driver[]
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * @return int
     */
    public function getPlaces()
    {
        return $this->places;
    }
}