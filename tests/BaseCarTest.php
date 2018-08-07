<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/7/18
 * Time: 1:47 PM
 */

use PHPUnit\Framework\TestCase;
use Nikiforov\Models\Cars\BaseCar;
use Nikiforov\Models\Driver;

class BaseCarTest extends TestCase
{
    /**
     * @var BaseCar
     */
    protected $baseCar;

    public function setUp()
    {
        $this->baseCar = new BaseCar(5000);
        $driver = new Driver('default');
        $this->baseCar->setDriver($driver);
    }

    public function testId()
    {
        $this->assertNull($this->baseCar->getId());
        $id = 123;
        $this->baseCar->setId(123);
        $this->assertEquals($id, $this->baseCar->getId());
    }

    public function testKm()
    {
        $this->assertEquals($this->baseCar->getKm(), 5000);
    }

    public function testRide()
    {
        $distance = 10;
        $fuelExpected = 1;

        $km = $this->baseCar->getKm();

        $this->baseCar->ride($distance);

        $this->assertEquals($this->baseCar->getKm(), $km + $distance);
        $this->assertEquals($this->baseCar->getFuelConsumed(), $fuelExpected);
    }

    public function testBrand()
    {
        $this->assertEquals($this->baseCar->getBrand(), 'BaseCar');
    }

    public function testRandomMalfunction()
    {
        $date = time();
        $tries = 0;

        while (!$this->baseCar->randomMalfunction($date)) {
            ++$tries;
            $this->assertLessThan(1000, $tries);
            $date = strtotime('+ 1 day', $date);
        }

        $this->assertEquals($this->baseCar->getMalfunctionCount(), 1);
        $this->assertTrue($this->baseCar->getIsBroken($date));

        $date = strtotime('+ 3 days', $date);
        $this->assertFalse($this->baseCar->getIsBroken($date));
    }
}