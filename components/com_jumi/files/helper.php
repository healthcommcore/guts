<?php

/**
 * This file houses all contants used throughout the Person and FormHelper classes 
 * as well as the two files housed within the Jumi component. There is also a function
 * for establishing a database connect and one for displaying user activity data within
 * an html table. The latter could have been placed in the Person class but I preferred to
 * keep formatting code out of the classes.
 *
 * @author		Dave Rothfarb
 * @copyright	2012 Health Communication Core
 */
 
define('USER', 'nhs2_hcc');
define('PWORD', 'hcc321');
define('DB', 'nhs2_hcc');
define('HOST', 'localhost');
define('G1_START', 1996);
define('G2_START', 2004);
define('G1_PA_YEARS', '1996,1998,2001');
define('G2_PA_YEARS', '2004,2008,2011');
define('G1_LS_YEARS', '1996,2005');
define('G2_LS_YEARS', '2004,2011');
define('G1_ID_LTTRS', 'A, B, C, D, E');
define('NO_DATA', 'Sorry, there\'s no data!');
define('GUTSID', 'gutsid');
define('DOB', 'dob');
define('USER_LOGIN', 'userLogin');
define('ABOUT_YOU_URL', 'index.php?option=com_jumi&view=application&fileid=4&Itemid=111');
define('LOGIN_URL', 'index.php?option=com_jumi&view=application&fileid=3&Itemid=111');
define('EMPTY_FIELDS', 'ERROR! You did not fill in both form fields! Please try again.');
define('NO_USER', 'ERROR! There is no user with that ID or date of birth! Please try again.');

// Creates a Mysqli object from a database connection. 
// *NOTE* mysql functions do not work with a mysqli object. Make
// sure mysqli functions are used instead.
function getDB(){
	$mysqli = new mysqli(HOST, USER, PWORD, DB);
	if($mysqli->connect_errno){
		echo "Error! Could not connect to database!";
	}
	return $mysqli;
}

// Takes a hash of user activity data obtained from the database, 
// iterates through it, and displays it in an html table 
function displayActivityTable($activities){
		foreach($activities as $yr => $items){ 
			echo "<div class='stats'>";
            echo "<h3>$yr</h3>";
			echo "<table cellspacing='0' cellpadding='0' border='0'>";
            echo "<tr class='heading'>";
            echo "<th>Activity</th>";
            echo "<th>Number of hours</th>";
            echo "</tr>";
			foreach($items as $item){
				echo "<tr>";
				echo "<td class='activity'>" . $item['activity'] . "</td>";
				echo "<td class='hours'>" . $item['hours'] . "</td>";
				echo "</tr>";
			}
            echo "</table>";
			echo "</div>";
		}
}

?>
