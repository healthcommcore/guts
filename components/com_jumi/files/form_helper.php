<?php
/**
 * The FormHelper class abstracts much of the input validation necessary in forms. It is responsible 
 * for checking and cleaning user input as well as creating a user session if login is successfull. 
 * This class is meant to be used with Joomla 2.5 and the Jumi Component.
 * 
 * @author		Dave Rothfarb
 * @copyright	2012 Health Communication Core
 */

require_once("helper.php");


global $mysqli;
$mysqli= getDB();

class FormHelper{
	private $_id;
	private $_dob;
	
	function __construct(){
	
	}

// Check if the user has already successfully logged
	public function sessionActive(){
		return isset($_SESSION[USER_LOGIN]);
	}

// Check if a form has laready been submitted
	public function hasBeenSubmitted(){
		return isset($_POST['submit']);
	}

// Check if a form has empty fields, return an appropriate error
	public function hasEmptyFields($id, $dob){
		return empty($id) || empty($dob);
	}
	
// Load session variables with user id and date of birth, then
// redirect a user to the About Me page	
	public function aboutMeRedirect(){
		$_SESSION[USER_LOGIN] = array();
		$_SESSION[USER_LOGIN][GUTSID] = $this->_id;
		$_SESSION[USER_LOGIN][DOB] = $this->_dob;
		header("Location: " . ABOUT_YOU_URL);
	}

// Clean user input, stripping away unnecessary characters, store result
// in instance variables
	public function cleanInput($id, $dob){
		global $mysqli;
		// Escape html characters and get rid of white space
		$id = ucfirst(trim(htmlspecialchars($id)));
		$dob = trim(htmlspecialchars($dob));
		$symbols = array("/", "-", "_", "|");
		$dob = str_replace($symbols, "", $dob);
		
		// Escape any malicious mysql syntax that may have been input
		$id = $mysqli->real_escape_string($id);
		$dob = $mysqli->real_escape_string($dob);
		//$dob = mysql_real_escape_string($dob, $mysqli);
		$this->_id = $id;
		$this->_dob = $dob;
	}

// User ID getter method
	public function getId(){
		return $this->_id;
	}

// User date of birth getter method
	public function getDob(){
		return $this->_dob;
	}

// Return an error if form fields are empty (uses constant set in helper.php)
	public function displayEmptyFieldsError(){
		return EMPTY_FIELDS;
	}

// Return an error if no user found in database (uses constant set in helper.php)
	public function displayNoUserError(){
		return NO_USER;
	}

}
		
?>	
	
	