<?php
//define('ROOT', $_SERVER['DOCUMENT_ROOT']);
class db{

	public $db_server;
	public $db_user;
	public $db_password;
	public $db_base_name;
	public $db_con;

	function __construct(){
		$string = file_get_contents(ROOT."/admin/config.json");
		$json_a = json_decode($string, true);
		$this->db_server = $json_a['db_server'];
		$this->db_user = $json_a['db_user'];
		$this->db_password = $json_a['db_password'];
		$this->db_base_name = $json_a['db_base_name'];

		$this->dbcon = new mysqli($this->db_server, $this->db_user, $this->db_password, $this->db_base_name);
	/* проверка соединения */
		if ($this->dbcon->connect_errno) {
		    printf("Соединение не удалось: %s\n", $this->dbcon->connect_error);
		    exit();
		}
	}
	public function select($field, $table, $where=NULL){
		// $new_result=NULL;
		if ($where!=NULL){
			$query = "SELECT $field FROM `$table` WHERE ".$where;
		}else{
			$query = "SELECT $field FROM `$table`";
		}

		//echo $query;
		if ($result = $this->dbcon->query($query)) {

	    /* извлечение ассоциативного массива */
			while ($row = $result->fetch_assoc()) {
				$new_result[]=$row;
			}
	    /* удаление выборки */
	    $result->free();
	    return $new_result;
		}

	}
	public function con_close(){
		$this->dbcon->close();
		/* закрытие соединения */
	}
	public function create($query){
		if (!$this->dbcon->query($query)) {
			echo "ERROR: ".$this->dbcon->connect_error;
		}
	}
	public function insert($tabel, $fields, $fields_value){
		$q= "INSERT INTO `".$tabel."` (".$fields.") VALUES ('".$fields_value."');";
		// echo $q;
		if (!$this->dbcon->query($q)){
			echo "ERROR: ".$this->dbcon->connect_error;
		}
	}
	private function sqlConfig(){

	}
}
