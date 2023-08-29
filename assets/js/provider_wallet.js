(function($) {
	"use strict";
    var base_url=$('#base_url').val();
  var BASE_URL=$('#base_url').val();
  var csrf_token=$('#csrf_token').val();
  var csrfName=$('#csrfName').val();
  var csrfHash=$('#csrfHash').val();
 $( document ).ready(function() {
   $('.withdraw_wallet_value').on('click',function(){
    var id=$(this).attr('data-amount');
      withdraw_wallet_value(id);
    }); 
   $('.isNumber').on('keypress', function (evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
			var element =  this;
			if ((charCode != 45 || $(element).val().indexOf('-') != -1) && (charCode != 46 || $(element).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57))
				return false;
        });
 });
var stripe_key=$("#stripe_key").val();
var paypall_key = $("#paypall_key").val();
var razorpay_key = $("#razorpay_key").val();
var paystack_key = $("#paystack_key").val();

  // Create a Stripe client.
var stripe = Stripe(stripe_key);

// Create an instance of Elements.
var elements = stripe.elements();
$('#card_form_div').hide();
// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

function withdraw_wallet_value(input){
  $("#wallet_withdraw_amt").val(input);
}  

// Create an instance of the card Element.
var card = elements.create('card', {style: style, hidePostalCode : true, });

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
  $('#card-errors').css('color','red');
});


    // Handle form submission.
    var sub_btn = document.getElementById('pay_btn');

    sub_btn.addEventListener('click', function(event) {
        var currency_val=$("#currency_val").val();
        stripe.createToken(card,{'currency': currency_val}).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } 
            else {
                var token=$('#token').val();
                $('#load_div').html('<img src="'+base_url+'assets/img/loader.gif" alt="" />');
                var tokens=token;
                var stripe_amt=$("#wallet_withdraw_amt").val();
               
                var tokenid = result.token.id;
                var data="Token="+tokens+"&amount="+stripe_amt+"&currency_val="+currency_val+"&tokenid="+tokenid+"&csrf_token_name="+csrf_token;
                $.ajax({
                    url: base_url+'api/withdraw-provider',
                    data:data,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(response){            
                        console.log(response);
                        if(response.response.response_code==200 || response.response.response_code=='200'){
                            swal({
                                title: "Wallet Amount Transferred...",
                                text: "Wallet amount was Credit to your card releated by bank ...!",
                                icon: "success",
                                button: "okay",
                                closeOnEsc: false,
                                closeOnClickOutside: false
                            }).then(function(){
                                $("#load_div").hide();
                                window.location.reload();
                           });
                        }else{
                            swal({
                                title: "Wallet Amount Not Succeed...",
                                text: response.response.response_message,
                                icon: "error",
                                button: "okay",
                                closeOnEsc: false,
                                closeOnClickOutside: false
                            }).then(function(){
                                $("#load_div").hide();
                                window.location.reload();
                            });
                        }
                    },
                    error: function(error){
                        console.log(error);
                        swal({
                            title: "Wallet Amount Not Succeed...",
                            text: "Wallet amount was not transferred ...!",
                            icon: "error",
                            button: "okay",
                            closeOnEsc: false,
                            closeOnClickOutside: false
                        }).then(function(){
                            $("#load_div").hide();
                            window.location.reload();
                        });
                    }
                });
            }
        });
    });


    $('#stripe_withdraw_wallet').on('click',function(){
        var stripe_amt=$("#wallet_withdraw_amt").val();
        var wallet_amount=$('#wallet_amount').val();
        var payment_type =$( 'input[name="group2"]:checked' ).val();
        if(payment_type==undefined || payment_type==''){
            swal({
                title: 'Wallet',
                text: 'Please select any payment type...',
                icon: "error",
                button: "okay",
                closeOnEsc: false,
                closeOnClickOutside: false
            });
            $("#wallet_withdraw_amt").select();
            return false;
        }
        if(Number(stripe_amt)>Number(wallet_amount)){
            swal({
                title: 'Exceeding Wallet amount',
                text: 'Enter the amount less than wallet amount...!',
                icon: "error",
                button: "okay",
                closeOnEsc: false,
                closeOnClickOutside: false
            });
            $("#wallet_withdraw_amt").select();
            return false;
        }
        if(stripe_amt =='' || stripe_amt < 1){
            swal({
                title: 'Empty amount',
                text: 'Wallet field was empty please fill it...',
                icon: "error",
                button: "okay",
                closeOnEsc: false,
                closeOnClickOutside: false
            });
            $("#wallet_withdraw_amt").select();
            return false;
        }  

        var userId = $(this).attr('data-userid');

        //check provider account details
        if(userId) {
            var data="user_id="+userId+"&csrf_token_name="+csrf_token;
            $.ajax({
                url: base_url+'provider/bank-details',
                data:data,
                type: 'POST',
                dataType: 'JSON',
                success: function(response){
                    if(response.status) {
                        //paypal
                        if(payment_type == "Direct") {
                            if(paypall_key == '' || paypall_key == undefined) {
                                swal({
                                    title: "Empty Key",
                                    text: "Please Enter Payment api key",
                                    icon: "error",
                                    button: "okay",
                                    closeOnEsc: false,
                                    closeOnClickOutside: false
                                });
                            } else {
                                $('#strip_withdraw_wallet').hide();
                                $('#card_form_div').show();
                                $('#remember_withdraw_wallet').text(stripe_amt);
                                paypalwithdraw_continue(response.results);
                            }
                            
                        }
                        //stripe
                        if(payment_type == "stripe") { 
                            if(paypall_key == '' || paypall_key == undefined) {
                                swal({
                                    title: "Empty Key",
                                    text: "Please Enter Payment api key",
                                    icon: "error",
                                    button: "okay",
                                    closeOnEsc: false,
                                    closeOnClickOutside: false
                                });
                            } else {
                                bank_details(response.results);
                            }
                        }
                        //razorpay
                        if(payment_type=="RazorPay") {
                            if(paypall_key == '' || paypall_key == undefined) {
                                swal({
                                    title: "Empty Key",
                                    text: "Please Enter Payment api key",
                                    icon: "error",
                                    button: "okay",
                                    closeOnEsc: false,
                                    closeOnClickOutside: false
                                });
                            } else {
                                razorpay_details(response.results);
                            }
                        }

                        //paystack
                        if(payment_type=="paystack") {
                            if(paypall_key == '' || paypall_key == undefined) {
                                swal({
                                    title: "Empty Key",
                                    text: "Please Enter Payment api key",
                                    icon: "error",
                                    button: "okay",
                                    closeOnEsc: false,
                                    closeOnClickOutside: false
                                });
                            } else {
                                paystack_details(response.results);
                            }
                        }

                        //paystack
                        if(payment_type=="paysolution") {
                            withdraw_request(stripe_amt, userId);
                        }
                    }else{
                        swal({
                            title: 'Bank Details Empty',
                            text: 'You should update in profile setting page',
                            icon: "warning",
                            button: "okay",
                            closeOnEsc: false,
                            closeOnClickOutside: false
                        }).then(function(){
                            window.location.href = base_url+'provider-settings';
                        });
                    }
                }
            });
        } else {
            swal({
                title: "Somethings wrong !",
                text: "Somethings wents to wrongs, try again..!",
                icon: "error",
                button: "okay",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then(function(){
                window.location.reload();
            });
        }        
    });
    
    $('#stripe_withdraw_wallet1').on('click',function(){
        var stripe_amt=$("#wallet_withdraw_amt").val();
        var wallet_amount=$('#wallet_amount').val();
        if(Number(stripe_amt)>Number(wallet_amount)){
            swal({
                title: 'Exceeding Wallet amount',
                text: 'Enter the amount less than wallet amount...!',
                icon: "error",
                button: "okay",
                closeOnEsc: false,
                closeOnClickOutside: false
            });
            $("#wallet_withdraw_amt").select();
            return false;
        }
        if(stripe_amt =='' || stripe_amt < 1){
            swal({
                title: 'Empty amount',
                text: 'Wallet field was empty please fill it...',
                icon: "error",
                button: "okay",
                closeOnEsc: false,
                closeOnClickOutside: false
            });
            $("#wallet_withdraw_amt").select();
            return false;
        }  

        var userId = $(this).attr('data-userid');
        if(userId) {
            var data="user_id="+userId+"&csrf_token_name="+csrf_token;
            $.ajax({
                url: base_url+'provider/bank-details',
                data:data,
                type: 'POST',
                dataType: 'JSON',
                success: function(response){
                    if(response.status) {
                        withdraw_request(stripe_amt, userId);
                    }else{
                        swal({
                            title: 'Bank Details Empty',
                            text: 'You should update in profile setting page',
                            icon: "warning",
                            button: "okay",
                            closeOnEsc: false,
                            closeOnClickOutside: false
                        }).then(function(){
                            window.location.href = base_url+'provider-settings';
                        });
                    }
                }
            });
        } else {
            swal({
                title: "Somethings wrong !",
                text: "Somethings wents to wrongs, try again..!",
                icon: "error",
                button: "okay",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then(function(){
                window.location.reload();
            });
        } 
        

    });
    function paystack_details(prev_response) {
        var userId = prev_response.user_id;
        var tokens=$('#token').val();
        var stripe_amt=$("#wallet_withdraw_amt").val();
        var data="user_id="+userId+"&Token="+tokens+"&amount="+stripe_amt+"&csrf_token_name="+csrf_token;
        $.ajax({
            url: base_url+'user/dashboard/paystack_withdraw',
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function(response){ 
                if(response.status == true) {
                    swal({
                        title: "Success!!",
                        text: response.msg,
                        icon: "success",
                        button: "okay",
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    }).then(function(){
                        window.location.reload();
                    });
                } else {
                    swal({
                        title: "Somethings wrong !",
                        text: "Somethings wents to wrongs, try again..!",
                        icon: "error",
                        button: "okay",
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    }).then(function(){
                        window.location.reload();
                    });
                }
            },
        });
    }

    function withdraw_request(amount, user_id) {
        var userId = user_id;
        var tokens=$('#token').val();
        var stripe_amt=amount;
        var currency_val=$("#currency_val").val();
        var payment_type = "withdraw-request";
        var data="user_id="+userId+"&Token="+tokens+"&amount="+stripe_amt+"&currency_val="+currency_val+"&payment_type="+payment_type+"&csrf_token_name="+csrf_token;
        $.ajax({ 
            url: base_url+'user/dashboard/withdraw_request',
            data: data,
            type: 'POST',
            dataType: 'JSON',
            success: function(response){ 
                if(response.status == true) {
                    swal({
                        title: "Success!!",
                        text: response.msg,
                        icon: "success",
                        button: "okay",
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    }).then(function(){
                        window.location.reload();
                    });
                } else {
                    swal({
                        title: "Somethings wrong !",
                        text: "Somethings wents to wrongs, try again..!",
                        icon: "error",
                        button: "okay",
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    }).then(function(){
                        window.location.reload();
                    });
                }
            },
        });
    }
	
    function paypalwithdraw_continue(prev_response) { 
        var currency_val=$("#currency_val").val(); 
        stripe.createToken(card,{'currency': currency_val}).then(function(result) {
            
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } 
            else {
                var token=$('#token').val();
                $('#load_div').html('<img src="'+base_url+'assets/img/loader.gif" alt="" />');
                var tokens=token;
                var stripe_amt=$("#wallet_withdraw_amt").val();
               
                var tokenid = result.token.id;
                var data="Token="+tokens+"&amount="+stripe_amt+"&currency_val="+currency_val+"&tokenid="+tokenid+"&csrf_token_name="+csrf_token;
                $.ajax({
                    url: base_url+'api/withdraw-provider',
                    data:data,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(response){            
                        console.log(response);
                        if(response.response.response_code==200 || response.response.response_code=='200'){
                            swal({
                                title: "Wallet Amount Transferred...",
                                text: "Wallet amount was Credit to your card releated by bank ...!",
                                icon: "success",
                                button: "okay",
                                closeOnEsc: false,
                                closeOnClickOutside: false
                            }).then(function(){
                                $("#load_div").hide();
                                window.location.reload();
                           });
                        }else{
                            swal({
                                title: "Wallet Amount Not Succeed...",
                                text: response.response.response_message,
                                icon: "error",
                                button: "okay",
                                closeOnEsc: false,
                                closeOnClickOutside: false
                            }).then(function(){
                                $("#load_div").hide();
                                window.location.reload();
                            });
                        }
                    },
                    error: function(error){
                        console.log(error);
                        swal({
                            title: "Wallet Amount Not Succeed...",
                            text: "Wallet amount was not transferred ...!",
                            icon: "error",
                            button: "okay",
                            closeOnEsc: false,
                            closeOnClickOutside: false
                        }).then(function(){
                            $("#load_div").hide();
                            window.location.reload();
                        });
                    }
                });
            }
        });
    };

    function bank_details(prev_response){ 
        var userId = prev_response.user_id;
        var currency_val=$("#currency_val").val();
        var stripe_amt=$("#wallet_withdraw_amt").val();
        var payment_type =$('input[name="group2"]:checked').val();

        if(userId) {
            var data="user_id="+userId+"&payment_type="+payment_type+"&currency_val="+currency_val+"&amount="+stripe_amt+"&csrf_token_name="+csrf_token;
            $.ajax({
                type:'POST',
                url: base_url+'user/dashboard/bank_details',
                data : data,
                dataType:'json',
                success:function(response) {
                    if(response.status){
                        swal({
                            title:response.msg,
                            text: response.msg,
                            icon: "success",
                            button: "okay",
                            closeOnEsc: false,
                            closeOnClickOutside: false
                        }).then(function(){
                            location.reload();
                        });
                    }else{
                        swal({
                            title: response.msg,
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
        }else {
            swal({
                title: "Somethings wrong !",
                text: "Somethings wents to wrongs, try again..!",
                icon: "error",
                button: "okay",
                closeOnEsc: false,
                closeOnClickOutside: false
            }).then(function(){
                window.location.reload();
            });
        }
    }
	
	function razorpay_details(prev_response){
        var userId = prev_response.user_id;
        var currency_val=$("#currency_val").val();
        var stripe_amt=$("#wallet_withdraw_amt").val();
        var payment_type =$('input[name="group2"]:checked').val();

        if(userId) {
            var data="user_id="+userId+"&payment_type="+payment_type+"&currency_val="+currency_val+"&amount="+stripe_amt+"&csrf_token_name="+csrf_token;
            $.ajax({
                type:'POST',
                url: base_url+'user/dashboard/razorpay_details',
                data : data,
                dataType:'json',
                success:function(response) {                
                    if(response.status){
                        swal({
                            title:response.msg,
                            text: response.msg,
                            icon: "success",
                            button: "okay",
                            closeOnEsc: false,
                            closeOnClickOutside: false
                        }).then(function(){
                            location.reload();
                        });
                    }else{
                        swal({
                            title: response.msg,
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

    function paypal_details(prev_response){
        var userId = prev_response.user_id;
        var currency_val=$("#currency_val").val();
        var stripe_amt=$("#wallet_withdraw_amt").val();
        var payment_type =$('input[name="group2"]:checked').val();

        if(userId) {
            var data="user_id="+userId+"&payment_type="+payment_type+"&currency_val="+currency_val+"&amount="+stripe_amt+"&csrf_token_name="+csrf_token;
            $.ajax({
                type:'POST',
                url: base_url+'user/dashboard/razorpay_details',
                data : data,
                dataType:'json',
                success:function(response) {                
                    if(response.status){
                        swal({
                            title:response.msg,
                            text: response.msg,
                            icon: "success",
                            button: "okay",
                            closeOnEsc: false,
                            closeOnClickOutside: false
                        }).then(function(){
                            location.reload();
                        });
                    }else{
                        swal({
                            title: response.msg,
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

	$('#cancel_card_btn').on('click', function() {
		$("#card_form_div").hide();
		$("#check_wallet_div").show();
   });

    $('.withdraw_verify').on('click', function(){ 
        var trans_id = $(this).attr('data-id');
        var amount = $(this).attr('data-amount');
        swal({
          title: "Are you sure want to change the status?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                var url = base_url + 'user/dashboard/withdraw_amount_verify';
                var data = { 
                    trans_id: trans_id,
                    amount: amount,
                    csrf_token_name:csrf_token
                };
                $.ajax({
                    url: url,
                    data: data,
                    type: "POST",
                    dataType: 'json',
                    success: function (response) { 

                        if(response=='3') { // session expiry
                      swal({
                        title: "Session was Expired... !",
                        text: "Session Was Expired ..",
                        icon: "error",
                        button: "okay",
                        closeOnEsc: false,
                        closeOnClickOutside: false
                      }).then(function(){
                        window.location.reload();
                      });
                    }

                    if(response=='2'){ //not updated
                            swal({
                                title: "Somethings wrong !",
                                text: "Somethings wents to wrongs",
                                icon: "error",
                                button: "okay",
                                closeOnEsc: false,
                                closeOnClickOutside: false
                            }).then(function(){
                                window.location.reload();
                            });
                        }
                                    
                        if(response=='1'){ //updated
                            swal({
                                title: "Paid Success",
                                text: "Paid successfully...",
                                icon: "success",
                                button: "okay",
                                closeOnEsc: false,
                                closeOnClickOutside: false
                            }).then(function(){
                                window.location.reload();   
                            });
                        }                          
                    }
                });
            } else {
                return false;
            }
        });
    });
  
})(jQuery);