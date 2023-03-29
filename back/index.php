<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
header("Content-Type: application/json; charset=UTF-8");

include "classes/Product.php";

$producto = new Product();

switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
    $result = $producto->getAllProducts();
    if ($result > 0) {
      http_response_code(200);
      echo json_encode($result);
    } else {
      http_response_code(200);
      echo json_encode("No se pudieron leer los datos.");
    }
    break;

  case 'POST':
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->nombre) && !empty($data->precio)) {
      $producto->nombre = $data->nombre;
      $producto->precio = $data->precio;
      $result = $producto->createProduct();
      if ($result > 0) {
        http_response_code(200);
        echo json_encode("Satisfactoriamente creado.");
      } else {
        http_response_code(200);
        echo json_encode("No se creo correctamente.");
      }
    } else {
      http_response_code(200);
      echo json_encode("Faltan datos.");
    }
    break;

  case 'DELETE':
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id)) {
      $producto->id = $data->id;
      if ($producto->deleteProduct()) {
        http_response_code(200);
        echo json_encode("Satisfactoriamente eliminado.");
      } else {
        http_response_code(200);
        echo json_encode("No se elimino correctamente.");
      }
    } else {
      http_response_code(200);
      echo json_encode("Faltan datos.");
    }
    break;
  default:
}
