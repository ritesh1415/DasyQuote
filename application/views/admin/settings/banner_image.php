<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Banner Image</h3>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
	
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-center mb-0 categories_table" >
								<thead>
									<tr>
										<th>#</th>
										<th>Image</th>
										<th>Image For</th>
										<th>Created Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($list)) {
									$i = 1;
									foreach ($list as $item) {
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><img class="thumbnail m-b-0" src="<?php echo base_url() . $item['cropped_img']; ?>" height="32"></td>
										<td><?php echo ucwords($item['bgimg_for']); ?></td>
										<td><?=date(settingValue('date_format'), strtotime($item['created_date']));?></td>
										<td >
											<a href="<?=base_url();?>admin/edit_banner/<?=$item['bgimg_id'];?>" class="btn btn-sm bg-success-light mr-2">
												<i class="far fa-edit mr-1"></i> Edit
											</a>
										</td>
										
									</tr>
									<?php $i = $i + 1;
										}
									} else { ?>
									<tr>
										<td colspan="5">
											<p class="text-danger text-center m-b-0">No Records Found</p>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div> 
					</div> 
				</div>
			</div>
		</div>
	</div>
</div>