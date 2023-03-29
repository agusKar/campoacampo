<?php
class Database
{
  private $db;

  private $hostName = "localhost";
  private $dbName = "campoacampo";
  private $userName = "root";
  private $passWord = "";

  function __construct()
  {
    try {
      $this->db = new PDO(
        "mysql:dbname={$this->dbName};host={$this->hostName}",
        $this->userName,
        $this->passWord
      );
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->db->exec("set names utf8");
    } catch (PDOException $e) {
      return 'Ocurrio un error con la DB';
    }
  }

  public function read($tbl, $clmns, $where = '')
  {
    try {
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $this->db->query("SELECT {$clmns} FROM {$tbl}");
      if ($where != '') {
        $stmt = $this->db->query("SELECT {$clmns}
          FROM {$tbl}
          WHERE {$where}");
      }
      $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
      return $rows;
    } catch (PDOException $e) {
      return 'Ocurrio un error con la consulta read';
    }
  }

  public function write($tbl, $nombre, $precio)
  {
    try {
      $data = [
        'nombre' => $nombre,
        'precio' => $precio
      ];
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO {$tbl} (nombre, precio) VALUES (:nombre, :precio)";
      $stmt = $this->db->prepare($sql);
      $num = $stmt->execute($data);

      return $num;
    } catch (PDOException $e) {
      return 'Ocurrio un error con la consulta insert';
    }
  }

  public function delete($tbl, $id)
  {
    try {
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "DELETE FROM {$tbl} WHERE id = $id";
      return $this->db->exec($sql);
    } catch (PDOException $e) {
      return 'Ocurrio un error con la consulta insert';
    }
  }
}
