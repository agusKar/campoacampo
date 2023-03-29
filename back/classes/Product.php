<?php
include "Database.php";

class Product
{
  private $nombreTabla = "productos";
  private $conn;

  public $id;
  public $nombre;
  public $precio;
  // Se podria usar para sumar al array final de productos esta clave junto a la "cuenta" para determinar el precio del dolar
  public $precio_dolares;


  function __construct()
  {
    $this->conn = new Database();
  }

  function getAllProducts()
  {
    try {
      $result = $this->conn->read($this->nombreTabla, "*");
      // Aca se podria agregar el precio del dolar a cada iteracion y devolverlo, pero creo que es mejor hacer esa cuenta en el front, ya que es el unico lugar donde por ahora "serviria"
      return $result;
    } catch (\Throwable $th) {
      throw new Exception("Error al leer");
    }
  }

  function createProduct()
  {
    try {
      return $this->conn->write($this->nombreTabla, $this->nombre, $this->precio);
    } catch (\Throwable $th) {
      throw new Exception("Error al crear");
    }
  }

  function deleteProduct()
  {
    try {
      return $this->conn->delete($this->nombreTabla, $this->id);
    } catch (\Throwable $th) {
      throw new Exception("Error al crear");
    }
  }
}
