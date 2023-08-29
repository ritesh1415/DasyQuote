<?php 
	$get_details = $this->db->where('id',$this->session->userdata('id'))->get('providers')->row_array();
	$provider_address=$this->db->where('provider_id',$this->session->userdata('id'))->get('provider_address')->row_array();
	$bank_details=$this->db->where('user_id',$this->session->userdata('id'))->get('bank_account')->row_array();
	$category = $this->service->get_category();
	$subcategory = $this->service->get_subcategory();
?>
<div class="content">
	<div class="container">
		<div class="row">
			<?php $this->load->view('user/home/provider_sidemenu');?>
			<div class="col-xl-9 col-md-8">
				<form id="update_provider" action="<?php echo base_url()?>user/dashboard/update_provider" method="POST" enctype="multipart/form-data">
					<div class="widget">
						<h4 class="widget-title"><?php echo (!empty($user_language[$user_selected]['lg_Profile_Settings'])) ? $user_language[$user_selected]['lg_Profile_Settings'] : $default_language['en']['lg_Profile_Settings']; ?></h4>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="row">
							<div class="col-xl-12">
								<h5 class="form-title"><?php echo (!empty($user_language[$user_selected]['lg_Basic_Information'])) ? $user_language[$user_selected]['lg_Basic_Information'] : $default_language['en']['lg_Basic_Information']; ?></h5>
							</div>
							<div class="form-group col-xl-12">
								<div class="media align-items-center mb-3">
									<?php if(file_exists($get_details['profile_img'])) { ?>
									<img class="user-image" src="<?php echo base_url().$get_details['profile_img']?>" alt="">
									<?php } else { ?>
									<img class="user-image" src="<?php echo(settingValue('profile_placeholder_image'))?base_url().settingValue('profile_placeholder_image'):base_url().'assets/img/user.jpg';?>" alt="">
									
									<?php } ?>
									<div class="media-body">
										<h5 class="mb-0"><?php echo $get_details['name']?></h5>
										<p>Max file size is 20mb</p>
										<div class="jstinput"><a id="openfile" href="javascript:void(0);"  class="browsephoto"><?php echo (!empty($user_language[$user_selected]['lg_Browse'])) ? $user_language[$user_selected]['lg_Browse'] : $default_language['en']['lg_Browse']; ?></a></div> 
										<input type="hidden" id="crop_prof_img" name="profile_img">
									</div>
								</div>
							</div>
						</div>
					</div>
						<div class="row">
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Name'])) ? $user_language[$user_selected]['lg_Name'] : $default_language['en']['lg_Name']; ?></label>
								<input class="form-control" type="text" value="<?php echo $get_details['name']?>" readonly>
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Email'])) ? $user_language[$user_selected]['lg_Email'] : $default_language['en']['lg_Email']; ?></label>
								<input class="form-control" type="email" value="<?php echo $get_details['email']?>" readonly>
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Country_Code'])) ? $user_language[$user_selected]['lg_Country_Code'] : $default_language['en']['lg_Country_Code']; ?></label>
								<input class="form-control" type="text" value="<?php echo $get_details['country_code']?>" readonly>
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Mobile_Number'])) ? $user_language[$user_selected]['lg_Mobile_Number'] : $default_language['en']['lg_Mobile_Number']; ?></label>
								<input class="form-control no_only" type="text"  value="<?php echo $get_details['mobileno']?>" name="mobileno" readonly required>
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Date_birth'])) ? $user_language[$user_selected]['lg_Date_birth'] : $default_language['en']['lg_Date_birth']; ?></label>
								<?php if(!empty($get_details['dob'])){
				                             $date=date(settingValue('date_format'), strtotime($get_details['dob']));
				                            }else{
				                                $date='-';                                
				                            } ?>
								<input type="text" class="form-control provider_datepicker" autocomplete="off" name="dob" value="<?php echo $date;?>">
							</div>
							<div class="col-xl-12">
								<h5 class="form-title"><?php echo (!empty($user_language[$user_selected]['lg_Address'])) ? $user_language[$user_selected]['lg_Address'] : $default_language['en']['lg_Address']; ?></h5>
							</div>
							<div class="form-group col-xl-12">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Address'])) ? $user_language[$user_selected]['lg_Address'] : $default_language['en']['lg_Address']; ?></label>
								<input type="text" class="form-control" name="address" value="<?php if(!empty($provider_address['address'])){ echo $provider_address['address']; }?>">
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Country'])) ? $user_language[$user_selected]['lg_Country'] : $default_language['en']['lg_Country']; ?></label>
								<select class="form-control" id="country_id" name="country_id" >
									<option value=''><?php echo (!empty($user_language[$user_selected]['lg_Select_Country'])) ? $user_language[$user_selected]['lg_Select_Country'] : $default_language['en']['lg_Select_Country']; ?></option>
									<?php foreach($country as $row){?>
									<option value='<?php echo $row['id'];?>' <?php if(!empty($provider_address['country_id'])){ echo ($row['id']==$provider_address['country_id'])?'selected':'';}?>><?php echo $row['country_name'];?></option> 
								<?php } ?>
								</select>
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_State'])) ? $user_language[$user_selected]['lg_State'] : $default_language['en']['lg_State']; ?></label>
								<select class="form-control" name="state_id" id="state_id" >
								</select>
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_City'])) ? $user_language[$user_selected]['lg_City'] : $default_language['en']['lg_City']; ?></label>
								<select class="form-control" name="city_id" id="city_id">
								</select>
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Postal_Code'])) ? $user_language[$user_selected]['lg_Postal_Code'] : $default_language['en']['lg_Postal_Code']; ?></label>
								<input type="text" class="form-control" name="pincode" value="<?php if(!empty($provider_address['pincode'])){echo $provider_address['pincode'];} ?>" >
							</div>
							<div class="col-xl-12">
								<h5 class="form-title"><?php echo (!empty($user_language[$user_selected]['lg_Payment_Purpose'])) ? $user_language[$user_selected]['lg_Payment_Purpose'] : $default_language['en']['lg_Payment_Purpose']; ?></h5>
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Name'])) ? $user_language[$user_selected]['lg_Name'] : $default_language['en']['lg_Name']; ?></label>
								<input type="text" class="form-control" placeholder="Account Holder Name" name="account_holder_name" value="<?php if(!empty($bank_details['account_holder_name'])){echo $bank_details['account_holder_name'];} ?>" >
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Account_No'])) ? $user_language[$user_selected]['lg_Account_No'] : $default_language['en']['lg_Account_No']; ?></label>
								<input type="text" class="form-control" name="acc_no" value="<?php if(!empty($bank_details['acc_no'])){echo $bank_details['acc_no'];} ?>" >
							</div>

							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Bank_Name'])) ? $user_language[$user_selected]['lg_Bank_Name'] : $default_language['en']['lg_Bank_Name']; ?></label>
								<input type="text" class="form-control" name="bank_name" value="<?php if(!empty($bank_details['bank_name'])){echo $bank_details['bank_name'];} ?>" >
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Bank_Address'])) ? $user_language[$user_selected]['lg_Bank_Address'] : $default_language['en']['lg_Bank_Address']; ?></label>
								<input type="text" class="form-control" name="bank_addr" value="<?php if(!empty($bank_details['bank_addr'])){echo $bank_details['bank_addr'];} ?>" >
							</div>

							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_IFSC_Code'])) ? $user_language[$user_selected]['lg_IFSC_Code'] : $default_language['en']['lg_IFSC_Code']; ?></label>
								<input type="text" class="form-control" name="ifsc_code" value="<?php if(!empty($bank_details['ifsc_code'])){echo $bank_details['ifsc_code'];} ?>" >
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Pan_No'])) ? $user_language[$user_selected]['lg_Pan_No'] : $default_language['en']['lg_Pan_No']; ?></label>
								<input type="text" class="form-control" name="pancard_no" value="<?php if(!empty($bank_details['pancard_no'])){echo $bank_details['pancard_no'];} ?>" >
							</div>

							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Sort_Code'])) ? $user_language[$user_selected]['lg_Sort_Code'] : $default_language['en']['lg_Sort_Code']; ?></label>
								<input type="text" class="form-control" name="sort_code" value="<?php if(!empty($bank_details['sort_code'])){echo $bank_details['sort_code'];} ?>" >
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Routing_No'])) ? $user_language[$user_selected]['lg_Routing_No'] : $default_language['en']['lg_Routing_No']; ?></label>
								<input type="text" class="form-control" name="routing_number" value="<?php if(!empty($bank_details['routing_number'])){echo $bank_details['routing_number'];} ?>" >
							</div>

							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_paypal_email_id'])) ? $user_language[$user_selected]['lg_paypal_email_id'] : $default_language['en']['lg_paypal_email_id']; ?></label>
								<input type="text" class="form-control" name="paypal_email_id" value="<?php if(!empty($bank_details['paypal_email_id'])){echo $bank_details['paypal_email_id'];} ?>" >
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Contact_No'])) ? $user_language[$user_selected]['lg_Contact_No'] : $default_language['en']['lg_Contact_No']; ?></label>
								<input type="number" class="form-control" name="contact_number" value="<?php if(!empty($bank_details['contact_number'])){echo $bank_details['contact_number'];} ?>" >
							</div>

							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Payment_Mode'])) ? $user_language[$user_selected]['lg_Payment_Mode'] : $default_language['en']['lg_Payment_Mode']; ?></label>
								<select class="form-control" name="mode" id="payment_mode">
                                    <option value="">Select Payment Mode</option>
                                    <option <?php if($bank_details['mode'] == "NEFT") { ?> selected="selected"<?php } ?> value="NEFT">NEFT</option>
                                    <option <?php if($bank_details['mode'] == "RTGS") { ?> selected="selected"<?php } ?> value="RTGS">RTGS</option>
                                    <option <?php if($bank_details['mode'] == "IMPS") { ?> selected="selected"<?php } ?> value="IMPS">IMPS</option>
                                    <option <?php if($bank_details['mode'] == "UPI") { ?> selected="selected"<?php } ?> value="UPI">UPI</option>
                                </select>
							</div>
							<div class="form-group col-xl-6">
								<label class="mr-sm-2"><?php echo (!empty($user_language[$user_selected]['lg_Payment_Purpose'])) ? $user_language[$user_selected]['lg_Payment_Purpose'] : $default_language['en']['lg_Payment_Purpose']; ?></label>
								<select class="form-control" name="purpose">
                                    <option value="Payout" <?php if($bank_details['purpose'] == "Payout") { ?> selected="selected"<?php } ?>><?php echo (!empty($user_language[$user_selected]['lg_payout'])) ? $user_language[$user_selected]['lg_payout'] : $default_language['en']['lg_payout']; ?></option>
                                	<option value="refund" <?php if($bank_details['purpose'] == "refund") { ?> selected="selected"<?php } ?>><?php echo (!empty($user_language[$user_selected]['lg_refund'])) ? $user_language[$user_selected]['lg_refund'] : $default_language['en']['lg_refund']; ?></option>
								</select>
							</div>


							<div class="form-group col-xl-12">
								<button name="form_submit" id="form_submit" class="btn btn-primary pl-5 pr-5" type="submit"><?php echo (!empty($user_language[$user_selected]['lg_Update'])) ? $user_language[$user_selected]['lg_Update'] : $default_language['en']['lg_Update']; ?></button>
							</div>
							<input type="hidden" id="country_id_value" value="<?= isset($provider_address['country_id'])?$provider_address['country_id']:'';?>">
						<input type="hidden" id="state_id_value" value="<?= $provider_address['state_id'];?>">
						<input type="hidden" id="city_id_value" value="<?= $provider_address['city_id'];?>">
						</div>
					</form>
				</div>
			</div>
		</div>
   </div>
