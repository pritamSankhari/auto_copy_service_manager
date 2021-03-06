<?php

	/**
	* @author Pritam Sankhari
	*/

	class ScriptLog{
		
		var $database;
		var $script_id;
		var $table;
		function __construct($db,$id){
			
			$this->database = $db;
			$this->script_id = $id;
			$this->table = "script_log_".$this->script_id;
		}

		function uniqueID(){
			
			while(true){
				
				$id = uniqid(uniqid());

				$sql = "SELECT * FROM $this->table WHERE id = '".$id."'";

	            if(!$result = $this->database->query($sql))
	            	return $id;
	            

	            if($result->num_rows < 1)
	                return $id ;
            }    
		}

		function add($filename){

			date_default_timezone_set("Asia/Kolkata");
			$current_time = date("H:i:s");
			$current_date = date("Y-m-d");

			$sql = "INSERT INTO $this->table(id,copied_file,on_date,at_time) VALUES('".$this->uniqueID()."','".$filename."','".$current_date."','".$current_time."')";

			
			if($this->database->query($sql)) return true;

			return false;
		}

		function deleteById($id){

			$sql = "DELETE FROM $this->table WHERE id = '$id'";

			
			if($this->database->query($sql)) return true;

			return false;
		}

		function deleteByFilename($filename){

			$sql = "DELETE FROM $this->table WHERE copied_file = '$filename'";

			
			if($this->database->query($sql)) return true;

			return false;
		}

		function getAll(){

			
			$sql = "SELECT * FROM $this->table ORDER BY CONCAT(on_date,' ',at_time)";

			
			if($result = $this->database->query($sql)){

				if($result->num_rows > 0){

					$data = array();

					while($row = $result->fetch_assoc()){

						$data[] = $row;
					}
					return $data;
				}

			}

			return false;
		}

		function getDates(){

			$sql = "SELECT DISTINCT on_date FROM $this->table ORDER BY on_date DESC";


			if($result = $this->database->query($sql)){

				if($result->num_rows > 0){

					$data = array();

					while($row = $result->fetch_assoc()){

						$data[] = $row;
					}
					return $data;
				}

			}

			return false;


		}

		function getFilenameByID($id){
			
			$sql = "SELECT * FROM $this->table WHERE id = '$id'";


			if($result = $this->database->query($sql)){

				if($result->num_rows > 0){
					$row = $result->fetch_assoc();
					return $row['copied_file'];
				}

			}

			return false;			
		}

		function getFilenamesByDate($date){

			$sql = "SELECT * FROM $this->table WHERE on_date = '$date'";


			if($result = $this->database->query($sql)){

				if($result->num_rows > 0){

					$data = array();

					while($row = $result->fetch_assoc()){

						$data[] = $row['copied_file'];
					}
					return $data;
				}

			}

			return false;
		}
	}
?>	