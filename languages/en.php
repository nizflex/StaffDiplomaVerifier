<?php
/**
 * Staff.ma - The Healthcare Social Network
 *
 * @package   Open Source Social Network
 * @author    Nizone dev.
 * @copyright (C) 2025 Staff.ma
 * @license    General Public Licence
 * @link      https://www.staff.ma  || https://github.com/nizflex/
 */

// Traductions en anglais pour le composant StaffTemplate
$en = array(
		'staff:dipverif:admin:users:pendingvalidations' => 'Pending Validations',
		'staff:dipverif:compatibility:error' => '<b>%s</b> cannot be enabled as long as <b>StaffDiplomaVerifier</b> is activated',
		'staff:dipverif:email:confirmation:pending' => 'You did not confirm your email address yet - check your incoming mails, please.',
		'staff:dipverif:diploma:upload:pending' => 'You did not confirm your email address yet - check your incoming mails, please.',
		'staff:dipverif:activation:pending' => 'Stay tuned - the admin has been notified - your account will be activated soon.',
		'staff:dipverif:diploma:upload:title' => 'Upload Diploma or Certification Document',
		'staff:dipverif:admin:user:delete:error' => 'Cannot delete user! Please try again later.',
		'staff:dipverif:admin:user:deleted' => 'User has been deleted successfully.',
		'staff:dipverif:diploma:delete:fail' => 'Cannot delete validation document! Please try again later.',
		'staff:dipverif:diploma:deleted' => "Validation Doc. with the title of '%s' has been successfully deleted.",

);
ossn_register_languages('en', $en);