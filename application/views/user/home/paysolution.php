  <html>
	<head>
		<title>Subscription</title>
	</head>
	<?php if($paymentdata['paytype'] == 'wallet') { 
			$paytype = 'wallet';
	 	} else { 
	 		$paytype = 'subscription'; 
	 	} ?>
	<body bgcolor="#FFFFFF" text="#000000">
		<form method="post" action="https://www.thaiepay.com/epaylink/payment.aspx?lang=en" id="paysolution_subscription">
			<input type="hidden" name="payso" value="payso" />
			<input type="hidden" name="refno" value="<?php echo rand(1000000000, 9999999999); ?>">">
			<input type="hidden" name="merchantid" value="<?php echo settingValue('paysolution_merchant_id'); ?>">
			<input type="hidden" name="customeremail" value="<?php echo $paymentdata['customeremail']; ?>">
			<input type="hidden" name="productdetail" value="<?php echo $paymentdata['productdetail']; ?>">
			<input type="hidden" name="total" value="<?php echo $paymentdata['total']; ?>">
		</form>
	</body>
</html>

<script type="text/javascript">
	$('#paysolution_subscription').submit();
</script>