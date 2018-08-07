<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/6/18
 * Time: 6:43 PM
 */

require_once 'vendor/autoload.php';

use Nikiforov\Models\Park;
use Nikiforov\Models\Driver;
use Nikiforov\Models\Report;
use Nikiforov\Models\Cars\Luda;
use Nikiforov\Models\Cars\Homba;
use Nikiforov\Models\Cars\Hendai;

$configFile = 'config.json';
$config = json_decode(file_get_contents($configFile));

try {
    $report = new Report();
    $park = new Park($config->park->places, $report);

    foreach ($config->cars as $carConfig) {
        switch ($carConfig->brand) {
            case 'Luda':
                $car = new Luda($carConfig->km);
                break;
            case 'Homba':
                $car = new Homba($carConfig->km);
                break;
            case 'Hendai':
                $car = new Hendai($carConfig->km);
                break;
            default:
                throw new \Exception("Unknown brand {$carConfig->brand}\n");
        }

        $park->addCar($car);
    }

    foreach ($config->drivers as $driverConfig) {
        $driver = new Driver($driverConfig->type);
        $park->addDriver($driver);
    }

    $date = time();
    // моделируем несколько дней работы
    for ($i = 0; $i < 10; ++$i) {
        $dateFormatted = date('Y-m-d', $date);
        echo "Working day $dateFormatted\n";
        $park->work($date);
        $date = strtotime('+ 1 day', $date);
    }

    $park->getReport()->printStats();

} catch (\Exception $exception) {
    echo $exception->getMessage(), PHP_EOL;
}

