<?php
/**
 * The Person class is responsible for storing various attributes of a GUTS study participant. Various SQL queries are used
 * to capture basic personal information and the participant's history of activity over a period of years. This class is meant to 
 * be used with Joomla 2.5 and the Jumi Component.
 * 
 * @author		Dave Rothfarb
 * @copyright	2012 Health COmmunication Core
 */

require_once("helper.php");


global $mysqli;
$mysqli= getDB();

class Person{
	
	private $_id;
	private $_dob;
	private $_name;
	private $_email;
	private $_address;
	private $_num_surveys;
	private $_pa_yrs;
	private $_la_yrs;
	private $_pa_activities;
	private $_leisure_activities;

	function __construct($id, $dob){
		$this->_id = $id;
		$this->_dob = $dob;
		$this->assemblePerson();
	}


// Static class used to check if user exists in the GUTS database
	public static function isValidUser($id, $dob){
		global $mysqli;
		$query = $mysqli->query("SELECT part_id, date_of_birth FROM Participant WHERE part_id = '$id' AND date_of_birth = '$dob'");
		return $query->fetch_assoc();
	}
	

// This function initializes the loading of user data executed by 3 other functions
	private function assemblePerson(){
		$this->assembleBasics();
		$this->setNumSurveys();
		$this->assembleActivities();
	}
	
// This creates arrays of GUTS years out of 2 separate string constants. It then loads these
// into instance variables and passes them as arguments to the lookupActivities function
	private function assembleActivities(){
		if($this->isGuts1()){
			$this->_pa_yrs = explode(",", G1_PA_YEARS);
			$this->_la_yrs = explode(",", G1_LS_YEARS);
		}
		else{
			$this->_pa_yrs = explode(",", G2_PA_YEARS);
			$this->_la_yrs = explode(",", G2_LS_YEARS);
		}
		$this->_pa_activities = $this->lookupActivities($this->_pa_yrs);
		$this->_leisure_activities = $this->lookupActivities($this->_la_yrs);
	}

// This function accepts an array of years, iterates through the array using
// each element as a term in a sql query. The query obtains hashes of the participant's
// top 3 physical activities or data pertaining to 3 specific leisure activities. The results of
// the query are then added to an array called $activities. Once iteration completes, the 
// $activities array is returned, containing physical or leisure activities over a period of
// years (2 or 3 depending on physical or leisure) for a single participant 
	private function lookupActivities($years){
		global $mysqli;
		$activities = array();
		$activityIdNum = (count($years) == 3 ? "a.act_id < 25" : "(a.act_id = 25 OR a.act_id = 31 OR a.act_id = 32)");
		foreach($years as $year){
			
			$query = $mysqli->query("SELECT name AS activity, num_hours AS hours " . 
					 "FROM Activity a, Participant_Activities pa ".
					 "WHERE pa.survey_year = '$year' AND pa.part_id  = '$this->_id' AND a.act_id = pa.act_id " .
					 "AND $activityIdNum ORDER BY num_hours DESC LIMIT 3");
			while($result = $query->fetch_assoc()){
				$activities[$year][] = $result;
			}

		}
		return $activities;
	}
	
	
	private function isGuts1(){
/*		$ids = explode(",", G1_ID_LTTRS);
		foreach($ids as $id){
			if($this->_id[0] == $id){
				return true;
			}
		}
		echo $this->_id[0];
		return false;
	}
*/		return strstr(G1_ID_LTTRS, $this->_id[0]);		
	}
	
	private function setNumSurveys(){
		global $mysqli;
		$query = $mysqli->query("SELECT COUNT(survey_year) AS num_surveys FROM Completed_Surveys WHERE part_id = '$this->_id'");
		$result = $query->fetch_assoc();
		$this->_num_surveys = $result['num_surveys'];
	}
	
	// At some point make this function more efficient with a loop
	private function assembleBasics(){
		global $mysqli;
		$query = $mysqli->query("SELECT * FROM Participant WHERE part_id = '$this->_id' AND date_of_birth = '$this->_dob'");
		$basic_info = $query->fetch_assoc();
		
		$this->_name = $basic_info['first_name'];
		$this->_email = $basic_info['email'];
		$this->_name = $basic_info['first_name'];
		$address = $basic_info['street1'];
		if($basic_info['street2'] !== NULL)
			$address .= ", " . $basic_info['street2'];
		$address .= ", " . $basic_info['city'];
		$address .= ", " . $basic_info['state'];
		$address .= " " . $basic_info['zip'];
		$this->_address = $address;
	}
	
	
	public function getName(){
		return $this->_name;
	}
	
	public function getEmail(){
		return $this->_email;
	}
	
	public function getAddress(){
		return $this->_address;
	}
	
	public function getNumYears(){
		return $this->isGuts1() ? G1_START : G2_START;
	}
	
	public function getNumSurveys(){
		return $this->_num_surveys;
	}
	
	public function getPaYears(){
		return $this->_pa_yrs;
	}
	
	public function getLaYears(){
		return $this->_la_yrs;
	}
	
	public function getPaActivities(){
		return $this->_pa_activities;
	}
	
	public function getLeisureActivities(){
		return $this->_leisure_activities;
	}
}

?>
