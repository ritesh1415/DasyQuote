(function($) {
  "use strict";
	var base_url=$('#base_url').val();
  var BASE_URL=$('#base_url').val();
  var csrf_token=$('#csrf_token').val();
  var csrfName=$('#csrfName').val();
  var csrfHash=$('#csrfHash').val();
  var modules=$('#modules_page').val();
  $( document ).ready(function() {
    $('.get_services').on('click',function(){
      get_services();
    });
    
    $('.hearting').on('click', function () {
      var rowId = $(this).attr('data-id');
      var userId = $(this).attr('data-userid');
      var favStatus = $(this).attr('data-favstatus');
      var providerId = $(this).attr('data-provid');
      var serviceId = $(this).attr('data-servid');
      var pageName = $(this).attr('data-pagename');

      if(favStatus && userId) {
        var url = base_url + 'home/user_favorite_data';
        var data = { 
          id: rowId,
          userid: userId,
          status: favStatus,
          provider: providerId,
          service: serviceId,
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
  });   

  function get_services() { 
    var price_range=$('#price_range').val();
    var min_price = $('#min_price').html();
    var max_price = $('#max_price').html();
   
    var sort_by=$('#sort_by').val();
    var common_search=$('#common_search').val();
    var categories=$('#categories').val();
    var subcategories=$('#subcategories').val();
   
    var service_latitude=$('#service_latitude').val();
    var service_longitude=$('#service_longitude').val();
    var user_address=$('#service_location').val();
    if(user_address==''){
      var service_latitude='';
      var service_longitude='';
    }
   
    $('#dataList').html('<div class="page-loading">'+
      '<div class="preloader-inner">'+
		  '<div class="preloader-square-swapping">'+
			'<div class="cssload-square-part cssload-square-green"></div>'+
			'<div class="cssload-square-part cssload-square-pink"></div>'+
			'<div class="cssload-square-blend"></div>'+
      '</div>'+
      '</div>'+	
    '</div>');
    $('#dataList').empty();
    $.post(base_url+'home/all_services',{min_price:min_price,max_price:max_price,sort_by:sort_by,common_search:common_search,categories:categories,subcategories:subcategories,service_latitude:service_latitude,service_longitude:service_longitude,csrf_token_name:csrf_token,user_address:user_address},function(data){
	   var obj=jQuery.parseJSON(data);
		   $('#service_count').html(obj.count);
		   $('#dataList').html(obj.service_details);
    })
  }

  // jquery ui range - price range

  var $priceFrom = $('.price-ranges .from'),
  $priceTo = $('.price-ranges .to');
  var min_price = $('#min_price').html();
  var max_price = $('#max_price').html();

  $(".price-range").slider({
    range: true,
    min: 1,
    max: 100000,
    values: [min_price, max_price],
    slide: function (event, ui) {
		  $priceFrom.text(ui.values[0]);
		  $priceTo.text(ui.values[1]);
    }
  });

})(jQuery);