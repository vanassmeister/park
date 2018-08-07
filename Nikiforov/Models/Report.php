<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/7/18
 * Time: 2:14 AM
 */

namespace Nikiforov\Models;

use Nikiforov\Interfaces\CarInterface;


class Report
{
    /**
     * Таксопарк
     * @var Park
     */
    private $park;

    /**
     * Копия состояния автомобилей на начало рабочего дня
     * @var CarInterface[]
     */
    private $cars;

    /**
     * Число выполенных заказов у водителя на начало рабочего дня
     * @var int[]
     */
    private $drivers;

    /**
     * @param Park $park
     */
    public function setPark($park)
    {
        $this->park = $park;
    }

    /**
     * Сохраняет показатели до начала рабочего дня
     */
    public function saveBefore()
    {
        foreach ($this->park->getCars() as $carId => $car) {
            $this->cars[$carId] = clone $car;
        }

        foreach ($this->park->getDrivers() as $driverId => $driver) {
            $this->drivers[$driverId] = $driver->getOrderCount();
        }
    }

    /**
     * Вывод ежедневной статистики
     */
    public  function printDailyStats()
    {
        $date = $this->park->getDate();
        echo "Stats for $date\n";

        echo "Cars\n";
        foreach ($this->park->getCars() as $carId => $car) {
            /** @var CarInterface $oldCar */
            $oldCar = $this->cars[$carId];
            $row = [
                $carId,
                get_class($car),
                $car->getIsBroken($date),
                $car->getFuelConsumed() - $oldCar->getFuelConsumed(),
                $car->getKm() - $oldCar->getKm(),
            ];

            $this->echoRow($row);
        }

        echo "Drivers\n";
        foreach ($this->park->getDrivers() as $driverId => $driver) {
            $row = [
                $driverId,
                $driver->getType(),
                $driver->getOrderCount() - $this->drivers[$driverId]
            ];

            $this->echoRow($row);
        }
    }

    /**
     * Вывод массива в строку с табуляцией
     * @param $row
     */
    private function echoRow($row)
    {
        echo implode("\t", $row), PHP_EOL;
    }
}