
			<?php
			$placholder_img = $this->db->get_where('system_settings', array('key'=>'service_placeholder_image'))->row()->value;
			if(!empty($category)) {
				foreach ($category as $crows) {
					$category_name=strtolower($crows['category_name']);
					if(!empty($crows['category_image']) && (@getimagesize(base_url().$crows['category_image']))){
						$category_image = base_url().$crows['category_image'];
					}else{
						$category_image = ($placholder_img)? base_url().$placholder_img:base_url().'uploads/placeholder_img/1641376256_banner.jpg';
					} 

				?>
			<div class="col-lg-4 col-md-6">
				<a href="<?php echo base_url();?>search/<?php echo str_replace(' ', '-', $category_name);?>">
					<div class="cate-widget">
						<img src="<?php echo $category_image;?>" alt="">
						<div class="cate-title">
							<h3><span><i class="fas fa-circle"></i> <?php echo ucfirst($crows['category_name']);?></span></h3>
						</div>
						<div class="cate-count">
							<i class="fas fa-clone"></i> <?php echo $crows['category_count'];?>
						</div>
					</div>
				</a>
			</div>
			<?php } }
			else { ?>

				<div class="col-lg-12">
				<div class="category">
				<?php echo (!empty($user_language[$user_selected]['lg_no_categories_found'])) ? $user_language[$user_selected]['lg_no_categories_found'] : $default_language['en']['lg_no_categories_found'] ?>
				</div>
				</div>
				<?php
				} 

			echo $this->ajax_pagination->create_links();
			?>
			<script src="<?php echo base_url();?>assets/js/functions.js"></script>	