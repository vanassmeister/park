<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 8/7/18
 * Time: 1:47 PM
 */

use PHPUnit\Framework\TestCase;
use Nikiforov\Models\Cars\Luda;

class LudaTest extends TestCase
{
    /**
     * @var Luda
     */
    protected $luda;

    public function setUp()
    {
        $this->luda = new Luda(5000);
    }

    public function testRiskPercent()
    {
        $riskExpected = (0.5 + $this->luda->getKm() / 1000) * 3;
        $this->assertEquals($riskExpected, $this->luda->getRiskPercent());
    }
}