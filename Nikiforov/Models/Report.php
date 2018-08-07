<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/7/18
 * Time: 2:14 AM
 */

namespace Nikiforov\Models;

/**
 * Class Report
 * @package Nikiforov\Models
 */
class Report
{
    /**
     * Таксопарк
     * @var Park
     */
    private $park;

    /**
     * Report constructor.
     * @param Park $park
     */
    public function __construct(Park $park)
    {
        $this->park = $park;
    }

    /**
     * Вывод статистики
     */
    public  function printStats()
    {
        echo "\n*** Cars ***\n\n";
        echo "ID\tBrand\tBroken\tFuel\tKm\n";
        echo str_repeat('-', 40), PHP_EOL;

        foreach ($this->park->getCars() as $carId => $car) {
            $row = [
                $carId,
                $car->getBrand(),
                $car->getMalfunctionCount(),
                $car->getFuelConsumed(),
                $car->getKm(),
            ];

            $this->echoRow($row);
        }

        echo "\n*** Drivers ***\n\n";
        echo "ID\tType\tOrders\n";
        echo str_repeat('-', 40), PHP_EOL;

        foreach ($this->park->getDrivers() as $driverId => $driver) {
            $row = [
                $driverId,
                $driver->getType(),
                $driver->getOrderCount()
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