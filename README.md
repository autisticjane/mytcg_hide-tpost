# mytcg_hide-tpost
Allow members to hide the trade post form from their TCG profile.

This is in development.

## Requirements
- MyTCG

## Notes
Make sure you back up your files/database before proceeding. I am not responsible for a broken database or malfunctioning files. However, if you have issues, I will try to help you as best I can.

## Install
Upload `mytcg/create_tpost.php`.

### Automatic
Upload the files outside the `mytcg` directory to your TCG directory.

### Manual
#### forms_edit.php

#### profile.php
Add the following in place of the current location of your tradepost:
```<?php if($row[tradeform]=="no") {
			echo ""; }
		else {
	?>
	<h2>Trade</h2>
	<form method="post" action="email.php?id=<?php echo "$id"; ?>">
	<input type="hidden" name="id" value="<?php echo "$row[id]"; ?>" />
	<table width="100%" class="wildthing" align="center">
	<tr><td>Name:</td><td><input type="text" name="name" value="" /></td></tr>
	<tr><td>Email:</td><td><input type="text" name="email" value="" /></td></tr>
	<tr><td>Trade Post:</td><td><input type="text" name="url" value="http://" /></td></tr>
	<tr><td>You Give:</td><td><input type="text" name="giving" value="" /></td></tr>
	<tr><td>You Want:</td><td><input type="text" name="for" value="" /></td></tr>
	<tr><td>Member Cards:</td><td><input type="radio" name="member" value="yes" /> Yes <input type="radio" name="member" value="no"> No</td></tr>
	<tr><td>&nbsp;</td><td><input type="submit" name="submit" value=" Trade! " /></td></tr>
	</table>
	</form>
<?php } ?>```
