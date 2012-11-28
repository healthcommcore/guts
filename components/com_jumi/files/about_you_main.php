<?php
/**
 * This file should be placed within a Jumi component in order to function properly. 
 *
 * Once a user successfully logs in, he/she is redirected to this page. The Person class is used to 
 * process and display a GUTS user's data. Because the user's login information is stored within a 
 * session, they will remain logged in until the session times out. Currently there is no log out
 * function yet but may be in the future.
 *
 * @author		Dave Rothfarb
 * @copyright	2012 Health Communication Core
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );

session_start();
require_once('components/com_jumi/files/person.php');

if(isset($_SESSION[USER_LOGIN])){
	$id = $_SESSION[USER_LOGIN][GUTSID];
	$dob = $_SESSION[USER_LOGIN][DOB];

	$user = new Person($id, $dob);
	
	?>
	
	<div class="rt-article">
	  <div class="article-header">
		<div id="title_graphic">
		  <h1>Welcome, <?php echo $user->getName() . " !"; ?></h1>
		</div>
	  </div>
	  <div class="item-page">
        <div id="user_data"> 
          <p>Here is the current contact info we have for you:</p>
          <ul>
              <li class="statboxlg1"><strong>Email:</strong> <?php echo $user->getEmail(); ?></li>
              <li class="statboxlg1"><strong>Mail:</strong> <?php echo $user->getAddress(); ?></li>
          </ul>
          <p>Look okay? If not, you can update it <a href="http://www.gutsweb.org/addchange/" target="_blank">here.</a> <em>(The update may take up to 24 hours to go into effect.)</em></p>
          <h2>Did you know?</h2>
          <p class="statboxlg1">You’ve been part of GUTS since <strong><?php echo $user->getNumYears(); ?> </strong> and have completed <strong><?php echo $user->getNumSurveys(); ?> surveys.</strong> Thank you!</p>
          <p>Your next survey is scheduled for <strong>January 2013.</strong> It’s shorter than in previous years, asks some
      interesting new questions, and you’ll be able to get to it from this very website. We think these
      are improvements, and hope you do, too.</p>
      
      <p>Many participants asked to see some of their trends over time. Here's a glance at the physical activities you participated in the most over the years:</p>
          <?php 
              $paAct = $user->getPaActivities();
			  // this function is found in helper.php
              displayActivityTable($paAct);
          ?>
                  
                      
      <h2 class="smaller_h2">...and the life of the mind</h2>
      
      <?php 
              $leisureAct = $user->getLeisureActivities();
			  // this function is found in helper.php
              displayActivityTable($leisureAct);
      ?>
		</div>	
	  </div>
	</div>
<?php 
	}
	else{
		header("Location: " . LOGIN_URL);
	}
	
	
?>
		
