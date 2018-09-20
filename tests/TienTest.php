<?php
/**
 * Created by PhpStorm.
 * User: arneunruh
 * Date: 20.09.18
 * Time: 07:45
 */

namespace Tien\Tests;

use PHPUnit\Framework\TestCase;
use Tien\Controller\TienController as Tien;


class TienTest extends Testcase{

  /**
   * @dataProvider integerProvider
   */
  public function testPreparePrintInteger($id){
    $this->assertTrue(is_int($id));
  }

  public function integerProvider(){
    return [
      //random integer
      [rand(1,100)],
    ];
  }

  /**
   * @dataProvider arrayProvider
   */
  public function testPreparePrintArray($array){
    $this->assertTrue(is_array($array));

  }

  public function arrayProvider(){

    $seeding = ['eins', 'zwei'];

    return [
      [$seeding]
    ];
  }

  /**
   * @depends testPreparePrintInteger
   * @depends testPreparePrintArray
   */
  public function testPreparePrint(){

    $tien = new Tien();
    $id = 5;
    $data = $tien->pereparePrintBuild($id);

    //fwrite(STDERR, print_r($data, TRUE));

    //$this->assertFalse($data);
    $this->assertTrue(is_object($data));

  }



}