<?php
class MyServices {
	private $host;
	private $dbname;
	private $user;
	private $pass;
	private $method = 'json';
	private $limit = 5;
	private $order = 'name';
	private $mysql;
	// constructor
	public function __construct() {
		$this->host = 'localhost';
		$this->dbname = 'scharfs1';
		$this->user = 'root';
		$this->pass = 'root';
		// create db link
		try {
			$this->mysql = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
			// set the PDO error mode to exception
			$this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
    	echo "Error: " . $e->getMessage();
    }
	}
	// set method
	public function setMethod($type) {
		if ($type == 'xml') {
			$this->method = 'xml';
		} else {
			$this->method = 'json';
		}
	}
	// set limit
	public function setLimit($limit) {
		if ($limit > 0 && $limit < 10) {
			$this->limit = $limit;
		}
	}
	// set order
	public function setOrder($s) {
		$this->order = $s;  
	}
	// Add user
	public function addUsers() {
		echo 'done';
	}
	// return list of videos
	public function getUsers() {
		global $mysql;
		// define order field
		if ($this->order == 'email') {
			$order = 'email';
		} else {
			$order = 'name';
		}
		// obtain data from database
		$aData = $this->mysql->prepare("SELECT id, name, email FROM stv_users ORDER BY " . $order . " DESC LIMIT " . $this->limit . "");
		$aData->execute();
		$total = $aData->rowCount();
		$result = $aData->fetchAll();
		// output in necessary format
		switch ($this->method) {
			case 'xml': // gen XML result
				$sCode = '';
				if ($total > 0) {
						foreach ($result as $i => $aRecords) {
								$sCode .= '<user>
														<id>' . $aRecords['id'] . '</id>
														<name>' . $aRecords['name'] . '</name>
														<email>' . $aRecords['email'] . '</email>
													 </user>';
						}
				}
				header('Content-Type: text/xml; charset=utf-8');
				echo '<?xml version="1.0" encoding="UTF-8"?>
								<users>
									' . $sCode . '
								</users>';
				break;
			case 'json': // gen JSON result
			default:
				// you can uncomment it for Live version
				// header('Content-Type: text/xml; charset=utf-8');
				if ($total > 0) {
					echo json_encode(array('data' => $result));
				} else {
					echo json_encode(array('data' => 'Nothing found'));
				}
				break;
		}
	}
	public function __destruct() {
		$this->mysql = NULL; // closing connection
	}
}