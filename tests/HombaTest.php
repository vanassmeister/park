<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/7/18
 * Time: 1:47 PM
 */

use PHPUnit\Framework\TestCase;
use Nikiforov\Models\Cars\Homba;

class HombaTest extends TestCase
{
    /**
     * @var Homba
     */
    protected $homba;

    public function setUp()
    {
        $this->homba = new Homba(5000);
    }

    public function testLitersPerHundredKilometers()
    {
        $this->assertEquals(7, $this->homba->getLitersPerHundredKilometers());
    }
}