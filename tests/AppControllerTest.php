
<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use App\Service\CommissionCalculation;
use App\Controller\AppController;
use App\Service\Helper;


class AppControllerTest extends TestCase
{
    public function testindex()
    {
       /* $expected = [
            [0] => stdClass
                (
                    ['bin'] => 45717360
                    ['amount'] => 100.00
                    ['currency'] => EUR
                )

            [1] => stdClass Object
                (
                    ['bin'] => 516793
                    ['amount'] => 50.00
                    ['currency'] => USD
                )

            [2] => stdClass Object
                (
                    ['bin'] => 45417360
                    ['amount'] => 10000.00
                    ['currency'] => JPY
                )

            [3] => stdClass Object
                (
                    ['bin'] => 41417360
                    ['amount'] => 130.00
                    ['currency'] => USD
                )

            [4] => stdClass Object
                (
                    ['bin'] => 4745030
                    ['amount'] => 2000.00
                    ['currency'] => GBP
                )
        ];*/
       
        $mock = $this->createMock(AppController::class);
        $this->assertInstanceOf(AppController::class, $mock);

        $mock = $this->createMock(Helper::class);
        $mock->method('getArrayOfObject')
        ->willReturn([]);
        $mock->assertArrayHasKey("bin");
        //$this->assertSame(Helper::getArrayOfObject(), $expected);

        $mock = $this->createMock(CommissionCalculation::class);
        $this->assertInstanceOf(CommissionCalculation::class, $mock);
        
        /*$service = Mockery::mock('rows_from_file');
        $service->shouldReceive('readTemp')
            ->times(3)
            ->andReturn(10, 12, 14);*/
    }
    
    
    /*
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertSame(0, count($stack));

        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack)-1]);
        $this->assertSame(1, count($stack));

        $this->assertSame('foo', array_pop($stack));
        $this->assertSame(0, count($stack));
    }
    */
}
