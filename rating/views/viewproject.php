	<link rel="stylesheet" href="./css/signin.css">
	<style>
		body {
			background-color: #FFFFFF;
			padding: 50px 0 0;
		}
		
		table,th, td {
			padding:5px 10px 5px 10px;
		}
		
		.toolbar {
			padding: 20px 0;
		}
		
		.editbtn {
			margin: 0 10px 0 0;
		}
	</style>
	
	<script type="text/javascript" src="js/digitalgood.js"></script>
	<script>
	//<![CDATA[
		function showPayPalFrameCode(trackID, index)
		{
			var paymentCode = "<form action='<?php echo $currentURL."checkout.php" ?>' METHOD='POST'>"
				+"<input type='image' name='paypal_submit' id='paypal_submit" + index + "'  src='https://www.paypal.com/en_US/i/btn/btn_dg_pay_w_paypal.gif' border='0' align='top' alt='Pay with PayPal'/>"
				+"<input type='hidden' name='trackID' value='" + trackID + "'/>"
			+"</form>"
			+"<script src='https://www.paypalobjects.com/js/external/dg.js' type='text/javascript'></scr" + "ipt>"
			+"<script>"
			+"	var dg = new PAYPAL.apps.DGFlow("
			+"	{"
			+"		trigger: 'paypal_submit" + index + "',"
			+"		expType: 'instant'"
			+"	});"
			+"</scr" + "ipt>"; //solve html keyworks problem
			
			showPopupMsg(paymentCode);
		}
		
		function gotoNewProjectPage()
		{
			document.location.href = "<?php echo $currentURL."ratemanager.php?action=createnew" ?>";
		}
		
		function editProduct(itemid)
		{
			document.location.href = "<?php echo $currentURL."DigitalGoodsAdmin.php?action=edit&itemid=" ?>" + itemid;
		}
		
		function getCode(productid)
		{
			$.ajax({
				url: 'RateManager.php',
				type: 'POST',
				dataType: "json",
				data: {
					action: 'getitems',
					projectid: productid
				},
				success: function(data) {
					alert(data);
				}
			});
		}
	//]]>
	</script>
	
<div id="wrap">
	<div class="container">
		<div class="toolbar">
			<button class="btn btn-primary" onclick="gotoNewProjectPage()">Add New Project</button>
		</div>
		
		<table style="border-collapse:collapse; "  class="table table-striped">
			<tr>
				<td width="50">NO.</td>
				<td>Name</td>
				<td width="50">Description</td>
				<td>Operation</td>
			</tr>
			<?php
			foreach($projectList as $index => $projectdto)
			{
				echo "<tr>
				<td>".($index + 1)."</td>
				<td>". $projectdto->name ."</td>
				<td>". $projectdto->description ."</td>
				<td>      <button class=\"btn btn-default editbtn\" onclick=\"getCode('". $projectdto->id ."')\">Get Code</button><button class=\"btn btn-default editbtn\" onclick=\"editProduct('". $projectdto->id ."')\">Show Result</button><button class=\"btn btn-default\" onclick=\"editProduct('". $projectdto->id ."')\">Edit</button></td>
				</tr>";
			}
			?>
		</table>
	</div>
</div>