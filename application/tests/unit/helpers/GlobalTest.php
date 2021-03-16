<?php namespace helpers;

class GlobalTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMakeLabel()
    {
        define('BASEPATH', true);

        include 'application/helpers/global_helper.php';
        $data = 'toni-haryanto';
        $expected = 'Toni Haryanto';

        $this->assertEquals($expected, make_label($data));
    }
}