<?php
namespace Services;
// TODO: Add APIKEY Generation method for the form page that will be using the method
class Users extends MyAPI {
	protected $limit = 5;
	protected $orderby = 'name';
	protected $order = 'DESC';
	protected $user;
	// construct
	// TODO: Add blacklisting of $origins via a new method and throw new exception if blacklisted
	public function __construct($action, $method, $origin) {
		// check for required data
		if (!isset($action, $method)) {
			throw new \Exception('Bad request');
		}
		// call parent __construct
		parent::__construct($action, $method);
		// get user data (id received from header USERID)
		$this->user = $this->user();
		// check for required data
		if (!array_key_exists('HTTP_USERID', $_SERVER)) {
			throw new \Exception('No User ID provided');
		} else if (!array_key_exists('HTTP_APIKEY', $_SERVER)) {
			throw new \Exception('No Signature provided');
		} else if (!$this->user) {
			throw new \Exception('Invalid User');
		} else if (!$this->verifySignature($_SERVER['HTTP_USERID'], $this->user['email'], $this->user['apiKey'], $_SERVER['HTTP_APIKEY'])) {
			throw new \Exception('Invalid Signature');
		}
	}
	// Add/Register user
	// TODO: add the add user method
	// Make sure to add the column apiKey
	// to your table before you complete this method
	// And generate a apiKey when adding a user (hint: use
	// hashing function coupled with users ID and Email address)
	// This is used later to authenticate the user by ID and by apiKey
	public function addUser() {
		// Add your add user method
		return 'add';
	}
	// Update user
	// TODO: add the update user method
	public function updateUser() {
		// add your update method
		return 'update';
	}
	// Remove user
	// TODO: add the remove user method
	public function removeUser() {
		return 'remove';
	}
	// get user
	// TODO: Get data from database stv_users instead of the array below
	// and add the column apiKey as part of the stv_user data and 
	// set new keys in that column for matching later
	// TODO: Make this action generate a new APIKEY for the user
	// if they request one and show it to them on the screen.
	// TODO: return one user by ID and/or name, Get the USERID from header
	public function user($action = '', $value = '') {
		switch ($action) {
			default:
				return array(
								'id' => 1, 
								'name' => 'Steven Scharf', 
								'email' => 'scharfs1@algonquincollege.com',
								'apiKey' => 'test'
							);
		}
	}
	// Users related logic
	public function users() {
		// define order field
		switch ($this->orderby) {
			case 'email':
				$order = 'ORDER BY email ' . $this->order;
				break;
			default:
				$order = 'ORDER BY name ' . $this->order;
				break;
		}
		// obtain data from database
		$aData = $this->mysql->prepare("SELECT id, name, email FROM stv_users " . $order . " LIMIT " . $this->limit . "");
		$aData->execute();
		$total = $aData->rowCount();
		$result = $aData->fetchAll();
		if ($total > 0) {
			// output in necessary format
			return array('data' => $result);
		} else {
			return array('data' => 'Nothing found');
		}
	}
}