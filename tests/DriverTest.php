<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/7/18
 * Time: 1:24 PM
 */

use PHPUnit\Framework\TestCase;
use Nikiforov\Models\Driver;
use Nikiforov\Models\Park;
use Nikiforov\Models\Cars\Hendai;

class DriverTest extends TestCase
{
    /**
     * @var Driver
     */
    protected $driver;

    public function setUp()
    {
        $this->driver = new Driver('pro');
        $car = new Hendai(5000);
        $this->driver->setCar($car);

        $park = new Park(10);
        $park->addCar($car);
        $park->addDriver($this->driver);
    }

    public function testId()
    {
        $this->assertEquals(1, $this->driver->getId());
    }

    public function testFuelSavingFactor()
    {
        $this->assertEquals(0.8, $this->driver->getFuelSavingFactor());
    }

    public function testOrderCapability()
    {
        $this->assertEquals(13, $this->driver->getOrderCapability());
    }

    public function testCompleteOrder()
    {
        $this->driver->completeOrder(7);
        if ($this->driver->getCar()) {
            $this->assertEquals(1, $this->driver->getOrderCount());
        } else {
            $park = $this->driver->getPark();
            $cars = $park->getCars();
            $car = array_pop($cars);
            $this->assertTrue($car->getIsBroken($park->getDate()));
        }
    }

    public function testReleaseCar()
    {
        $car = $this->driver->getCar();
        $this->driver->releaseCar();
        $this->assertNull($this->driver->getCar());
        $this->assertNull($car->getDriver());
    }
}