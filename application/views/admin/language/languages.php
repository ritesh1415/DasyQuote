<div class="page-wrapper">
	<div class="content container-fluid">
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Languages</h3>
				</div>
				<div class="col-auto text-end">
					<a class="btn btn-primary add-button" href="<?php echo base_url()?>add-languages">
						<i class="fas fa-plus"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<?php  ?>
							<table class="table custom-table mb-0 datatable">
								<thead>
									<tr>
										<th>#</th>
										<th>Language</th>
										<th>Code</th>
										<th>RTL</th>
										<th>Default Language</th>
										<th>Status</th>
										<th class="text-end">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; foreach ($language as $lang) { 
										if($lang->language_value == 'en') { 
                                			$attr = 'disabled';
                                		} else {
                                			$attr = '';
                                		} ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $lang->language; ?></td>
										<td><?php echo $lang->language_value; ?></td>
										<td>
											<div>
												<div class="status-toggle">
													<input  id="tag_<?php echo $lang->id; ?>" class="check language_tag" data-id="<?php echo $lang->id; ?>" type="checkbox" <?php if($lang->tag == 'rtl') { echo 'checked'; } ?> <?php if($this->session->userdata('role') != 1) { echo 'disabled'; } ?>>
													<label for="tag_<?php echo $lang->id; ?>" class="checktoggle">checkbox</label>
												</div>
											</div> 
		                                </td>
		                                <td>
											<div>
												<div class="status-toggle">
													<input  id="default_<?php echo $lang->id; ?>" class="check default_lang" data-id="<?php echo $lang->id; ?>" data-status="<?php echo $lang->default_language; ?>" type="checkbox" <?php if($lang->default_language == 1) { echo 'checked'; } ?> <?php if($this->session->userdata('role') != 1) { echo 'disabled'; } ?>>
													<label for="default_<?php echo $lang->id; ?>" class="checktoggle">checkbox</label>
												</div>
											</div> 
		                                </td>
		                                <td>
											<div>
												<div class="status-toggle" disabled>
													<input <?php echo $attr; ?> id="status_<?php echo $lang->id; ?>" class="check language_status" data-id="<?php echo $lang->id; ?>" type="checkbox" <?php if($lang->status == 1) { echo 'checked'; } ?> <?php if($this->session->userdata('role') != 1) { echo 'disabled'; } ?> >
													<label for="status_<?php echo $lang->id; ?>" class="checktoggle" disabled>checkbox</label>
												</div>
											</div> 
		                                </td>
										<td class="text-end">
											<a class="btn btn-sm bg-info-light me-2" href="<?php echo base_url().'web-languages/'.$lang->language_value;?>" title="Web Translation">
												<i class="fas fa-language me-1"></i>Web
											</a>
											<a class="btn btn-sm bg-warning-light me-2" href="<?php echo base_url().'app-page-list/'.$lang->language_value;?>" title="App Translation">
												<i class="fas fa-language me-1"></i>App
											</a>
											<a href="<?php echo base_url().'edit-languages/'.$lang->language_value;?>" class="btn btn-sm bg-success-light me-2" title="Edit">
												<i class="far fa-edit me-1"></i>Edit
											</a>
											<?php if($lang->language_value != 'en' && $this->session->userdata('role') == 1) { ?>
												<a href="#" class="btn btn-sm bg-danger-light me-2 delete_language" data-id="<?php echo $lang->language_value; ?>">
													<i class="far fa-trash-alt me-1"></i> Delete
												</a>
											<?php } ?>
										</td>
									</tr>
									<?php $i++; } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>