(function($) {
	"use strict";

	var base_url=$('#base_url').val();
	var BASE_URL=$('#base_url').val();
	var csrf_token=$('#csrf_token').val();
	var csrfName=$('#csrfName').val();
	var csrfHash=$('#csrfHash').val();
	
	$('.searchFilter').on('click',function(){
		searchFilter();
	}); 
	
	function searchFilter(page_num){
		page_num = page_num?page_num:0;
		var status = $('#status').val();
		var sortBy = $('#sortBy').val();
		$.ajax({
			type: 'POST',
			url: base_url+'user/dashboard/ajaxPaginationData',
			data:'page='+page_num+'&status='+status+'&sortBy='+sortBy+'&csrf_token_name='+csrf_token,
			beforeSend: function(){
				$('.loading').show();
			},
			success: function(html){
				$('#dataList').html(html);
				$('.loading').fadeOut("slow");
			}
		});
	}

	// block/unblock user by provider
	$('.blocking').on('click', function () {
    var rowId = $(this).attr('data-id');
    var blockedById = $(this).attr('data-blockedbyid');
    var blockedStatus = $(this).attr('data-blockedstatus');
    var blockedId = $(this).attr('data-blockedid');
    var usertType = $(this).attr('data-usertype');

    if(blockedStatus && blockedById) {
      var url = base_url + 'home/block_unblock_data';
      var data = { 
        id: rowId,
        blockedById: blockedById,
        blockedStatus: blockedStatus,
        blockedId: blockedId,
        usertType: usertType,
        csrf_token_name:csrf_token
      };
      $.ajax({
        url: url,
        data: data,
        type: "POST",
        dataType: 'json',
        success: function (response) { 
          if (response.status) { 
          swal({
            title: "Success",
            text: response.msg,
            icon: "success",
            button: "okay",
            closeOnEsc: false,
            closeOnClickOutside: false
          }).then(function(){ 
            location.reload();
          });
          } else {
          swal({
            title: "Error",
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
    } else {
      swal({
        position: 'top-end',
        icon: 'success',
        title: 'You should login first',
        showConfirmButton: false,
        timer: 1500
      });
    }     
  });






})(jQuery);