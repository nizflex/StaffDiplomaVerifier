<?php
/**
 * Staff.ma - The Healthcare Social Network
 *
 * @package   Open Source Social Network
 * @author    Nizone dev.
 * @copyright (C) 2025 Staff.ma
 * @license    General Public Licence
 * @link      https://www.staff.ma  || https://github.com/nizflex/
 * @date	   05-07-2025
 * @last-modified 05-07-2025
 * @version   1.0
 * @component StaffProfileFeatures
 * @description Adds features to the staff profile, such as new user categories, and more.     
 *=====================================================================
 */
// Define the component path
define('__STAFF_PROFILE_FEATURES_', ossn_route()->com . 'StaffProfileFeatures/');

require_once __STAFF_DIP_VERIF_ . 'classes/Diploma.php';


function com_staff_profile_features_init()
{
    

}

//Checks that OssnProfile component is installed and enabled
function com_staff_profile_features_compatibility_check($event, $type, $params)
{
	
}



ossn_register_callback('ossn', 'init', 'com_staff_profile_features_init');
