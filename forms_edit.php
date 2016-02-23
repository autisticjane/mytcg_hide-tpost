<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") {
	header("Location:login.php");
}
include("mytcg/settings.php");
include("$header");

if(!$_SERVER['QUERY_STRING']) {
	$select=mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
	while($row=mysql_fetch_assoc($select)) {
		?>
		<h1>Edit Your Information</h1>
		Use this form to edit your information in the database. <b>You cannot use this form to change your password.</b> To change it, please click <a href="changepass.php">here</a>.
		<br /><br />
		<form method="post" action="forms_edit.php?edited">
		<input type="hidden" name="id" value="<?php echo $row[id]; ?>" />
		<table>
		<tr><td><b>Name:</b></td><td><?php echo $row[name]; ?></td></tr>
		<tr><td><b>Email:</b></td><td><input type="text" name="email" value="<?php echo $row[email]; ?>" /></td></tr>
		<tr><td><b>URL:</b></td><td><input type="text" name="url" value="<?php echo $row[url]; ?>" /></td></tr>
		<tr><td><b>Birthday:</b></td><td><select name="birthday">
		<option value="<?php echo $row[birthday]; ?>">Current: <?php echo $row[birthday]; ?></option>
		<option value="Jan">Jan.</option>
		<option value="Feb">Feb.</option>
		<option value="Mar">Mar.</option>
		<option value="Apr">Apr.</option>
		<option value="May">May</option>
		<option value="Jun">June</option>
		<option value="Jul">July</option>
		<option value="Aug">Aug.</option>
		<option value="Sep">Sept.</option>
		<option value="Oct">Oct.</option>
		<option value="Nov">Nov.</option>
		<option value="Dec">Dec.</option>
		</select></td></tr>
		<tr><td><b>Collecting:</b></td><td><select name="collecting">
		<option value="<?php echo $row[collecting]; ?>">Current: <?php echo $row[collecting]; ?></option>
		<?php
		$query_collect = "SELECT * FROM `$table_cards` ORDER BY `description` ASC";
		$result_collect = mysql_query($query_collect);
		while($row_collect=mysql_fetch_assoc($result_collect)) {
			echo "<option value=\"$row_collect[filename]\">$row_collect[description] ($row_collect[filename])</option>\n";
		}
		?>
		</select></td></tr>
		<tr><td><b>Status:</b></td><td><select name="status">
		<option value="<?php echo $row[status]; ?>">Current: <?php echo $row[status]; ?></option>
		<option value="Hiatus">Hiatus</option>
		</select></td></tr>
		<tr><td valign="top"><b>Wishlist:</b></td><td><textarea name="wishlist" rows="5" cols="40"><?php echo $row[wishlist]; ?></textarea></td></tr>
		<tr><td valign="top"><b>Short Biography:</b></td><td><textarea name="biography" rows="5" cols="40"><?php echo $row[biography]; ?></textarea></td></tr>
		<tr><td valign="top"><b>Show trade post form?</b></td><td><select name="tpost">
		<option value="<?php echo $row[tpost]; ?>">Current: <?php echo $row[tpost]; ?></option>
		<option value="No">No</option>
		<option value="Yes">Yes</option>
		</select></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" name="submit" value=" Edit! " /></td></tr>
		</table>
		</form>
		<?php
	}
}

elseif($_SERVER['QUERY_STRING']=="edited") {
	if (!isset($_POST['submit']) || $_SERVER['REQUEST_METHOD'] != "POST") {
	    exit("<p>You did not press the submit button; this page should not be accessed directly.</p>");
	}
	else {
	    $exploits = "/(content-type|bcc:|cc:|document.cookie|onclick|onload|javascript|alert)/i";
	    $profanity = "/(beastial|bestial|blowjob|clit|cum|cunilingus|cunillingus|cunnilingus|cunt|ejaculate|fag|felatio|fellatio|fuck|fuk|fuks|gangbang|gangbanged|gangbangs|hotsex|jism|jiz|kock|kondum|kum|kunilingus|orgasim|orgasims|orgasm|orgasms|phonesex|phuk|phuq|porn|pussies|pussy|spunk|xxx)/i";
	    $spamwords = "/(viagra|phentermine|tramadol|adipex|advai|alprazolam|ambien|ambian|amoxicillin|antivert|blackjack|backgammon|texas|holdem|poker|carisoprodol|ciara|ciprofloxacin|debt|dating|porn)/i";
	    $bots = "/(Indy|Blaiz|Java|libwww-perl|Python|OutfoxBot|User-Agent|PycURL|AlphaServer)/i";

	    if (preg_match($bots, $_SERVER['HTTP_USER_AGENT'])) {
	        exit("<h1>Error</h1>\nKnown spam bots are not allowed.");
	    }
	    foreach ($_POST as $key => $value) {
	        $value = trim($value);

	        if (empty($value)) {
	            exit("<h1>Error</h1>\nAll fields are required. Please go back and complete the form.");
	        }
	        elseif (preg_match($exploits, $value)) {
	            exit("<h1>Error</h1>\nExploits/malicious scripting attributes aren't allowed.");
	        }
	        elseif (preg_match($profanity, $value) || preg_match($spamwords, $value)) {
	            exit("<h1>Error</h1>\nThat kind of language is not allowed through this form.");
	        }

	        $_POST[$key] = stripslashes(strip_tags($value));
	    }
	    
	    $id = escape_sql(CleanUp($_POST['id']));
		$email = escape_sql(CleanUp($_POST['email']));
		$url = escape_sql(CleanUp($_POST['url']));
		$birthday = escape_sql(CleanUp($_POST['birthday']));
		$status = escape_sql(CleanUp($_POST['status']));
		$collecting = escape_sql(CleanUp($_POST['collecting']));
		$wishlist = escape_sql(CleanUp($_POST['wishlist']));
		$biography = escape_sql(CleanUp($_POST['biography']));
		tpost = escape_sql(CleanUp($_POST['tpost']));
	
		$update = "UPDATE `$table_members` SET email='$email', url='$url', birthday='$birthday', status='$status', collecting='$collecting', wishlist='$wishlist', biography='$biography', tpost='$tpost' WHERE id='$id'";

	    if (mysql_query($update, $connect)) {
	        echo "<h1>Success</h1>\n";
	        echo "You have successfully updated your info.";
	    }
	    else {
	    	echo "<h1>Error</h1>\n";
	        echo "Sorry, there was an error and your info was not updated.<br />\n";
	        die("Error:". mysql_error());
	    }
	}
}

include('footer.php'); ?>
