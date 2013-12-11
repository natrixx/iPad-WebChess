<?php
	// $Id: newuser.php,v 1.8 2010/08/15 07:54:46 sandking Exp $

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

	session_start();

	/* load settings */
	if (!isset($_CONFIG))
		require 'config.php';

	if (!isset($_CHESSUTILS))
		require 'chessutils.php';

        require "lang.php";

	fixOldPHPVersions();
	if ($CFG_NEW_USERS_ALLOWED==false)
	{
		die(gettext("Not Authorized!"));
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" href="userlogin.css" type="text/css" />
<script type="text/javascript" src="javascript/cookies.js"></script>
<title><?php echo gettext("WebChess") . " :: " . gettext("Create New User"); ?></title>

	<script type="text/javascript">
		function validateForm()
		{
			/* ToDo: figure out how to check for whitespace only nicks */
			if (document.userdata.txtFirstName.value == ""
				|| document.userdata.txtLastName.value == ""
				|| document.userdata.txtNick.value == ""
				|| document.userdata.pwdPassword.value == "")
			{
                                alert("<?php echo gettext("Sorry, all personal info fields are required and must be filled out.");?>");
				return;
			}

			if (document.userdata.pwdPassword.value == document.userdata.pwdPassword2.value)
				document.userdata.submit();
			else
                                alert("<?php echo gettext("Sorry, the two password fields dont match. Please try again.");?>");
		}
	</script>
</head>

<body>
<div id="header">
  <div id="heading"><?php echo gettext("WebChess") . " :: " . gettext("Create New User");?></div>
</div>
<div id="ctr" align="center">
	<div class="preferences">
		<div class="preferences-form">
			<form name="userdata" method="post" action="mainmenu.php">
				<div class="form-block">
                                        <h1><?php echo gettext("Personal information");?></h1>
                                        <div class="inputlabel"><?php echo gettext("First Name:");?></div>
					<div><input name="txtFirstName" type="text" class="inputboxes" value="<?php echo($_POST['txtFirstName']); ?>" /></div>
                                        <div class="inputlabel"><?php echo gettext("Last Name:");?></div>
					<div><input name="txtLastName" type="text" class="inputboxes" value="<?php echo($_POST['txtLastName']); ?>" /></div>
                                        <div class="inputlabel"><?php echo gettext("Nick:");?></div>
					<div>
						<input name="txtNick" type="text" class="inputboxes" />
						<?php
							/* this var is set to true in mainmenu.php */
							if ($tmpNewUser)
								echo("<div class=\"warning\">Sorry, the nick you have chosen (".$_POST['txtNick'].") is already in use.  Please try another.</div>");
						?>
					</div>
                                        <div class="inputlabel"><?php echo gettext("Password:");?></div>
					<div><input name="pwdPassword" type="password" class="inputboxes" /></div>
                                        <div class="inputlabel"><?php echo gettext("Password Confirmation:");?></div>
					<div><input name="pwdPassword2" type="password" class="inputboxes" /></div>
                                        <h1><?php echo gettext("Personal preferences");?></h1>
                                        
					<div class="inputboxRadioLeft">
										<div class="inputlabel"><?php echo gettext("History:");?></div>
                                            <div>

                                                <input type="radio" id="history1" name="rdoHistory" value="pgn" checked><label for="history1">PGN</label>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="history2" name="rdoHistory" value="verbous"><label for="history2">Verbose</label>
					</div>
					</div>

					<div class="inputboxRadioMiddle">
						            <div class="inputlabel"><?php echo gettext("History Layout:");?></div>
                                        <div>
                                                <input type="radio" id="history3" name="rdoHistorylayout" value="columns" checked><label for="history3">Columns</label>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="history4" name="rdoHistorylayout" value="paragraph"><label for="history4">Paragraph</label>
											</div>
					</div>
					<div class="inputboxRadioRight">
                                        <div class="inputlabel"><?php echo gettext("Theme:");?></div>
											<div>
                                                <input type="radio" id="theme1" name="rdoTheme" value="beholder" checked><label for="theme1">Beholder</label>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="theme2" name="rdoTheme" value="plain"><label for="theme2">Plain</label>
											</div>
					</div>
                                        <div class="inputlabel"><?php echo gettext("Auto-reload:") . " (" . gettext("min:") . ($CFG_MINAUTORELOAD) . " " . gettext("secs") . ")";?></div>
					<br><div><input type="text" class="inputboxPrefsReload" name="txtReload" value="<?php echo ($CFG_MINAUTORELOAD); ?>" /></div>
					<br><br><br><?php if ($CFG_USEEMAILNOTIFICATION) { ?>
                                                        <div class="inputlabel"><?php echo gettext("Email notification:");?></div>
							<br><div><input type="text" class="inputboxPrefsEmail" name="txtEmailNotification" value="<?php echo($_POST['txtEmailNotification']); ?>" /></div>
                                                        <br><br><br><div class="instruction"><?php echo gettext("Enter a valid email address if you would like to be notified when your opponent makes a move. Leave blank otherwise.");?></div>
					<?php } ?>

                                        <input name="btnCreate" type="button" class="button" value="<?php echo gettext("Register");?>" onClick="validateForm()" />
                                        <input name="btnCancel" type="button" class="button" value="<?php echo gettext("Cancel");?>" onClick="window.open('index.php', '_self')" />

					<input name="ToDo" value="NewUser" type="hidden" />
				</div>
			</form>
		</div>
		<div class="clr"></div>
	</div>
</div>
<div id="break"></div>
<div class="footer" align="center">
	<div align="center"><?php echo "WebChess " . gettext("Version") . " 1.0.0, " . gettext("last updated") ." ". gettext("August"). " 15, 2010"?></div>
	<div align="center"><a href="http://webchess.sourceforge.net/"><?php echo gettext("WebChess");?></a> <?php echo gettext("is Free Software released under the GNU General Public License (GPL).");?></div>
</div>
</body>
</html>
