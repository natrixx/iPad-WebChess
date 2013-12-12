
	<?php
	// $Id: index.php,v 1.10 2010/08/18 09:37:26 sandking Exp $

/*
    This file is part of WebChess. http://webchess.sourceforge.net
	Copyright 2010 Jonathan Evraire, Rodrigo Flores

    WebChess is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WebChess is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WebChess.  If not, see <http://www.gnu.org/licenses/>.
*/

	/* load settings */
	if (!isset($_CONFIG))
		require 'config.php';

        require_once "lang.php";
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" href="userlogin.css" type="text/css" />
<script type="text/javascript" src="javascript/cookies.js"></script>
<title>iPad WebChess :: <?php echo gettext("Login");?></title>
<script language="javascript" type="text/javascript">
var visitordata = null;
var cookieDomain = null;
function storeLogin()
{
	if(document.loginForm.remember.checked)
	{
		visitordata.nick = document.loginForm.txtNick.value;
		visitordata.pwd = document.loginForm.pwdPassword.value;
		visitordata.store();
	}
}
window.onload = function()
{
	document.loginForm.onclick = function(){storeLogin();};

	cookieDomain = document.domain;
	var idx = cookieDomain.lastIndexOf('.');
	idx = cookieDomain.lastIndexOf('.', idx-1);
	if(idx == -1)
		cookieDomain = '.' + cookieDomain;
	else
		cookieDomain = cookieDomain.substr(idx);
	visitordata = new Cookie(document, "WebChess", 2400, '/', cookieDomain);
	if(visitordata.load())
	{
		if(visitordata.nick)
			document.loginForm.txtNick.value = visitordata.nick;
		if(visitordata.pwd)
			document.loginForm.pwdPassword.value = visitordata.pwd;
		document.loginForm.remember.checked = true;
	}
	document.loginForm.txtNick.focus();
	document.loginForm.txtNick.select();
}
</script>
</head>
<body>
<div id="header">
  <div id="heading">iPad WebChess :: <?php echo gettext("Login");?></div>
</div>

<div id="ctr" align="center">
	<div class="login">
		<div class="login-form">
			<form name="loginForm" id="loginForm" method="post" action="mainmenu.php">
				<div class="form-block">
                                        <div class="inputlabel"><?php echo gettext("Username:");?></div>
					<div><input id="txtNick" name="txtNick" type="text" class="inputbox" size="30" /></div>
                                        <div class="inputlabel"><?php echo gettext("Password:");?></div>
					<div><input id="pwdPassword" name="pwdPassword" type="password" class="inputbox" size="30" /></div>
					
					<input name="ToDo" value="Login" type="hidden" />
					<div class="LoginButtons">
						<input type="submit" name="login" class="button" value="<?php echo gettext("Login");?>" />
				<?php
				if($CFG_NEW_USERS_ALLOWED==true)
				{
				?>
                                <input name="newAccount" class="button" value="<?php echo gettext("Register");?>" type="button" onClick="window.open('newuser.php', '_self')" />
				<?php
				}
				?>
					</div>
				</div>
			</form>
		</div>
		<div class="clr"></div>
	</div>
</div>
<div id="break"></div>
<noscript>
!Warning! Javascript must be enabled for proper operation of WebChess
</noscript>
</body>
</html>
