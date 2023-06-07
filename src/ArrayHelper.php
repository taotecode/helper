<?php

namespace TaoTeCode\Helper;

class ArrayHelper
{

  /**
   * Transforms a flat 2D array into a tree structure according to a specified field
   * @param array $sourceArray The data source
   * @param string|int $nodeIdField The field name of the node ID
   * @param string|int $parentIdField The field name of the parent node ID
   * @param string $childrenField The field name for saving child nodes
   * @param bool $useTreeIndex If true, uses the original array indices in the tree
   * @param bool|null $includeReferences If true, includes node references in the result
   * @return array A tree-structured array
   */
  public static function arrayToTree(
    array $sourceArray,
          $nodeIdField,
          $parentIdField = 'parent_id',
    string $childrenField = 'children',
    bool $useTreeIndex = false,
    bool & $includeReferences = null
  ) :array {
    $includeReferences = array();
    foreach ($sourceArray as $offset => $row) {
      $sourceArray[$offset][$childrenField] = array();
      $includeReferences[$row[$nodeIdField]] = & $sourceArray[$offset];
    }

    $tree = array();
    foreach ($sourceArray as $offset => $row) {
      $parent_id = $row[$parentIdField];
      if ($parent_id) {
        if (!isset($includeReferences[$parent_id])) {
          if ($useTreeIndex) {
            $tree[$offset] = & $sourceArray[$offset];
          }
          else {
            $tree[] = & $sourceArray[$offset];
          }
          continue;
        }
        $parent = & $includeReferences[$parent_id];
        if ($useTreeIndex) {
          $parent[$childrenField][$offset] = & $sourceArray[$offset];
        }
        else {
          $parent[$childrenField][] = & $sourceArray[$offset];
        }
      }
      else {
        if ($useTreeIndex) {
          $tree[$offset] = & $sourceArray[$offset];
        }
        else {
          $tree[] = & $sourceArray[$offset];
        }
      }
    }

    return $tree;
  }

  /**
   * 将数组按照键值转换成数组
   * @param array $arr The array to be converted
   * @param string $key_field The field name of the key
   * @param string|null $value_field The field name of the value
   * @return array
   */
  static function toHashmap(array $arr, string $key_field, string $value_field = null) :array {

    $ret = array ();
    if (empty ( $arr )) {
      return $ret;
    }
    if ($value_field) {
      foreach ( $arr as $row ) {
        if (isset ( $row [$key_field] )) {
          $ret [$row [$key_field]] = $row [$value_field] ?? null;
        }
      }
    } else {
      foreach ( $arr as $row ) {
        $ret [$row [$key_field]] = $row;
      }
    }
    return $ret;
  }

}
