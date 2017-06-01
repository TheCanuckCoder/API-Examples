<?php
namespace Services;
// TODO: Add origin check allowing only your server access your API
// Change user/pass and dbname variables to your database
// change the hash_mac function to a different encryption method
class MyAPI {
	protected $method = '';
	protected $action = '';
	protected $endpoint = '';
	protected $endpointPrefix = '';
	protected $verb = '';
	protected $args = array();
	protected $file = NULL;
	protected $mysql;
	private $host = 'localhost';
	private $dbname = 'scharfs1';
	private $user = 'root';
	private $pass = 'root';
	// constructor
	public function __construct($action, $method) {
		// Sets headers
		header("Access-Control-Allow-Orgin: *");
		header("Access-Control-Allow-Methods: *");
		header("Content-Type: application/json");
		// create db link
		try {
			$this->mysql = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->pass);
			// set the PDO error mode to exception
			$attr_mode = \PDO::ERRMODE_EXCEPTION;
			$err_mode = \PDO::ATTR_ERRMODE;
			$this->mysql->setAttribute($attr_mode, $err_mode);
		} catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
			exit;
		}
		// Variables needed
		$this->args = explode('/', rtrim($action, '/'));
		if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
			$this->verb = array_shift($this->args);
		}
		/// Set the endpoint (method to be called)
		if (isset($method)) {
			$this->endpoint = $method;
		}
		switch ($this->verb) {
			case "add":
				$this->endpointPrefix = 'add';
				break;
			case "edit":
				$this->endpointPrefix = 'update';
				break;
			case "remove":
				$this->endpointPrefix = 'remove';
				break;
			default:
				$this->endpointPrefix = '';
				break;
		}
		// Sets method
		$this->method = $_SERVER['REQUEST_METHOD'];
		if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
			if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
				$this->method = 'DELETE';
			} else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
				$this->method = 'PUT';
			} else {
				throw new Exception("Unexpected Header");
			}
		}
		// Check method
		switch($this->method) {
			case 'DELETE':
			case 'POST':
				$this->action = $this->_cleanInputs($_POST);
				break;
			case 'GET':
				$this->action = $this->_cleanInputs($_GET);
				break;
			case 'PUT':
				$this->action = $this->_cleanInputs($_GET);
				$this->file = file_get_contents("php://input");
				break;
			default:
				$this->_response('Invalid Method', 405);
				break;
		}
	}
	// process API
	public function processAPI() {
		if ($this->endpointPrefix > '') {
			$this->endpoint = $this->endpointPrefix . strtoupper($this->endpoint);
		}
		if (method_exists($this, $this->endpoint)) {
			return $this->_response($this->{$this->endpoint}($this->args));
		}
		return $this->_response("No Endpoint: $this->endpoint", 404);
	}
	// response header and return
	private function _response($data, $status = 200) {
		header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
		return json_encode($data);
	}
	// clean inputs
	private function _cleanInputs($data) {
		$clean_input = array();
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$clean_input[$k] = $this->_cleanInputs($v);
			}
		} else {
			$clean_input = trim(strip_tags($data));
		}
		return $clean_input;
	}
	// request status
	private function _requestStatus($code) {
		$status = array(  
			200 => 'OK',
			404 => 'Not Found',   
			405 => 'Method Not Allowed',
			500 => 'Internal Server Error',
		); 
		return ($status[$code])?$status[$code]:$status[500]; 
	}
	// verify signature
	protected function verifySignature($userid, $email, $key, $sigs) {
		$match = strtoupper(hash_hmac("sha256", $email . $userid, $key));
		if ($match === $sigs) {
			return true;
		}
		return false;
	}
	// destruct
	public function __destruct() {
		$this->mysql = NULL; // closing connection
	}
}