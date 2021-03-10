<?php
class DBconnect {
	private $user="root";
	private $pass="";
	private $dbname="phone_pttk";
	private $server="localhost:3306";
	private $conn;
	public static $DB;
	public function __construct(){
		$this->connect();
	}
	public function connect(){
		$this->conn = new mysqli($this->server,$this->user,$this->pass,$this->dbname);
		$this->conn->set_charset("utf8");
		if($this->conn->connect_error) throw new Exception('Lỗi kết nối database');
	}
	public static function getInstance(){
		if(!isset(self::$DB)) self::$DB = new DBconnect();
		return self::$DB;
	}
	public function execSQL($sql){
		if($result = $this->conn->query($sql)){
		if($result->field_count>1 && $result->num_rows>0){
			$rows = $result->fetch_all(MYSQLI_BOTH);
		}
		else if($result->field_count==1 && $result->num_rows>0){
			while($row = $result->fetch_array(MYSQLI_BOTH)){
			$rows[] = $row;
			}
		}
		else $rows=0;
		return $rows;
		}
		else return $this->conn->error;
	}
	public function execMultiQuery($sql){
	    if($this->conn->multi_query($sql)===true) return true;
	    else return $this->conn->error;
    }
	public function execUpdate($sql){
		if($this->conn->query($sql)===true){
			return true;
		}
		else return $this->conn->error;
	}
	public function closeConn(){
		$this->conn->close();
	}
	public function __destruct(){
		$this->conn->close();
	}
}
?>