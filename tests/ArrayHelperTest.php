<?php

namespace TaoTeCode\Helper\Tests;

use PHPUnit\Framework\TestCase;
use TaoTeCode\Helper\ArrayHelper;

class ArrayHelperTest extends TestCase
{

  public function test_arrayToTree()
  {
    $data = [
      ['id' => 1, 'parent_id' => 0],
      ['id' => 2, 'parent_id' => 1],
      ['id' => 3, 'parent_id' => 1],
      ['id' => 4, 'parent_id' => 2],
      ['id' => 5, 'parent_id' => 2]
    ];
    $tree = ArrayHelper::arrayToTree($data, 'id', 'parent_id', 'children');
    //检查结果
    $this->assertIsArray($tree);
    //输出结果
    print_r($tree);
  }

  public function test_toHashmap()
  {
    $data = [
      ['id' => 1, 'name' => 'Alice', 'age' => 25],
      ['id' => 2, 'name' => 'Bob', 'age' => 30],
      ['id' => 3, 'name' => 'Charlie', 'age' => 35],
    ];

    $result = ArrayHelper::toHashmap($data, 'id');
    //检查结果
    $this->assertIsArray($result);
    //输出结果
    print_r($result);
  }

}