</div>

<div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo (!empty($user_language[$user_selected]['lg_Upload_Image'])) ? $user_language[$user_selected]['lg_Upload_Image'] : $default_language['en']['lg_Upload_Image']; ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php $curprofile_img = (!empty($profile['profile_img']))?$profile['profile_img']:''; ?>
				<form class="avatar-form" action="<?php echo base_url()?>user/dashboard/profile_cropping" enctype="multipart/form-data" method="post">
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
					<div class="avatar-body">
						<div class="avatar-upload">
							<input class="avatar-src" name="avatar_src" type="hidden">
							<input class="avatar-data" name="avatar_data" type="hidden">
							<label for="avatarInput"><?php echo (!empty($user_language[$user_selected]['lg_Select_Image'])) ? $user_language[$user_selected]['lg_Select_Image'] : $default_language['en']['lg_Select_Image']; ?></label>
							<input type="file"  accept="image/*" class="avatar-input ad_pd_file" id="avatarInput" name="profile_img" >
							
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="avatar-wrapper"></div>
							</div>
						</div>
						<div class="row avatar-btns">
							<div class="col-md-12">
								<input type="hidden" name="table_name" value="providers">
								<input type="hidden" name="redirect" value="provider-settings">
								<button class="btn btn-primary avatar-save pull-right" type="submit"><?php echo (!empty($user_language[$user_selected]['lg_Save_Changes'])) ? $user_language[$user_selected]['lg_Save_Changes'] : $default_language['en']['lg_Save_Changes']; ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
