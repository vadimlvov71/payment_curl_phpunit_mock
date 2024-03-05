
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
        require_once  './config/env.php';

        $file_with_data = "./". FILE_WITH_DATA;
        $file_to_commission_result = "./".FILE_TO_COMMISSION;
        echo "file_with_data".$file_with_data . PHP_EOL;
        $expected = [];
        $expected[] = null;
            $obj = new stdClass();
                $obj->bin = 45717360;
                $obj->amount = 100.00;
                $obj->currency = "EUR";
        $expected[] = $obj;
            $obj = new stdClass();
                $obj->bin = 516793;
                $obj->amount = 50.00;
                $obj->currency = "USD";
        $expected[] = $obj;
            $obj = new stdClass();
                $obj->bin = 45417360;
                $obj->amount = 10000.00;
                $obj->currency = "JPY";
        $expected[] = $obj; 
            $obj = new stdClass();
                $obj->bin = 41417360;
                $obj->amount = 130.00;
                $obj->currency = "USD";
        $expected[] = $obj;         
            $obj = new stdClass();
                $obj->bin = 4745030;
                $obj->amount = 2000.00;
                $obj->currency = "GBP";
        $expected[] = $obj;
       
        $mock = $this->createMock(AppController::class);
        $this->assertInstanceOf(AppController::class, $mock);

       

        $mock = $this->createMock(CommissionCalculation::class);
        $this->assertInstanceOf(CommissionCalculation::class, $mock);
        
        $init_data = Helper::getArrayOfObject($file_with_data);
        echo "<pre>";
        print_r($init_data);
        echo "</pre>";
        $this->assertIsArray($init_data);
        $this->assertArrayHasKey('bin',  $init_data[0]->property);
        $commission = "blabla";
       // Helper::setDataToFile($commission, $this->_file_to_commission_result);
      //
       //$mock = $this->createMock(Helper::class);
      // $mock->method('getArrayOfObject')
       //->willReturn([]);
       //->will([]);
       //$mock->assertArrayHasKey("bin");
       //$this->assertSame(Helper::getArrayOfObject($file_with_data), $expected);
       //$mock = $this->createMock(Helper::class);
       //$mock->method('getArrayOfObject')
       //$mock->shouldReceive('getArrayOfObject')->once()->with(new HasKeysMatcher(array('bin','file_input_data'),5));
       $result = Helper::setDataToFile($commission, $file_to_commission_result);
       echo "<pre>";
       print_r($result);
       echo "</pre>";
       $this->assertArrayHasKey('success',  $result);
       
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
