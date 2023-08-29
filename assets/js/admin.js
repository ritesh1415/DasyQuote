(function($) {
  "use strict";
  var csrf_token=$('#admin_csrf').val();
  var base_url=$('#base_url').val();


	// Variables declarations
	
	var $wrapper = $('.main-change_languagewrapper');
	var $wrapper1 = $('.main-wrapper');
	var $pageWrapper = $('.page-wrapper');
	var $slimScrolls = $('.slimscroll');
	$( document ).ready(function() {
   $('#save_profile_change').on('click',function(){
    changeAdminProfile();
  });
  
    $('#adminmail').on('blur',function(){
    
	 var email = $('#adminmail').val();
   $.ajax({
     type:'POST',
     url: base_url+'admin/profile/check_admin_mail',
     data :  {email:email,csrf_token_name:csrf_token},
     success:function(response)
     {
       if(response==1)
       {
		 
		 $("#email_error").html("Email ID already exist...!");
		 $("#save_profile_change").prop("disabled",true);
       }
       else {
		$("#email_error").html("");
		$("#save_profile_change").prop("disabled",false);
      }
    }
  });
  
  });
  
  
   $('#upload_images').on('click',function(){
    upload_images();
  }); 
});

    $(document).on('change', '.change_auto_approval_status', function() {
        var approveStatus= $('#auto_approval').prop('checked');
        if(approveStatus==true) {
            var status=1;
        }
        else {
            var status=2;
        }
        $.post(base_url+'admin/service/changeAutoApprovalStatus',{status:status,csrf_token_name:csrf_token},function(data){
            if(data=="1"){
                swal({
                    title: "Service",
                    text: "Service Status Change SuccessFully....!",
                    icon: "success",
                    button: "okay",
                    closeOnEsc: false,
                    closeOnClickOutside: false
                });
            }
            
        });
    }); 
    
	// Sidebar
	var Sidemenu = function() {
		this.$menuItem = $('#sidebar-menu a');
	};
	
	function init() {
		var $this = Sidemenu;
		$('#sidebar-menu a').on('click', function(e) {
			if($(this).parent().hasClass('submenu')) {
				e.preventDefault();
			}
			if(!$(this).hasClass('subdrop')) {
				$('ul', $(this).parents('ul:first')).slideUp(350);
				$('a', $(this).parents('ul:first')).removeClass('subdrop');
				$(this).next('ul').slideDown(350);
				$(this).addClass('subdrop');
			} else if($(this).hasClass('subdrop')) {
				$(this).removeClass('subdrop');
				$(this).next('ul').slideUp(350);
			}
		});
		$('#sidebar-menu ul li.submenu a.active').parents('li:last').children('a:first').addClass('active').trigger('click');
	}
	
	// Sidebar Initiate
	init();
	
	// Mobile menu sidebar overlay
	
	$('body').append('<div class="sidebar-overlay"></div>');
	$(document).on('click', '#mobile_btn', function() {
		$wrapper1.toggleClass('slide-nav');
		$('.sidebar-overlay').toggleClass('opened');
		$('html').addClass('menu-opened');
		return false;
	});
	
	// Sidebar overlay
	
	$(".sidebar-overlay").on("click", function () {
		$wrapper1.removeClass('slide-nav');
		$(".sidebar-overlay").removeClass("opened");
		$('html').removeClass('menu-opened');
	});	
	
	// Select 2
	
	if ($('.select').length > 0) {
		$('.select').select2({
			minimumResultsForSearch: -1,
			width: '100%'
		});
	}

	$(document).on('click', '#filter_search', function() {
		$('#filter_inputs').slideToggle("slow");
	});

	// Datetimepicker
	
	if($('.datetimepicker').length > 0 ){
		$('.datetimepicker').datetimepicker({
			format: 'DD-MM-YYYY',
			icons: {
				up: "fas fa-angle-up",
				down: "fas fa-angle-down",
				next: 'fas fa-angle-right',
				previous: 'fas fa-angle-left'
			}
		});
		$('.datetimepicker').on('dp.show',function() {
			$(this).closest('.table-responsive').removeClass('table-responsive').addClass('temp');
		}).on('dp.hide',function() {
			$(this).closest('.temp').addClass('table-responsive').removeClass('temp')
		});
	}
  $('.start_date').datetimepicker({
    format: 'DD-MM-YYYY',
    icons: {
      up: "fas fa-angle-up",
      down: "fas fa-angle-down",
      next: 'fas fa-angle-right',
      previous: 'fas fa-angle-left'
    }
  });
  $('.start_date').on('dp.show',function() {
    $(this).closest('.table-responsive').removeClass('table-responsive').addClass('temp');
  }).on('dp.hide',function(e) {
    $('.end_date').data("DateTimePicker").minDate(e.date)
    $(this).closest('.temp').addClass('table-responsive').removeClass('temp')
  });
  $('.end_date').datetimepicker({
    format: 'DD-MM-YYYY',
    icons: {
      up: "fas fa-angle-up",
      down: "fas fa-angle-down",
      next: 'fas fa-angle-right',
      previous: 'fas fa-angle-left'
    }
  });
  $('.end_date').on('dp.show',function() {
    $(this).closest('.table-responsive').removeClass('table-responsive').addClass('temp');
  }).on('dp.hide',function() {
    $(this).closest('.temp').addClass('table-responsive').removeClass('temp')
  });

	// Tooltip
	
	if($('[data-toggle="tooltip"]').length > 0 ){
		$('[data-toggle="tooltip"]').tooltip();
	}
	
    // Datatable

    if ($('.datatable').length > 0) {
      $('.datatable').DataTable({
        "bFilter": false,
      });
    }
    $('.revenue_table').DataTable();
    $('.language_table').DataTable();
    $('.categories_table').DataTable();
    $('.ratingstype_table').DataTable();
    $('.service_table').DataTable();
    $('.payment_table').DataTable();

    // Owl Carousel

    if ($('.images-carousel').length > 0) {
      $('.images-carousel').owlCarousel({
       loop: true,
       center: true,
       margin: 10,
       responsiveClass: true,
       responsive: {
        0: {
         items: 1
       },
       600: {
         items: 1
       },
       1000: {
         items: 1,
         loop: false,
         margin: 20
       }
     }
   });
    }

	// Sidebar Slimscroll

	if($slimScrolls.length > 0) {
		$slimScrolls.slimScroll({
			height: 'auto',
			width: '100%',
			position: 'right',
			size: '7px',
			color: '#ccc',
			allowPageScroll: false,
			wheelStep: 10,
			touchScrollStep: 100
		});
		var wHeight = $(window).height() - 60;
		$slimScrolls.height(wHeight);
		$('.sidebar .slimScrollDiv').height(wHeight);
		$(window).resize(function() {
			var rHeight = $(window).height() - 60;
			$slimScrolls.height(rHeight);
			$('.sidebar .slimScrollDiv').height(rHeight);
		});
	}
	
	// Small Sidebar

	$(document).on('click', '#toggle_btn', function() {
		if($('body').hasClass('mini-sidebar')) {
			$('body').removeClass('mini-sidebar');
			$('.subdrop + ul').slideDown();
		} else {
			$('body').addClass('mini-sidebar');
			$('.subdrop + ul').slideUp();
		}
		setTimeout(function(){ 
			mA.redraw();
			mL.redraw();
		}, 300);
		return false;
	});
	
	$(document).on('mouseover', function(e) {
		e.stopPropagation();
		if($('body').hasClass('mini-sidebar') && $('#toggle_btn').is(':visible')) {
			var targ = $(e.target).closest('.sidebar').length;
			if(targ) {
				$('body').addClass('expand-menu');
				$('.subdrop + ul').slideDown();
			} else {
				$('body').removeClass('expand-menu');
				$('.subdrop + ul').slideUp();
			}
			return false;
		}
		
		$(window).scroll(function() {
      if ($(window).scrollTop() >= 30) {
        $('.header').addClass('fixed-header');
      } else {
        $('.header').removeClass('fixed-header');
      }
    });
		
		$(document).on('click', '#loginSubmit', function() {
			$("#adminSignIn").submit();
		});
		
	});



  $('#adminSignIn').bootstrapValidator({
    fields: {
      username:   {
        validators:          {
          notEmpty:              {
            message: 'Please enter your Username'
          }
        }
      },
      password:           {
        validators:           {
          notEmpty:               {
            message: 'Please enter your Password'
          }
        }
      }
    }
  }).on('success.form.bv', function(e) {

    var username = $('#username').val();
    var password = $('#password').val();
    $.ajax({
     type:'POST',
     url: base_url+'admin/login/is_valid_login',
     data :  $('#adminSignIn').serialize(),
     success:function(response)
     {
       if(response==1)
       {
         window.location = base_url+'dashboard';
       }
       else {
        swal({
            title: "Wrong Credentials..!",
            text: "Invalid login credentials..",
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function(){
            location.reload();
          });
      }
    }
  });
    return false;
}); 


  $('#forgotpwdadmin').bootstrapValidator({
    fields: {
      email:   {
        validators:          {
          notEmpty:              {
            message: 'Please enter your Email ID'
          }
        }
      }
    }
  }).on('success.form.bv', function(e) {

    var email = $('#email').val();
    $.ajax({
     type:'POST',
     url: base_url+'admin/login/check_forgot_pwd',
     data :  $('#forgotpwdadmin').serialize(),
     success:function(response)
     {
       if(response==1)
       {
		 $("#err_frpwd").html("Reset link has been sent to your mail ID, Check your mail.").css("color","green");
       }
       else {
		$("#err_frpwd").html("Email ID Not Exist...!").css("color","red");
      }
    }
  });
    return false;
}); 



  $('#resetpwdadmin').bootstrapValidator({
    fields: {
      new_password:   {
        validators:          {
          notEmpty:              {
            message: 'Please enter your New Password'
          }
        }
      },
	  
	  confirm_password:   {
        validators:          {
          notEmpty:              {
            message: 'Please enter your Confirm Password'
          }
        }
      }
    }
  }).on('success.form.bv', function(e) {

    var new_password = $('#new_password').val();
    var confirm_password = $('#confirm_password').val();
	
	if(new_password == confirm_password)
	{
		$.ajax({
		 type:'POST',
		 url: base_url+'admin/login/save_reset_password',
		 data :  $('#resetpwdadmin').serialize(),
		 success:function(response)
		 {
		   if(response==1)
		   {
			 $("#err_respwd").html("Password Changed SuccessFully...!").css("color","green");
			 window.location = base_url+'admin';
		   }
		   else {
			$("#err_respwd").html("Something went wrong...!").css("color","red");
		  }
		}
	  });
	}
	else
	{
		$("#err_respwd").html("Password Mismatch...!").css("color","red");
		
	}
    
    return false;
}); 


  $('#addSubscription').bootstrapValidator({
    fields: {
      subscription_name:   {
        validators: {
          remote: {
            url: base_url + 'service/check_subscription_name',
            data: function(validator) {
              return {
                subscription_name: validator.getFieldElements('subscription_name').val(),
                csrf_token_name:csrf_token
              };
            },
            message: 'This subscription name is already exist',
            type: 'POST'
          },
          notEmpty: {
            message: 'Please enter subscription name'

          }
        }
      },
      amount:           {
        validators:           {
          notEmpty:               {
            message: 'Please enter subscription amount'
          }
        }
      },
      duration:           {
        validators:           {
          notEmpty:               {
            message: 'Please select subscription duration'
          }
        }
      }
    }
  }).on('success.form.bv', function(e) {

    var subscription_name = $('#subscription_name').val();
    var fee_description = $('#subscription_description').val();
    var amount = $('#amount').val();
    var duration = $('#duration').val();
    var status = $('input[name="status"]:checked').val();
    $.ajax({
     type:'POST',
     url: base_url+'service/save_subscription',
     data : {subscription_name:subscription_name,fee_description:fee_description,subscription_amount:amount,subscription_duration:duration,status:status,csrf_token_name:csrf_token},
     success:function(response)
     {
       if(response==1)
       {
         window.location = base_url+'subscriptions';
       }
       else
       {
         window.location = base_url+'subscriptions';
       }
     }
   });
    return false;
        }); 
        
  $('#add_app_keywords').bootstrapValidator({
    fields: {
      page_name:   {
        validators: {
          notEmpty: {
            message: 'Please enter page name'

          }
        }
      },                
  }
}).on('success.form.bv', function(e) {


  return true;
});

  $('#add_language').bootstrapValidator({
    fields: {
      language_name:   {
        validators: {
          notEmpty: {
            message: 'Please enter language name'

          }
        }
      },
      language_value:   {
        validators: {
          notEmpty: {
            message: 'Please enter language value'

          }
        }
      },
      language_type:   {
        validators: {
          notEmpty: {
            message: 'Please enter language type'

          }
        }
      },                  
  }
}).on('success.form.bv', function(e) {


  return true;
});

  $('#admin_settings').bootstrapValidator({
    fields: {
      website_name:   {
        validators: {
          notEmpty: {
            message: 'Please enter website name'

          }
        }
      },
      contact_details:   {
        validators: {
          notEmpty: {
            message: 'Please enter contact details'

          }
        }
      },
      mobile_number:   {
        validators: {
          notEmpty: {
            message: 'Please enter mobile number'

          }
        }
      },
	currency_option:   {
        validators: {
          notEmpty: {
            message: 'Please select currency'

          }
        }
      },
	commission:   {
        validators: {
          notEmpty: {
            message: 'Please enter commission amount'

          }
        }
      },
	  
	  login_type:   {
        validators: {
          notEmpty: {
            message: 'Please select Login type'

          }
        }
      },
	paypal_gateway:   {
        validators: {
          notEmpty: {
            message: 'Please enter paypal gateway'

          }
        }
      },
	braintree_key:   {
        validators: {
          notEmpty: {
            message: 'Please enter braintree key'

          }
        }
      },
	site_logo:           {
		   validators:           {
			file: {
			  extension: 'jpeg,png,jpg',
			  type: 'image/jpeg,image/png,image/jpg',
			  message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
			}
		  }
		},
	favicon:           {
		   validators:           {
			file: {
			  extension: 'png,ico',
			  type: 'image/png,image/ico',
			  message: 'The selected file is not valid. Only allowed ico,png files'
			}
			
		  }
		},	
  }
}).on('success.form.bv', function(e) {


  return true;
});

$('#map_settings').bootstrapValidator({
    fields: {
        map_key:   {
            validators: {
                notEmpty: {
                    message: 'Please enter google map API key'
                }
            }
        },
    }
}).on('success.form.bv', function(e) {
  return true;
});

$('#apikey_settings').bootstrapValidator({
    fields: {
        firebase_server_key:   {
            validators: {
                notEmpty: {
                    message: 'Please enter Firebase server key'
                }
            }
        },
    }
}).on('success.form.bv', function(e) {
  return true;
});

$('#social_settings').bootstrapValidator({
    fields: {
        login_type:   {
            validators: {
                notEmpty: {
                    message: 'Please select any one option'
                }
            }
        },
        otp_by:   {
            validators: {
                notEmpty: {
                    message: 'Please select any one option'
                }
            }
        },
    }
}).on('success.form.bv', function(e) {
  return true;
});

$('#general_settings').bootstrapValidator({
    fields: {
        website_name:   {
            validators: {
                notEmpty: {
                    message: 'Please enter website name'
                }
            }
        },
        contact_details:   {
            validators: {
                notEmpty: {
                    message: 'Please enter contact details'
                }
            }
        },
        mobile_number:   {
            validators: {
                notEmpty: {
                    message: 'Please enter mobile number'
                }
            }
        },
        language:   {
            validators: {
                notEmpty: {
                    message: 'Please select one language'
                }
            }
        },
        currency_option:   {
            validators: {
                notEmpty: {
                    message: 'Please select one option'
                }
            }
        },
        radius:   {
            validators: {
                notEmpty: {
                    message: 'Please select range of radius'
                }
            }
        },
    }
}).on('success.form.bv', function(e) {
  return true;
});

$('#seo_settings').bootstrapValidator({
    fields: {
        meta_title:   {
            validators: {
                notEmpty: {
                    message: 'Please enter Meta Title '
                }
            }
        },
        meta_desc:   {
            validators: {
                notEmpty: {
                    message: 'Please enter Meta Description '
                }
            }
        },
    }
}).on('success.form.bv', function(e) {
  return true;
});

$('#image_settings').bootstrapValidator({
    fields: {
        logo_front:   {
            validators: {
                file: {
                    extension: 'jpeg,png,jpg',
                    type: 'image/jpeg,image/png,image/jpg',
                    message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
                },
            }
        },
        favicon:   {
            validators: {
                file: {
                    extension: 'jpeg,png,jpg',
                    type: 'image/jpeg,image/png,image/jpg',
                    message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
                },
            }
        },
        header_icon:   {
            validators: {
                file: {
                    extension: 'jpeg,png,jpg',
                    type: 'image/jpeg,image/png,image/jpg',
                    message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
                },
            }
        },
    }
}).on('success.form.bv', function(e) {
  return true;
});

$('#placeholder_settings').bootstrapValidator({
    fields: {
        service_placeholder_image:   {
            validators: {
                file: {
                    extension: 'jpeg,png,jpg',
                    type: 'image/jpeg,image/png,image/jpg',
                    message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
                },
               
            }
        },
        profile_placeholder_image:   {
            validators: {
                file: {
                    extension: 'jpeg,png,jpg',
                    type: 'image/jpeg,image/png,image/jpg',
                    message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
                },
             
            }
        },
    }
}).on('success.form.bv', function(e) {
  return true;
});

  $('#add_category').bootstrapValidator({
    fields: {
      category_name:   {
        validators: {
          remote: {
            url: base_url + 'categories/check_category_name',
            data: function(validator) {
              return {
                category_name: validator.getFieldElements('category_name').val(),
                csrf_token_name:csrf_token
              };
            },
            message: 'This category name is already exist',
            type: 'POST'
          },
          stringLength: {
                    min : 1, 
                    max: 100,
                    message: "Category name must be between 1 and 100 characters long"
                },
          notEmpty: {
            message: 'Please enter category name'

          }
        }
      },
      category_image:           {
       validators:           {
        file: {
          extension: 'jpeg,png,jpg',
          type: 'image/jpeg,image/png,image/jpg',
          message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
        },
        notEmpty:               {
          message: 'Please upload category image'
        }
      }
    },
    category_mobile_icon:           {
      validators:           {
        file: {
          extension: 'jpeg,png',
          type: 'image/jpeg,image/png',
          message: 'The selected file is not valid. Only allowed jpeg,png files'
        },

        notEmpty:               {
          message: 'Please upload category mobile icon'
        }
      }
    }                    
  }
}).on('success.form.bv', function(e) {


  return true;
});  

$('#update_category').bootstrapValidator({
  fields: {
    category_name:   {
      validators: {
        remote: {
          url: base_url + 'categories/check_category_name',
          data: function(validator) {
            return {
              category_name: validator.getFieldElements('category_name').val(),
              csrf_token_name:csrf_token,
              category_id: validator.getFieldElements('category_id').val()
            };
          },
          message: 'This category name is already exist',
          type: 'POST'
        },
        notEmpty: {
          message: 'Please enter category name'

        }
      }
    },
     category_image:           {
       validators:           {
        file: {
          extension: 'jpeg,png,jpg',
          type: 'image/jpeg,image/png,image/jpg',
          message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
        }
      }
    },

  }
}).on('success.form.bv', function(e) {


  return true;
        });   

        $('#update_banner').bootstrapValidator({
          fields: {
            banner_content: {
              validators:           {
                notEmpty: {
                  message: 'Content is required'
        
                },
            }
          },
            banner_sub_content: {
              validators:           {
                notEmpty: {
                  message: 'Sub content is required'
        
                },
            }
          },
        
          }
        }).on('success.form.bv', function(e) {
          var img_err = $('.img_err').text();
          if(img_err == '') {
            return true;
          } else {
            return false;
          }
          
                });   

$('#add_subcategory').bootstrapValidator({
  fields: {
    subcategory_name:   {
      validators: {
        remote: {
          url: base_url + 'categories/check_subcategory_name',
          data: function(validator) {
            return {
              category: validator.getFieldElements('category').val(),
              csrf_token_name:csrf_token,
              subcategory_name: validator.getFieldElements('subcategory_name').val()
            };
          },
          message: 'This sub category name is already exist',
          type: 'POST'
        },
        notEmpty: {
          message: 'Please enter sub category name'

        }
      }
    },

    subcategory_image:           {
       validators:           {
        file: {
          extension: 'jpeg,png,jpg',
          type: 'image/jpeg,image/png,image/jpg',
          message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
        },
        notEmpty:               {
          message: 'Please upload sub category image'
        }
      }
    },
    category:           {
      validators:           {
        notEmpty:               {
          message: 'Please select category'
        }
      }
    }                  
  }
}).on('success.form.bv', function(e) {


  return true;
});  



$('#update_subcategory').bootstrapValidator({
  fields: {
    subcategory_name:   {
      validators: {
        remote: {
          url: base_url + 'categories/check_subcategory_name',
          data: function(validator) {
            return {
              category: validator.getFieldElements('category').val(),
              subcategory_name: validator.getFieldElements('subcategory_name').val(),
              csrf_token_name:csrf_token,
              subcategory_id: validator.getFieldElements('subcategory_id').val()
            };
          },
          message: 'This sub category name is already exist',
          type: 'POST'
        },
        notEmpty: {
          message: 'Please enter sub category name'

        }
      }
    },
     subcategory_image:           {
       validators:           {
        file: {
          extension: 'jpeg,png,jpg',
          type: 'image/jpeg,image/png,image/jpg',
          message: 'The selected file is not valid. Only allowed jpeg,jpg,png files'
        }
      }
    },
    category:           {
      validators:           {
        notEmpty:               {
          message: 'Please select category'
        }
      }
    } 

  }
}).on('success.form.bv', function(e) {


  return true;
        });   

$('#add_ratingstype').bootstrapValidator({
  fields: {
    name:   {
      validators: {
        remote: {
          url: base_url + 'ratingstype/check_ratingstype_name',
          data: function(validator) {
            return {
              category_name: validator.getFieldElements('name').val(),
              csrf_token_name:csrf_token
            };
          },
          message: 'This Rating type name is already exist',
          type: 'POST'
        },
        notEmpty: {
          message: 'Please enter rating type name'

        }
      }
    },
  }
}).on('success.form.bv', function(e) {


  return true;
});

$('#update_ratingstype').bootstrapValidator({
  fields: {
    name:   {
      validators: {
        remote: {
          url: base_url + 'ratingstype/check_ratingstype_name',
          data: function(validator) {
            return {
              name: validator.getFieldElements('name').val(),
              csrf_token_name:csrf_token,
              id: validator.getFieldElements('id').val()
            };
          },
          message: 'This rating type name is already exist',
          type: 'POST'
        },
        notEmpty: {
          message: 'Please enter rating type name'

        }
      }
    },

  }
}).on('success.form.bv', function(e) {


  return true;
        });   


$("#amount").on("change", function(){
    var amount = $('#amount').val();

    if((amount) == 0) {
        //$("#duration").prop("sle", 0);
        $("#duration").val('0').trigger('change')
        $("#duration").attr("disabled", true); 
    } else {
        $("#duration").val('').trigger('change')
        $("#duration").attr("disabled", false); 
    }
  //var description = $("#duration option:selected").text();
  //$("#subscription_description").val(description);
})

$("#duration").on("change", function(){
  var description = $("#duration option:selected").text();
  $("#subscription_description").val(description);
})

$('#editSubscription').bootstrapValidator({
  fields: {
    subscription_name:   {
      validators: {
        remote: {
          url: base_url + 'service/check_subscription_name',
          data: function(validator) {
            return {
              subscription_name: validator.getFieldElements('subscription_name').val(),
              csrf_token_name:csrf_token,
              subscription_id: validator.getFieldElements('subscription_id').val()
            };
          },
          message: 'This subscription name is already exist',
          type: 'POST'
        },
        notEmpty: {
          message: 'Please enter subscription name'

        }
      }
    },
    amount:           {
      validators:           {
        notEmpty:               {
          message: 'Please enter subscription amount'
        }
      }
    },
    duration:           {
      validators:           {
        notEmpty:               {
          message: 'Please select subscription duration'
        }
      }
    }
  }
}).on('success.form.bv', function(e) {

  var subscription_id = $('#subscription_id').val();
  var subscription_name = $('#subscription_name').val();
  var fee_description = $('#subscription_description').val();
  var amount = $('#amount').val();
  var duration = $('#duration').val();
  var status = $('input[name="status"]:checked').val();
  $.ajax({
   type:'POST',
   url: base_url+'service/update_subscription',
   data : {subscription_id:subscription_id,subscription_name:subscription_name,fee_description:fee_description,subscription_amount:amount,subscription_duration:duration,status:status,csrf_token_name:csrf_token,},
   success:function(response)
   {
     if(response==1)
     {
       window.location = base_url+'subscriptions';
     }
     else
     {
       window.location = base_url+'subscriptions';
     }
   }
 });
  return false;
        }); 

$('#addKeyword').bootstrapValidator({
  fields: {
    multiple_key:           {
      validators:           {
        notEmpty:               {
          message: 'Please enter keyword'
        }
      }
    }
  }
}).on('success.form.bv', function(e) {

  var page_key = $('#page_key').val();
  var multiple_key = $('#multiple_key').val();
  $.ajax({
   type:'POST',
   url: base_url+'admin/language/save_keywords',
   data : {page_key:page_key,multiple_key:multiple_key},
   success:function(response)
   {
     if(response==1)
     {
       window.location = base_url+'language/'+page_key;
     }
   }
 });
  return false;
        }); 

$('#image_upload_error').hide();
$('#image_error').hide();


var csrf_toiken=$('#admin_csrf').val();
var url = base_url+'admin/profile/check_password';

$('#change_password_form').bootstrapValidator({
  fields: {
    current_password: {
      validators: {
        remote: {
         url: url,
         data: function(validator) {
           return {
             current_password: validator.getFieldElements('current_password').val(),
             'csrf_token_name':csrf_token
           };
         },
         message: 'Current Password is Not Valid',
         type: 'POST'
       },
       notEmpty: {
        message: 'Please Enter Current Password'
      }
    }
  },

  new_password: {
    validators: {
     stringLength: {
      min: 4,
      message: 'The full name must be less than 4 characters'
    },
    different: {
      field: 'current_password',
      message: 'The username and password cannot be the same as each other'
    },
    notEmpty: {
      message: 'Please Enter Password...'
    }
  }
},
confirm_password: {
  validators: {
   identical: {
    field: 'new_password',
    message: 'The password and its confirm are not the same'
  },
  notEmpty: {
    message: 'Please Enter Password...'
  }
}
}                    
}
}).on('success.form.bv', function(e) {
  e.preventDefault();
  $.ajax({
    url: base_url+'admin/profile/change_password',
    type: "post",
    data: $('#change_password_form').serialize(),
    success: function(response) {
      swal({
        title: "Password Updated..!",
        text: "Password Updated SuccessFully..",
        icon: "success",
        button: "okay",
        closeOnEsc: false,
        closeOnClickOutside: false
      }).then(function(){
        location.reload();
      });
    }
  });

});    



function update_language(lang_key, lang, page_key) {
	var cur_val = $('input[name="'+lang_key+'['+lang+']"]').val();
	var prev_val = $('input[name="prev_'+lang_key+'['+lang+']"]').val();

	$.post(base_url+'admin/language/update_language',{lang_key:lang_key, lang:lang, cur_val:cur_val, page_key:page_key},function(data){
		if(data == 1) {
			$("#flash_success_message").show();
		}
		else if(data == 0) {
			$('input[name="'+lang_key+'['+lang+']"]').val(prev_val);
			$("#flash_error_message").html('Sorry, This keyword already exist!');
			$("#flash_error_message").show();
		}
		else if(data == 2) {
			$('input[name="'+lang_key+'['+lang+']"]').val(prev_val);
			$("#flash_error_message").html('Sorry, This field should not be empty!');
			$("#flash_error_message").show();
		}
	});
}

function upload_images(){
	var img= $('.avatar-input').val();
	if(img!=''){
		$('#image_upload_error').hide();
		return true;
	}else{
		$('#image_upload_error').text('Please Upload an Image . ');
		$('#image_upload_error').show();
		return false;
	}
}

function changeAdminProfile(){
	$('#image_error').hide();
	var profile_img = $('#crop_prof_img').val();
	var adminmail = $('#adminmail').val();
	
	var error = 0;
	
	
	if(error==0){
		var url = base_url+'admin/profile/update_profile';
		//fetch file
		var formData = new FormData();
		formData.append('profile_img', profile_img);
		formData.append('adminmail', adminmail);
		formData.append('csrf_token_name', csrf_token);
		$.ajax({
			url: url,
			type: "POST",
			data: formData,
			cache: false,
			processData: false,
			contentType: false,
			context: this,
			success:function(res)
			{
       window.location.href=base_url+'admin-profile';
     }
   });
	}
}

function delete_category(id) {
	$('#delete_category').modal('show');
	$('#category_id').val(id);
}

function delete_subcategory(id) {
	$('#delete_subcategory').modal('show');
	$('#subcategory_id').val(id);
}

function delete_ratings_type(id) {
	$('#delete_ratings_type').modal('show');
	$('#id').val(id);
}


 $(document).on("click", ".delete_show", function () {
    var id=$(this).attr('data-id');
    delete_modal_show(id);
  });
  
  $(document).on("click", "#chkdel_subcribe", function () {
    var id=$(this).attr('sid');
    subdelete_modal_show(id);
});
function subdelete_modal_show(id) {
      $('#sub_delete_modal').modal('show');
      $('#confirm_delete_sub').attr('data-id',id);
  }
  $('#confirm_delete_sub').on('click',function(){
      var id=$(this).attr('data-id');
      confirm_delete_subcription(id);
  });
  function confirm_delete_subcription(id) {
      if(id!=''){
            $('#sub_delete_modal').modal('hide');
             $.ajax({
                   type:'POST',
                   url: base_url+'admin/service/delete_subsciption',
                   data : {id:id,csrf_token_name:csrf_token},
                   dataType:'json',
                   success:function(response)
                   {
                      swal({
                        title: "Success..!",
                        text: "Deleted SuccessFully",
                        icon: "success",
                        button: "okay",
                        closeOnEsc: false,
                        closeOnClickOutside: false
                      }).then(function(){
                        location.reload();
                      });
                }
              });
            }
  }
  
  function delete_modal_show(id){
    $('#delete_modal').modal('show');
    $('#confirm_btn').attr('data-id',id);
    $('#confirm_delete_pro').attr('data-id',id);
	$('#confirm_btn_admin').attr('data-id',id);
  }
    $('#confirm_btn_admin').on('click',function(){ 
    var id=$(this).attr('data-id');
    var url=base_url+"admin/dashboard/adminuser_delete";
    delete_confirm(id,url);
  });
   function delete_confirm(id,url){
    if(id!=''){
      $('#delete_modal').modal('hide');
       $.ajax({
     type:'POST',
     url: url,
     data : {id:id,csrf_token_name:csrf_token},
     dataType:'json',
     success:function(response)
     {
       if(response.status)
       {
        swal({
          title: "Success..!",
          text: response.msg,
          icon: "success",
          button: "okay",
          closeOnEsc: false,
          closeOnClickOutside: false
        }).then(function(){
          location.reload();
        });

      }
      else {
       swal({
        title: "Error..!",
        text: response.msg,
        icon: "error",
        button: "okay",
        closeOnEsc: false,
        closeOnClickOutside: false
      }).then(function(){
        location.reload();
      });
    }
  }
});
    }
  }

  /*Footer submenu*/
  $(document).ready(function() {
    if ($("#main_menu option:selected").text() == "category") {
        $("#category").show();
        $('#category_count').attr('required', '');
        $('#category_count').attr('data-error', 'This field is required.');
        $("#hidey").hide();
        $("#quick_link").hide();
        $("#contact_us").hide();
        $("#follow_us").hide();
    } else if($("#main_menu option:selected").text() == "Quick Link") {
        $("#quick_link").show();
        $('#footer_submenu').attr('required', '');
        $('#link').attr('required', '');
        $("#category").hide();
        $("#hidey").hide();
        $("#contact_us").hide();
        $("#follow_us").hide();
    } else if($("#main_menu option:selected").text() == "Follow Us") {
        $("#follow_us").show();
        $("#category").hide();
        $("#quick_link").hide();
        $("#contact_us").hide();
        $("#hidey").hide();
    } else if($("#main_menu option:selected").text() == "Contact Us") {
        $("#contact_us").show();
        $('#address').attr('required', '');
        $('#phone').attr('required', '');
        $('#email').attr('required', '');
        $("#category").hide();
        $("#hidey").hide();
        $("#quick_link").hide();
        $("#follow_us").hide();
    } else {
      $("#category").hide();
      $('#category_count').removeAttr('required');
      $('#category_count').removeAttr('data-error');
    }
 });

  $("#main_menu").change(function () {
    if ($("#main_menu option:selected").text() == "category") {
      $("#category").show();
      $('#category_count').attr('required', '');
      $('#category_count').attr('data-error', 'This field is required.');
      $("#hidey").hide();
      $("#quick_link").hide();
      $("#contact_us").hide();
      $("#follow_us").hide();
      $("#category_check").hide();
    }else {
      $("#category").hide();
      $("#category_check").hide();
      $('#category_count').removeAttr('required');
      $('#category_count').removeAttr('data-error');
    }
    if ($("#main_menu option:selected").text() == "Follow Us") {
      $("#follow_us").show();
      $("#category").hide();
      $("#quick_link").hide();
      $("#contact_us").hide();
      $("#hidey").hide();
    }else {
      $("#follow_us").hide();
    }
    if ($("#main_menu option:selected").text() == "Contact Us") {
      $("#contact_us").show();
      $('#address').attr('required', '');
      $('#phone').attr('required', '');
      $('#email').attr('required', '');
      $("#category").hide();
      $("#hidey").hide();
      $("#quick_link").hide();
      $("#follow_us").hide();
    } else {
      $("#contact_us").hide();
      $('#address').removeAttr('required', '');
      $('#phone').removeAttr('required', '');
      $('#email').removeAttr('required', '');
    }
    if ($("#main_menu option:selected").text() == "Quick Link") {
      $("#quick_link").show();
      $('#footer_submenu').attr('required', '');
      $('#link').attr('required', '');
      $("#category").hide();
      $("#hidey").hide();
      $("#contact_us").hide();
      $("#follow_us").hide();
    } else {
      $("#quick_link").hide();
      $('#footer_submenu').removeAttr('required', '');
      $('#link').removeAttr('required', '');
    }
  });

  $(document).ready(function(){
    var but = $('#quick_link').val();
    var max = 4;
    var x = 1;
    $("#btn1").click(function(){
      if(x <= max){
        $("#quick_link").append('<div class="form-group" id="quick_link"><div class="row"><div class="col-sm-6"> <div class="form-group sub_menu ml-3"><div class="row"><label class="col-sm-3 control-label mt-2">Label</label><div class="col-sm-9"><input type="text" class="form-control" name="label[]" attr="label" id="label" value=""></div></div></div></div><div class="col-sm-6"><div class="form-group sub_menu"><div class="row"><label class="col-sm-3 control-label mt-2">Link</label><div class="col-sm-9"><input type="text" class="form-control" name="link[]" attr="link" id="link" value="" required></div></div></div></div></div></div>');
        x++;
      }else{
        alert('Allowing 5 links only');
        }        
    });
  });

 /*appsection*/
  $('#appsection_showhide').on('click',function(){
      if($('#appsection_showhide').prop("checked")==true) {
          $('#store_links').show();
      } else {
         $('#store_links').hide();
      }
  });
  $(document).ready(function() {
    if($('#appsection_showhide').prop("checked")==true) {
            $('#store_links').show();
    } else {
           $('#store_links').hide();
    }
 });

/*sms gateway*/
  $(document).ready(function(){
  $("#2factor_div").css({"display": "none"});
  $("#twilio_div").css({"display": "none"});
  
  $("ul li").click(function(){
    if($(this).attr("data-id") == "nexmo") {
        $('ul li.active').removeClass('active');
        $(this).addClass("active");
        $("#nexmo_div").css({"display": ""});
        
        $("#2factor_div").css({"display": "none"});
        $("#twilio_div").css({"display": "none"});
    }
    
    if($(this).attr("data-id") == "2factor") {
        $('ul li.active').removeClass('active');
        $(this).addClass("active");
        $("#2factor_div").css({"display": ""});
        
        $("#twilio_div").css({"display": "none"});
        $("#nexmo_div").css({"display": "none"});
    }
    
    if($(this).attr("data-id") == "twilio") {
        $('ul li.active').removeClass('active');
        $(this).addClass("active");
        $("#twilio_div").css({"display": ""});
        
        $("#2factor_div").css({"display": "none"});
        $("#nexmo_div").css({"display": "none"});
    }
  });
});

$(document).ready(function(){
  $(".sms_option").click(function(){
  var clickedByme = $(this).val();
  
    $('.sms_option').each(function () {
    if(clickedByme != this.value) {
        $(this).prop('checked', false);
    }
    });
  });
});

$(document).on("click",".addfaq",function () {
  var experiencecontent = '<div class="row counts-list" id="faq_content">' +
  '<div class="col-md-11">' +
  '<div class="cards">' +
  '<div class="form-group">' +
  '<label>Title</label>' +
  '<input type="text" class="form-control" name="page_title[]" style="text-transform: capitalize;" required>' +
  '</div>' +
  '<div class="form-group mb-0">' +
  '<label>Page Content</label>' +
  ' <textarea class="form-control content-textarea" id="ck_editor_textarea_id"  name="page_content[]"></textarea>'+
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="col-md-1">' +
  '<a href="#" class="btn btn-sm bg-danger-light delete_faq">' +
  '<i class="far fa-trash-alt "></i> ' +
  '</a>' +
  '</div>' +
  '</div> ';
  
  $(".faq").append(experiencecontent);
  return false;
});

  
  function faq_delete(id)
  {
  var r = confirm("Deleting FAQ will also delete its related all datas!! ");
    if (r == true) {

      var csrf_token = $('#active_csrf').val();
      $.ajax({
        type: 'POST',
        url: base_url+"admin/settings/faq_delete",
        data: {
          id: id, 
          csrf_token_name: csrf_token
        },
        success: function (response)
        {

          if (response == 'success')
          {
            window.location = base_url+'admin/settings/faq_delete';
          }else{
            
            window.location = base_url+'admin/settings/faq_delete';
          }
        }
      });

    } else {
      return false;
    }
  

}
 $(document).ready(function() {
            $(document).on("click",".faq_delete",function() {
                var id = $(this).attr('data-id');
                faq_delete(id);
            });
       });

 function getcurrencysymbol(currencies) { 
     var csrf_toiken=$('#admin_csrf').val();
    $.ajax({
        type: "POST",
        url:  base_url+"admin/settings/get_currnecy_symbol",
        data:{
          id:currencies,
         'csrf_token_name': csrf_token,
        }, 
                           
        success: function (data) {
            $('#currency_symbol').val(data); 
        }
    });
}
$(document).ready(function() {
            $(document).on("change",".currency_code",function() {
             var currencies = $('#currency_option option:selected').text();
             getcurrencysymbol(currencies);
            });

            $(document).on("change",".countryCode",function() {
                var countryKey = $(this).find(':selected').attr('data-key');
                $('#country_code_key').val(countryKey); 
            });
       });

$(document).on("click",".addlinknew",function () {
    var len = $('.links-cont').length + 1;
    if(len <= 6) {
      var experiencecontent = '<div class="form-group links-cont">' +
      '<div class="row align-items-center">' +
      '<div class="col-lg-3 col-12">' +
      '<input type="text" class="form-control" name="label[]" attr="label" id="label" value="">' +
      '</div>' +
      '<div class="col-lg-8 col-12">' +
      '<input type="text" class="form-control" name="link[]" attr="link" id="link" value="'+base_url+'">' +
      '</div>' +
      '<div class="col-lg-1 col-12">' +
      '<a href="#" class="btn btn-sm bg-danger-light delete_links">' +
      '<i class="far fa-trash-alt "></i> ' +
      '</a>' +
      '</div>' +
      '</div>' +
      '</div>' ;
        $(".links-forms").append(experiencecontent);
    } else {
        $('.addlinknew').hide();
        alert('Allow 6 links only');
    }
  return false;
});

//Remove updated Links menus
$(document).on("click",".delete_links",function () {
    var id = $(this).attr('data-id');
    $('#link_'+id).remove();
    return false;
});

//Remove new Links menus
$(document).on("click",".delete_links",function () {
    $(this).closest('.links-cont').remove();
    return false;
});

$(document).on("click",".addsocail",function () {
  var experiencecontent = '<div class="form-group countset">' +
  '<div class="row align-items-center">' +
  '<div class="col-lg-2 col-12">' +
  '<div class="socail-links-set">' +
  '<ul>' +
  '<li class=" dropdown has-arrow main-drop">' +
  '<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" aria-expanded="false">' +
  '<span class="user-img">' +
  '<i class="fab fa-github me-2"></i>' +
  '</span>' +
  '</a>' +
  '<div class="dropdown-menu">' +
  '<a class="dropdown-item" href="#"><i class="fab fa-facebook-f me-2"></i>Facebook</a>' +
  '<a class="dropdown-item" href="#"><i class="fab fa-twitter me-2"></i>twitter</a>' +
  '<a class="dropdown-item" href="#"><i class="fab fa-youtube me-2"></i> Youtube</a>' +
  '</div>' +
  '</li>' +
  '</ul>' +
  '</div>' +
  '</div>' +
  '<div class="col-lg-9 col-12">' +
  '<input type="text" class="form-control" name="snapchat" attr="snapchat" id="facebook" value="">' +
  '</div>' +
  '<div class="col-lg-1 col-12">' +
  '<a href="#" class="btn btn-sm bg-danger-light  delete_review_comment">' +
  '<i class="far fa-trash-alt "></i> ' +
  '</a>' +
  '</div>' +
  '</div> ' +
  '</div> ';
  
  $(".setings").append(experiencecontent);
  return false;
});

$(".setings").on('click','.delete_review_comment', function () {
  $(this).closest('.countset').remove();
  return false;
});

$(document).on("click",".addnewlinks",function () {
    var len = $('.copyright_content').length + 1;
    if(len <= 3) {
    var experiencecontent = '<div class="form-group links-conts copyright_content">' +
      '<div class="row align-items-center">' +
      '<div class="col-lg-3 col-12">' +
      '<input type="text" class="form-control" value="" name="label1[]">' +
      '</div>' +
      '<div class="col-lg-8 col-12">' +
      '<input type="text" class="form-control" value="'+base_url+'" name="link1[]">' +
      '</div>' +
      '<div class="col-lg-1 col-12">' +
      '<a href="#" class="btn btn-sm bg-danger-light delete_copyright">' +
      '<i class="far fa-trash-alt "></i> ' +
      '</a>' +
      '</div>' +
      '</div>' +
      '</div>' ;
      $(".settingset").append(experiencecontent);
        return false;
    } else {
        $('.addnewlinks').hide();
        alert('Allow 3 links only');
    } 
  
});

//Remove updated copyright menus
$(document).on("click",".delete_copyright",function () {
    var id = $(this).attr('data-id');
    $('#link1_'+id).remove();
    return false;
});

//Remove new copyright menus
$(document).on("click",".delete_copyright",function () {
    $(this).closest('.copyright_content').remove();
    return false;
});

$(document).ready(function(){
    $("#2factor_div").css({"display": "none"});
    $("#twilio_div").css({"display": "none"});
  
    $("ul li").click(function(){
        if($(this).attr("data-id") == "nexmo") {
            $('ul li.active').removeClass('active');
            $(this).addClass("active");
            $("#nexmo_div").css({"display": ""});
            
            $("#2factor_div").css({"display": "none"});
            $("#twilio_div").css({"display": "none"});
        }
        
        if($(this).attr("data-id") == "2factor") {
            $('ul li.active').removeClass('active');
            $(this).addClass("active");
            $("#2factor_div").css({"display": ""});
            
            $("#twilio_div").css({"display": "none"});
            $("#nexmo_div").css({"display": "none"});
        }
        
        if($(this).attr("data-id") == "twilio") {
            $('ul li.active').removeClass('active');
            $(this).addClass("active");
            $("#twilio_div").css({"display": ""});
            
            $("#2factor_div").css({"display": "none"});
            $("#nexmo_div").css({"display": "none"});
        }
    });
});

$(document).ready(function(){
    $(".sms_option").click(function(){
        var clickedByme = $(this).val();
      
        $('.sms_option').each(function () {
            if(clickedByme != this.value) {
                $(this).prop('checked', false);
            }
        });
    });
});

$('.noty_clear').on('click',function(){
      var id=$(this).attr('data-token');
      noty_clear(id);
    });
 function noty_clear(id){
  if(id!=''){
   $.ajax({
     type: "post",
     url: base_url+"home/clear_all_noty",
     data:{csrf_token_name: csrf_token,id:id}, 
     dataType:'json',
     success: function (data) {


       if(data.success){
        $('.notification-list li').remove();
        $('.bg-yellow').text(0);
      }
    }

  });
 }
}

     $(document).ready(function() {
  $("#selectallad1").change(function(){
    if(this.checked){
      $(".checkboxad").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkboxad").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkboxad").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".checkboxad").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#selectallad1").prop("checked", true); }     
    }else {
      $("#selectallad1").prop("checked", false);
    }
  });

  if ($(".checkboxad").is(":checked")){
      var isAllChecked = 0;
      $(".checkboxad").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#selectallad1").prop("checked", true); }     
    }else {
      $("#selectallad1").prop("checked", false);
    }
});
})(jQuery);