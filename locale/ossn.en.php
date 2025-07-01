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
		'staff:dipverif:diploma:upload:title' => 'Upload diploma or certification',
		'staff:dipverif:admin:user:delete:error' => 'Cannot delete user! Please try again later.',
		'staff:dipverif:admin:user:deleted' => 'User has been deleted successfully.',
		'staff:dipverif:diploma:delete:fail' => 'Cannot delete validation document! Please try again later.',
		'staff:dipverif:diploma:deleted' => "Validation Doc. with the title of '%s' has been successfully deleted.",
		'staff:dipverif:diploma:upload:success' => 'Your diploma document has been uploaded successfully!',
		'staff:dipverif:diploma:upload:fail' => 'Something went wrong, your document could not be uploaded! Please try again later.',
		'staff:dipverif:diploma:upload:file' => 'Diploma/Certification file:',
		'staff:dipverif:diploma:alreadyverified' => 'Your diploma has already been verified.',
		'staff:dipverif:diploma:waitingadmin' => 'Your diploma has been submitted and is awaiting admin review.',
		'staff:dipverif:diploma:upload:instructions' => 'To complete your registration as a health professional, please upload a photo or a scanned pdf of your diploma or certification document. This will help us verify your professional qualifications and activate your professional account.',
		'staff:dipverif:diploma:formats' => 'Accepted formats: JPG, PNG and PDF. ',
        'staff:dipverif:diploma:maxsize'  => 'Maximum file size: 5MB',
		'staff:dipverif:diploma:usernotfound' => 'User not found!',
		'staff:dipverif:diploma:alreadyverified' => 'Your diploma has already been verified.',
		'staff:dipverif:diploma:upload:invalidtype' => 'Invalid file type. Only JPG, PNG and PDF are allowed.',
		'staff:dipverif:diploma:upload:toolarge' => 'File is too large. Maximum allowed size is 5MB.',
		'staff:dipverif:diploma:upload:error' => 'There was a problem uploading your diploma. Please try again.'    
                
                             		
		
);
ossn_register_languages('en', $en);