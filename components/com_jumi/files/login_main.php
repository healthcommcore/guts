<?php 
/**
 * This file should be placed within a Jumi component in order to function properly. 
 *
 * It is the default page that appears when when a user clicks on the About you menu item or the 
 * Login button on the GUTS homepage. It works in conjunction with the Person and FormHelper classes 
 * to determine if a user is already logged in and to test user input. If login is successful, 
 * the user is redirected to About you.
 *
 * @author		Dave Rothfarb
 * @copyright	2012 Health Communication Core
 */
 
defined( '_JEXEC' ) or die( 'Restricted access' );
	session_start();
	require_once('components/com_jumi/files/form_helper.php');
	require_once('components/com_jumi/files/person.php');
	
	if(!empty($_SESSION[USER_LOGIN])){
		header("Location: " . ABOUT_YOU_URL);
	}
	else{
		$form = new FormHelper();

?>

<div class="rt-article">
  <div class="article-header">
    <div id="title_graphic">
      <h1>Please log in</h1>
    </div>
  </div>
  <div class="item-page">
    <p>Log in here to update your contact info and learn about your survey history.</p>
    <p>If you forgot your ID or are having problems logging on, send us an email at <a href="mailto:guts@channing.harvard.edu">guts@channing.harvard.edu</a> and we’ll get right back to you!</p>

<?php
	// check if the form has been submitted, capture POST variables, 
	// do basic form validation, clean input of potential malicious code
	if($form->hasBeenSubmitted()){
		$id = $_POST['gutsid'];
		$dob = $_POST['dob'];
		if($form->hasEmptyFields($id, $dob)){
			echo "<p class='error'>" . $form->displayEmptyFieldsError() . "</p>";
		}
		else{
			$form->cleanInput($id, $dob);
			if(Person::isValidUser($form->getId(), $form->getDob())){
				$form->aboutMeRedirect();
			}
			else{
				echo "<p class='error'>" . $form->displayNoUserError() . "</p>";
				
			}
		}
	}
?>

<form id="user_login" name="login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table>
        <tr>
          <td class="table_label"><label for="GUTS ID">GUTS ID:</label></td>
          <td class="table_data"><input type="text" name="gutsid" value="<?php echo isset($_POST['gutsid']) ? $_POST['gutsid'] : ''; ?>"/></td>
        </tr>
        <tr>  
          <td class="table_label"><label for="Date of birth">Date of birth:<br /><span>MMDDYYYY format</span></label></td>
          <td class="table_data"><input type="password" name="dob" /></td>
        </tr>
    </table> 
    <input class="submit" type="submit" name="submit" value="submit" /> 
</form>
 <div class="clear"></div>
    <h2>Am I still in this study?</h2>
    <p><strong>Absolutely.</strong> In fact, the longer you stay in the study, the more valuable your participation
      becomes. That’s because the more you tell us about yourself, the more links we can make
      between behavior and health outcomes (the stronger the links become, too).</p>
    <p><strong>You skipped some past surveys?</strong> No problem. Welcome back! Surveys are shorter now, and
      you can complete them online. We’ve improved the GUTS experience to make it as easy as
      possible for you to stay with us for years to come!</p>
  </div>
</div>

<?php }// end check if session exists ?>
