	<link rel="stylesheet" href="./css/signin.css">
	<style>
		body
		{
			background-color: #FFFFFF;
			padding: 50px 0 0;
		}
		
		form#addProductForm dt
		{
			width: 200px;
			border-right-width: 0;
			float: left;
		}
		
		form#addProductForm dd
		{
			margin: 0 0 0 210px;
		}
		
		.submitbtn
		{
			margin: 0 10px 0 0;
		}
	</style>
	<script>
		function cancelEdition()
		{
			document.getElementById("addProductForm").action.value = null;
		}
		
		function addMore()
		{
			var dlList = $( "dl.rateitemfield" );
			var projfield = document.getElementById("projfield");
			var beforeChild = document.getElementById("beforediv");
			var newChildNum = 1 + dlList.length;
			var newChild = document.createElement ("dl");
			newChild.id = 'rateitemfield-' + newChildNum;
			newChild.className = "rateitemfield";
			newChild.innerHTML = "<dt><label for=\"rateitem\">Rating Item:</label></dt>"
								+ "<dd><input type=\"text\" name=\"rateitem[]\" id=\"rateitem[]\" size=\"50\"/>"
								+ "<a href=\"#\" class=\"glyphicon glyphicon-remove\" onclick=\"deleteMore('"+ newChild.id +"')\">Delete</a>"
								+ "</dd>";
			projfield.insertBefore(newChild, beforeChild);
		}
		
		function deleteMore(fieldID)
		{
			var projfield = document.getElementById("projfield");
			var deleteField = document.getElementById(fieldID);
			projfield.removeChild(deleteField);
		}
	</script>
	
<div id="wrap">
	<div class="container">
	
	
	
	
	<form id="addProductForm" action="<?php echo $currentURL . "RateManager.php"?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="<?php
				if(!empty($nextAction))
				{
					echo $nextAction;
				}
				else
				{
					echo "add";
				}
			?>"/>
		<?php
			if(!empty($rateProject))
			{
				echo "<input type=\"hidden\" name=\"itemid\" value=\"".$rateProject->projectid."\"/>";
			}
		?>
		<fieldset id="projfield">
			<dl>
				<dt><label for="projname">Project Name:</label></dt>
				<dd><input type="text" name="projname" id="projname" size="50" value="<?php
						if(!empty($rateProject))
						{
							echo $rateProject->projectName;
						}
					?>"/></dd>
			</dl>
			
			<dl>
				<dt><label for="projdesc">Project Description:</label></dt>
				<dd><input type="text" name="projdesc" id="projdesc" size="50" value="<?php
						if(!empty($rateProject))
						{
							echo $rateProject->projectName;
						}
					?>"/></dd>
			</dl>
			
			<dl class="rateitemfield">
				<dt><label for="rateitem">Rating Item:</label></dt>
				<dd><input type="text" name="rateitem[]" id="rateitem[]" size="50" value="<?php
						if(!empty($dg))
						{
							echo $dg->price;
						}
					?>"/></dd>
			</dl>

			<dl id="beforediv">
				<dt></dt>
				<dd><a href="#" class="btn btn-default" onclick="addMore()">Add More Ratings Items</a></dd>
			</dl>
			
			<dl>
				<dt></dt>
				<dd><input class="btn btn-primary submitbtn" type="submit" name="submit" value="Submit"/><button class="btn btn-default" onclick="cancelEdition()">Cancel</button></dd>
			</dl>
		</fieldset>
	</form>
	
	
</div>
</div>