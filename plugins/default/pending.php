<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network (OSSN)
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
 
$search = input('search_users');

$list = get_unvalidated_users_with_documents($search);
$count = get_unvalidated_users_with_documents($search, 'count');

?>
<div>
	<form method="post">
		<input type="text" name="search_users" placeholder="<?php echo ossn_print('search'); ?>" />
		<input type="submit" class="btn btn-primary btn-sm" value="<?php echo ossn_print('search'); ?>"/>
	</form>
</div>

<section class="gallery min-vh-100">
    <div class="container-lg">
		<div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3">
			<?php
 				if($list) {
					foreach($list as $user) {
						$vds = new Diploma;
						$vds->type = 'user';
						$vds->subtype = 'diploma:file';
						$vds->owner_guid = $user->guid;
						$vds = $vds->getDiplomaFile();
						// Get the extension
						$extension = $vds->getExtension();
						$extension = strtolower($extension); // Normalize to lowercase
						echo '<div class="col">';
						echo '<div class="card" style="width: 18rem;">';
						switch ($extension) {
							case 'jpg':
							case 'jpeg':
								// Handle JPEG images
								echo '<img class="card-img-top" src="';
								echo ossn_site_url("pending_validations/user/{$vds->{0}->owner_guid}"); 		
								echo '" alt="Card image cap">';
								
								break;
								
							case 'png':
								// Handle PNG images
								echo '<img class="card-img-top" src="';
								echo ossn_site_url("pending_validations/user/{$vds->{0}->owner_guid}"); 		
								echo '" alt="Card image cap">';
								break;
								
							case 'pdf':
								// Handle PDF files
								echo '<a href="';
								echo ossn_site_url("pending_validations/user/{$vds->{0}->owner_guid}"); 
								echo '" target="_blank" style="text-decoration: none;">';
								echo '<div class="card-img-top d-flex justify-content-center align-items-center" style="height: 200px; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">';
								echo '<i class="fas fa-file-pdf" style="font-size: 100px; color: #dc3545;"></i></div></a>';
            			
								break;
								
							default:
								error_log("Unsupported file extension: " . $extension);
								// Handle unsupported file types
								$this->handleUnsupportedFile($extension);
								break;
						}

						echo '<div class="card-body">';
						echo '<h5 class="card-title">'.$user->fullname.'</h5>';
						echo '<table class="table ossn-users-list">';	
						echo '<tr>';
						echo '<td><a class="badge bg-success text-white" href="';	
						
						echo ossn_site_url("action/admin/validate/user?guid={$user->guid}", true); 
						echo '"><i class="fa-solid fa-user-check"></i>';
						echo ossn_print('validate'); 
						echo '</a></td>';
									
						echo '<td><a class="badge bg-warning text-white" href="';
						echo ossn_site_url("administrator/edituser/{$user->username}");
						echo '"><i class="fa-solid fa-square-pen"></i>';
						echo ossn_print('edit'); 
						echo '</a></td>';

						echo '<td><a class="badge bg-danger text-white" href="';
						echo ossn_site_url("action/admin/delete/user?guid={$user->guid}", true);
						echo '"><i class="fa-solid fa-trash-can"></i>';
						echo ossn_print('delete');
						echo '</a></td></tr></table></div></div></div>';
					}
				}
			?>

		</div>	
	</div>
</section>



<!-- Modal -->
<div class="modal fade" id="gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <img src="img/1.jpg" class="modal-img" alt="modal img">
     
	  <div class="mt-3 d-flex justify-content-center">
		  <button type="button" class="btn btn-success me-2" data-bs-dismiss="modal" onclick='window.location.href="<?php echo ossn_site_url("action/admin/validate/user?guid={$user->guid}", true); ?>"'>Validate</button>
		  <!--button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick='window.location.href="<?php //echo ossn_site_url("pending_validations/delete/{$user->guid}/{$vds[0]->guid}/user", true); ?>"'>Delete</button-->
		  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick='window.location.href="<?php echo ossn_site_url("action/admin/delete/user?guid={$user->guid}", true); ?>"'>Delete</button>
        </div>
	 </div>
    </div>
  </div>
</div>
		<?php echo ossn_view_pagination($count); ?>
	</div>
</div>
<div class="ossn-unvalidated-multiple-settings d-none">
	<hr />
	<div class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
		<i class="fa-solid fa-cogs"></i>
		</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			<li><a class="dropdown-item" id="ossn-unvalidated-multi-validate" data-bs-dismiss="modal" href="javascript:void(0);"><?php echo ossn_print('validate'); ?></a></li>
			<li><a class="dropdown-item" id="ossn-unvalidated-multi-delete" data-bs-dismiss="modal" href="javascript:void(0);"><?php echo ossn_print('delete'); ?></a></li>
		</ul>
	</div>
	<div class="margin-top-10"></div>
</div>