<?php
header("Access-Control-Allow-Origin: *");

require_once 'db.class.php';

$db = new DB();
$db->connect();
$query = 'SELECT * FROM `products`';
$result = $db->select($query);

$return = array();
$return['error'] = false;

if (count($result)) {
  $return['data'] = (array)$result;
} else {
  $return['error'] = true;
  $return['data'] = [];
}
echo json_encode($return);
exit();
