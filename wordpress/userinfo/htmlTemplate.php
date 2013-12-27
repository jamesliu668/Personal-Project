<style>
body.noscroll
{
    position: fixed; 
    width: 100%;
}

.userinfo
{
	width: 480px;
	height: 300px;
	background: #ffffff;
	position: absolute;
	z-Index: 100001;
	border: 5px solid #c1d9ff;
	padding: 10px;
}

.userinfo h2
{
	text-align: center;
	font-family: "Open Sans", Arial, sans-serif;
	padding: 10px 0 0;
}

.userinfo-top
{
	width: 100%;
	color: #ff0000;
	padding: 0 0 0 202px;
}

.userinfo input[type="string"],
.userinfo input[type="password"]
{
	width: 230px;
	border: 1px solid #CCCCCC;
	font-size: 14px;
	padding: 6px 9px;
}

.userinfo input[type="string"]:focus,
.userinfo input[type="password"]:focus
{
	border-color: #333333;
}

.field
{
	margin: 10px 0;
}

.userinfo-label
{
	width: 190px;
	float: left;
	text-align: right;
	padding: 5px 10px 0 0;
	font-weight: bold;
	font: 14px "Lucida Grande", Verdana, Arial, sans-serif;
	color: #666666;
}
</style>

<script type="text/javascript" language="javascript">window.onload = popupForm;
var originalClassName;
var maskDiv = null;
var boxContainer = null;
var boxtop = null;
var originalBorderStyle = null;

function popupForm()
{
	var w = window,
	d = document.documentElement,
	g = document.getElementsByTagName('body')[0],
	ww = w.innerWidth || d.clientWidth || g.clientWidth,
	wh = w.innerHeight|| d.clientHeight|| g.clientHeight;

	if(maskDiv == null)
	{
		maskDiv = document.createElement('div');
		maskDiv.id = "maskDiv";
		maskDiv.style.left = '0px';
		maskDiv.style.top = '0px';
		maskDiv.style.width = '100%';
		maskDiv.style.height = wh + "px";
		maskDiv.style.display = 'block';
		maskDiv.style.visibility = 'visible';
		maskDiv.style.backgroundColor="#000000";
		maskDiv.style.opacity = 0.8;
		maskDiv.style.zIndex = 100000;
		maskDiv.style.position = 'absolute';
	}
	document.body.appendChild(maskDiv);
	
	originalClassName = document.body.className;
	document.body.className = originalClassName + ' noscroll';
	
	if(boxContainer == null)
	{
		boxContainer = document.createElement('div');
		boxContainer.className = "userinfo";
		boxContainer.style.left = (ww - 400) / 2 + 'px';
		boxContainer.style.top = (wh - 300) / 2 - 50 + 'px';
		boxContainer.innerHTML = "<h2>Set Email and Password</h3>";
			
		boxtop = document.createElement("div");
		boxtop.className = "userinfo-top";
		boxContainer.appendChild(boxtop);
		boxtop.innerHTML = "&nbsp;";
			
		var boxbody = document.createElement("form");
		boxbody.id = "userinfoForm";
		boxbody.action = "<?php echo curPageURL();?>";
		boxbody.method = "POST";
		boxContainer.appendChild(boxbody);
		
		//add form
		var boxField = document.createElement("div");
		boxField.className = "field";
		boxbody.appendChild(boxField);
		
		var boxLebel = document.createElement("div");
		boxLebel.className = "userinfo-label";
		boxField.appendChild(boxLebel);
		boxLebel.innerHTML = "<label for=\"userinfo_email\">Email Address:</label>";
		
		var boxInput = document.createElement("div");
		boxInput.className = "userinfo-field";
		boxField.appendChild(boxInput);
		boxInput.innerHTML = "<input type=\"string\" name=\"userinfo_email\" id=\"userinfo_email\"/>"
		
		boxField = document.createElement("div");
		boxField.className = "field";
		boxbody.appendChild(boxField);
		
		boxLebel = document.createElement("div");
		boxLebel.className = "userinfo-label";
		boxField.appendChild(boxLebel);
		boxLebel.innerHTML = "<label for=\"userinfo_pass\">New Password:</label>";
		
		boxInput = document.createElement("div");
		boxInput.className = "userinfo-field";
		boxField.appendChild(boxInput);
		boxInput.innerHTML = "<input type=\"password\" name=\"userinfo_pass\" id=\"userinfo_pass\"/>"
		
		boxField = document.createElement("div");
		boxField.className = "field";
		boxbody.appendChild(boxField);
		
		boxLebel = document.createElement("div");
		boxLebel.className = "userinfo-label";
		boxField.appendChild(boxLebel);
		boxLebel.innerHTML = "<label for=\"userinfo_repass\">Repeat New Password:</label>";
		
		boxInput = document.createElement("div");
		boxInput.className = "userinfo-field";
		boxField.appendChild(boxInput);
		boxInput.innerHTML = "<input type=\"password\" name=\"userinfo_repass\" id=\"userinfo_repass\"/>"
		
		boxField = document.createElement("div");
		boxField.className = "field";
		boxbody.appendChild(boxField);
		
		boxLebel = document.createElement("div");
		boxLebel.className = "userinfo-label";
		boxField.appendChild(boxLebel);
		
		boxInput = document.createElement("div");
		boxInput.className = "userinfo-field home-login";
		boxInput.style.padding = 0;
		boxField.appendChild(boxInput);
		boxInput.innerHTML = "<input type=\"hidden\" value=\"<?php echo $securityToken;?>\" name=\"token\"/><input style=\"margin:0;\" type=\"button\" value=\"submit\" class=\"button-primary\"/ onclick=\"submitForm()\">"
			
		var boxfooter = document.createElement("div");
		boxfooter.className = "userinfo-footer";
		boxContainer.appendChild(boxfooter);
    }
	
	document.body.appendChild(boxContainer);}

function submitForm()
{
	if(!String.prototype.trim)
	{
		String.prototype.trim = function()
		{  
			return this.replace(/^\s+|\s+$/g,'');  
		};
	}

	var emailInput = document.getElementById("userinfo_email");
	var passInput = document.getElementById("userinfo_pass");
	var repassInput = document.getElementById("userinfo_repass");
	
	if(originalBorderStyle == null)
	{
		originalBorderStyle = emailInput.style.border;
	}
	
	emailInput.style.border = originalBorderStyle;
	passInput.style.border = originalBorderStyle;
	repassInput.style.border = originalBorderStyle;
	
	var email = emailInput.value.trim();
	var pass = passInput.value.trim();
	var repass = repassInput.value.trim();
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!re.test(email))
	{
		boxtop.innerHTML = "Your email address is invalid!";
		emailInput.style.border = "2px solid #FF0000";
	}
	else if(pass.length < 6)
	{
		boxtop.innerHTML = "Your password is less than 6 characters!";
		passInput.style.border = "2px solid #FF0000";
	}
	else if(repass != pass)
	{
		boxtop.innerHTML = "Your password and re-password doesn't match!";
		passInput.style.border = "2px solid #FF0000";
		repassInput.style.border = "2px solid #FF0000";
	}
	else
	{
		document.getElementById("userinfoForm").submit();
	}
}
</script>