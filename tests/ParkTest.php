<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/7/18
 * Time: 1:24 PM
 */

use PHPUnit\Framework\TestCase;
use Nikiforov\Models\Park;
use Nikiforov\Models\Driver;
use Nikiforov\Models\Cars\BaseCar;

class ParkTest extends TestCase
{
    /**
     * @var Park
     */
    protected $park;

    public function setUp()
    {
        $this->park = new Park(10);
    }

    public function testPlaces()
    {
        $this->assertEquals(10, $this->park->getPlaces());
        $this->park->addPlace();
        $this->assertEquals(11, $this->park->getPlaces());
        $this->park->removePlace();
        $this->assertEquals(10, $this->park->getPlaces());
    }

    public function testCar()
    {
        $car = new BaseCar(5000);
        $this->park->addCar($car);

        $this->assertNotEmpty($this->park->getCars());
        $this->assertEquals(1, $car->getId());
        $this->park->removeCar(1);
        $this->assertEmpty($this->park->getCars());
    }


    public function testDriver()
    {
        $car = new BaseCar(5000);
        $driver = new Driver('default');
        $driver->setCar($car);
        $this->park->addDriver($driver);

        $this->assertNotEmpty($this->park->getDrivers());
        $this->assertEquals(1, $driver->getId());
        $this->park->removeDriver(1);
        $this->assertEmpty($this->park->getDrivers());
    }

    public function testCarForRent()
    {
        $car = new BaseCar(5000);
        $this->park->addCar($car);

        $this->assertSame($car, $this->park->getCarForRent());
        $driver = new Driver('default');
        $driver->setCar($car);
        $this->assertNull($this->park->getCarForRent());
    }

    public function testAssignDriversToCars()
    {
        $car = new BaseCar(5000);
        $driver = new Driver('default');
        $this->park->addCar($car);
        $this->park->addDriver($driver);
        $this->park->assignDriversToCars();

        $this->assertSame($car, $driver->getCar());
        $this->assertSame($driver, $car->getDriver());
    }
}