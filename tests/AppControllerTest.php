
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
        $test_bin = [0 => "45717360"];
        $file_with_data = "./". FILE_WITH_DATA;
        $file_to_commission_result = "./".FILE_TO_COMMISSION;
        
        #1
        $mock = $this->createMock(AppController::class);
        $this->assertInstanceOf(AppController::class, $mock);

        #2
        $mock = $this->createMock(CommissionCalculation::class);
        $this->assertInstanceOf(CommissionCalculation::class, $mock);

        $init_data = Helper::getArrayOfObject($file_with_data);

        #3
        $this->assertIsArray($init_data);

        #4
        $this->assertArrayHasKey('bin',  (array)$init_data[0]);
        #5
        
        $this->assertSame((array)$init_data[0]->bin, $test_bin);
        
        #6
        $commission = "test test";
        $result = Helper::setDataToFile($commission, $file_to_commission_result);
        $this->assertArrayHasKey('success',  $result);
    }
}
