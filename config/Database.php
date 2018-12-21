<?php
	class Database{
		//db parameters
		private $host = 'localhost';
		private $db_name = 'blog';
		private $username = 'sanjay';
		private $password = 'test1234';
		private $conn;

		//db connect
		public function connect(){
			$this->conn = null;

			try{
				$conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
    			echo "Connection failed: " . $e->getMessage();
    		}
    		return $conn;
		}
	}
?>