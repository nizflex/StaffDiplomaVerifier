<?php
/**
 * Staff.ma - The Healthcare Social Network
 *
 * @package   Open Source Social Network
 * @author    Nizone dev.
 * @copyright (C) 2025 Staff.ma
 * @license    General Public Licence
 * @link      https://www.staff.ma  || https://github.com/nizflex/
 * @date	  2025-07-02
 * @last-modified 05-07-2025
 * @version   1.0
 * @component StaffDiplomaVerifier
 * @description this file handles user login for pending diploma uploads or pending accounts validations for the Staff Diploma Verifier component.     
 *=====================================================================
 */

if(ossn_isLoggedin()) {
		redirect('home');
}
$username = input('username');
$password = input('password');

if(empty($username) || empty($password)) {
		ossn_trigger_message(ossn_print('login:error') , 'error');
		redirect();
}
$user = ossn_user_by_username($username);

//check if username is email
if(strpos($username, '@') !== false) {
		$user     = ossn_user_by_email($username);
		$username = $user->username;
}

if($user && !$user->isUserVALIDATED()) {
	// changed not to resend multiple verification emails
	if (!$user->last_activity) {
		ossn_trigger_message(ossn_print('staff:dipverif:diploma:upload:pending'), 'error');
	} else {
		ossn_trigger_message(ossn_print('staff:dipverif:activation:pending'), 'success');
	}
	redirect(REF);
}

$vars = array(
		'user' => $user
);
ossn_trigger_callback('user', 'before:login', $vars);

$login           = new OssnUser;
$login->username = $username;
$login->password = $password;
if($login->Login()) {
		//One uneeded redirection when login #516
		ossn_trigger_callback('login', 'success', $vars);
		redirect('home');
} else {
		redirect('login?error=1');
}
