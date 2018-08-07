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

/**
 * Class Driver
 * @package Nikiforov\Models
 */
class Driver implements ParkItemInterface
{
    /**
     * Обычный водитель
     */
    const TYPE_DEFAULT = 'default';

    /**
     * Профессионал
     */
    const TYPE_PRO = 'pro';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * Счетчик выполненных заказов
     * @var int
     */
    private $orderCount = 0;

    /**
     * Автомобиль
     * @var CarInterface
     */
    private $car;

    /**
     * Таксопарк
     * @var Park
     */
    private $park;

    /**
     * Driver constructor.
     * @param string $type
     * @throws \Exception
     */
    public function __construct($type)
    {
        $types = [
            self::TYPE_DEFAULT,
            self::TYPE_PRO
        ];

        if (!in_array($type, $types)) {
            throw new \Exception("Unknown driver type {$type}\n");
        }

        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Коэффициент экономии топлива, зависит от типа водителя
     * @return float
     */
    public function getFuelSavingFactor()
    {
        return $this->type === self::TYPE_PRO ? 0.8 : 1;
    }

    /**
     * @return CarInterface
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * Принять машину
     * @param CarInterface $car
     */
    public function setCar(CarInterface $car)
    {
        $car->setDriver($this);
        $this->car = $car;
    }

    /**
     * Вернуть машину в парк
     */
    public function releaseCar()
    {
        $this->car->setDriver(null);
        $this->car = null;
    }

    /**
     * Выполнить заказ
     * @param int $km дистанция
     * @throws \Exception
     */
    public function completeOrder($km)
    {
        if (!$this->car) {
            return;
        }

        // заводим машину
        if ($this->car->randomMalfunction($this->park->getDate())) {
            // не заводится, пробуем взять другую
            $this->releaseCar();
            $newCar = $this->park->getCarForRent();
            if ($newCar) {
                $this->setCar($newCar);
                $this->completeOrder($km);
            }

            return;
        }

        // едем
        $this->car->ride($km);
        ++$this->orderCount;
    }

    /**
     * Имитирует рабочий день водителя
     * @throws \Exception
     */
    public function completeOrders()
    {
        // профи могут выполнять на 30% больше заказов
        $ordersCount = $this->type == self::TYPE_PRO ? 13 : 10;

        for ($i = 0; $i < $ordersCount; ++$i) {
            $km = $this->park->getOrderKm();
            $this->completeOrder($km);
        }
    }

    /**
     * @param Park $park
     */
    public function setPark($park)
    {
        $this->park = $park;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getOrderCount()
    {
        return $this->orderCount;
    }
}