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

// Informations du composant (nom, version, description, auteur, etc.)

define('__STAFF_DIP_VERIF_', ossn_route()->com . 'StaffDiplomaVerifier/');

require_once __STAFF_DIP_VERIF_ . 'classes/Diploma.php';

function com_staff_diploma_verifier_init()
{
    // Hook to the default validation URL and custumize it
	ossn_add_hook('user', 'validation:email:url', 'transformValidationUrl');

    // Register the component page URL handler
	ossn_register_page('diploma', 'diploma_upload_page_handler');

    // Register the action for uploading diplomas
	ossn_register_action('diploma/add', __STAFF_DIP_VERIF_ . 'actions/upload.php');

	if (method_exists(new OssnSite, 'setSetting')) {
		ossn_register_callback('component', 'enabled', 'com_staff_diploma_verifier_compatibility_check');
		ossn_unregister_action('user/login');
		ossn_register_action('user/login', __STAFF_DIP_VERIF_ . 'actions/user/login.php');
	} else {
		error_log('StaffDiplomaVerifier: Error version mismatch');
		ossn_trigger_message(ossn_print('ossn:admin:settings:save:error'), 'error');
		$comp = new OssnComponents;
		$comp->DISABLE('StaffDiplomaVerifier');
		redirect(REF);
	}

	if (ossn_isAdminLoggedin()) {
			$pending_validations = array(
				'name'   => 'staff:dipverif:admin:users:pendingvalidations',
				'text'   => ossn_print('staff:dipverif:admin:users:pendingvalidations'),
				'href'   => ossn_site_url('pending_validations/list'),
				'parent' => 'admin:sidemenu:usermanager',
			);
			ossn_extend_view('css/ossn.admin.default', 'css/diploma_css');
			ossn_register_page('pending_validations', 'pending_validations_page_handler');
			ossn_register_action('ossnvds/delete', __STAFF_DIP_VERIF_ . 'actions/delete.php');
			ossn_register_menu_item('admin/sidemenu', $pending_validations);
	}
	
	ossn_extend_view('js/opensource.socialnetwork', 'js/diploma_script');
}

function com_staff_diploma_verifier_compatibility_check($event, $type, $params)
{
	$incompatible_coms = array('AnonymousRegistration', 'userautovalidate', 'DisableUserActivationByMail', 'PrivateNetwork');
	if (in_array($params['component'], $incompatible_coms)) {
		ossn_trigger_message(ossn_print('staff:dipverif:compatibility:error', array($params['component'])), 'error');
		$com = new OssnComponents;
		$com->DISABLE($params['component']);
	}
}

function pending_validations_page_handler($pages){
	$page = $pages[0];
	if (empty($page)) {
		echo ossn_error_page();
	}
	switch ($page) {
		case 'list':
			$title                = ossn_print('staff:dipverif:admin:users:pendingvalidations');
			$contents['contents'] = ossn_plugin_view('pending');
			$contents['title']    = $title;
			$content              = ossn_set_page_layout('administrator/administrator', $contents);
			echo ossn_view_page($title, $content, 'administrator');
			break;	
		
		case 'user':
					$diploma = new Diploma;
					$diploma->owner_guid = $pages[1];
					$diploma->type = 'user';
					$diploma->subtype = 'diploma:file';
					$success = $diploma->getDiplomaFile();
					
					$firstItem = $success->{'0'};
					if (is_object($firstItem)) {
						$filename = $firstItem->value;
						error_log("Filename via property '0': " . $filename);
						$firstItem->output();
						echo $filename;
					}
					break;

		case 'delete':
			if(!empty($pages[1]) && !empty($pages[2])) {

				//###############################################
				// 1 Delete user from DB
				//###############################################
				$guid = $pages[1];	
				if(!empty($guid)) {
								$user = ossn_user_by_guid($guid);
								if($user && $user->guid !== ossn_loggedin_user()->guid) {
										if(!$user->deleteUser()) {
												ossn_trigger_message(ossn_print('staff:dipverif:admin:user:delete:error'), 'error');
										}
								}	
				}
				ossn_trigger_message(ossn_print('admin:user:deleted'), 'success');
			
				//###############################################
				// 2 Delete user's objects/entities from DB
				//###############################################

			
				
				}
				redirect(REF);
			break;
	}
}

function transformValidationUrl($hook, $type, $return, $params) {
	// Replace 'uservalidate/activate' with 'diploma/upload'
    $url = str_replace('uservalidate/activate', 'diploma/upload', $return);
    
    // Find the last slash and extract the hash part
    $lastSlashPos = strrpos($url, '/');
    if ($lastSlashPos !== false) {
        $beforeHash = substr($url, 0, $lastSlashPos + 1);
        $hash = substr($url, $lastSlashPos + 1);
        
        // Keep only first 10 characters of the hash
        $shortHash = substr($hash, 0, 10);
        
        // Reconstruct the URL
        $url = $beforeHash . $shortHash;
    }
    
    return $url;
}

function diploma_upload_page_handler($pages) {
    //http://localhost/staff/diploma/upload/2/3fa88f1860 
    if (!isset($pages[1]) || !isset($pages[2])) {
        ossn_error_page();
    }
    
    $user_guid = (int) $pages[1];
    $token = trim($pages[2]);
    
    // Validate user exists
    $user = ossn_user_by_guid($user_guid);
    if (!$user) {
        ossn_error_page();
    }
    
    // Verify token matches first 10 chars of activation hash
    $activation_hash = $user->activation;
    if (empty($activation_hash) || substr($activation_hash, 0, 10) !== $token) {
        ossn_error_page();
    }
    
	// Prepare page metadata
	ossn_set_page_owner_guid($user->guid);
	$title = ossn_print('staff:dipverif:diploma:upload:title');
	$content = diploma_handle_upload_logic($user);
	$contents = array(
		'content' => $content,
	);
	
	$content = ossn_set_page_layout('contents', $contents);
	echo ossn_view_page($title, $content);
}

function diploma_handle_upload_logic($user) {
    // Case 1: Account already verified
    if (empty($user->activation)) {
		return ossn_view_page(ossn_print('diploma:upload:title'), ossn_plugin_view('output/ok', array('text' => ossn_print('diploma:alreadyverified'))));
    }
    
    // Case 2: Check for existing diploma
    $diploma = Diploma::getByUserGuid($user->guid);
    if ($diploma) {
		// If diploma exists, show message
		ossn_trigger_message(ossn_print('diploma:waitingadmin'), 'success');
		redirect(REF);
	}
    
    // Case 3: Show upload form
	$params = array(
					'content' => ossn_view_form('add', array(
												'action' => ossn_site_url() . 'action/diploma/add',
												'component' => 'StaffDiplomaVerifier',
												'class' => 'ossn-ads-form',
												'params' => array('user_guid' => $user->guid, 
																  'token' => substr($user->activation, 0, 10)
	 				 								)
										), false));
									
		
		return ossn_plugin_view('diploma/upload', array('form' => $params['content'], 'user_guid' => $user->guid, 'user_token' => substr($user->activation, 0, 10)));
}

ossn_register_callback('ossn', 'init', 'com_staff_diploma_verifier_init');
