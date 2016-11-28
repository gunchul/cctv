<?php
$param_type=$_POST["type"];
$param_silen_type=$_POST["siren_type"];
$param_speech_message=$_POST["speech_message"];

if (strlen($param_silen_type)>0)
{
	$command = sprintf("sudo script/play.sh '%s'", $param_silen_type);
    shell_exec($command);
}

if ($param_type == "email_ENABLE")
{
	$f = fopen("status/email_notification.txt", "w");
    fwrite($f, "1", 1);
    fclose($f);
}
else if ($param_type == "email_DISABLE")
{
	$f = fopen("status/email_notification.txt", "w");
    fwrite($f, "0", 1);
    fclose($f);
}
else if ($param_type == "sms_ENABLE")
{
	$f = fopen("status/sms_notification.txt", "w");
    fwrite($f, "1", 1);
    fclose($f);
}
else if ($param_type == "sms_DISABLE")
{
	$f = fopen("status/sms_notification.txt", "w");
    fwrite($f, "0", 1);
    fclose($f);
}

if ( strlen($param_speech_message) > 0 )
{
    $cmdstring = sprintf("sudo script/speech.sh '%s'", urlencode($param_speech_message));
    $command = escapeshellcmd($cmdstring);
    shell_exec($command);
}

$f = fopen("status/email_notification.txt", "r");
$email_notification = fread($f, 1);
fclose($f);

if ($email_notification == "0") {
    $email_status = "Disabled";
    $email_button_value = "ENABLE";
}
else {
	$email_status = "Enabled";
	$email_button_value = "DISABLE";
}

$f = fopen("status/sms_notification.txt", "r");
$sms_notification = fread($f, 1);
fclose($f);

if ($sms_notification == "0") {
    $sms_status = "Disabled";
    $sms_button_value = "ENABLE";
}
else {
	$sms_status = "Enabled";
	$sms_button_value = "DISABLE";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CCTV</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/script.js"></script>
</head>

<body onload="setTimeout('init(0,25,1);', 100);">
<div class="container">
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#notification">Notification</a></li>
	  <li><a data-toggle="tab" href="#menu1">Message</a></li>
	  <li><a data-toggle="tab" href="#menu2">Camera</a></li>
	</ul>

	<div class="tab-content">
	  <div id="notification" class="tab-pane fade in active">
	    <form action="index.php" method="post">
	    <h4>EMAIL: <span class="badge"><?php echo $email_status?></span></h3>
			<button class="btn btn-primary btn-block" type="submit" name="type" value=email_<?php echo $email_button_value?>><?php echo $email_button_value?></button>
		<h4>SMS: <span class="badge"><?php echo $sms_status?></span></h3>
			<button class="btn btn-primary btn-block" type="submit" name="type" value=sms_<?php echo $sms_button_value?>><?php echo $sms_button_value?></button>
		</form>
	  </div>
	  <div id="menu1" class="tab-pane fade">
		<form action="index.php" method="post">
			<h4>Speech Message:</h4>
		    <input id="msg" type="text" class="form-control" name="speech_message" placeholder="input message" required />
		    <br>
            <button type="submit" name="type" value="speech" class="btn btn-primary btn-block">SPEECH</button>
		</form>
            <hr>
		<form action="index.php" method="post">
            <button class="btn btn-info btn-block" type="submit" name="siren_type" value="siren_1.mp3">SIREN 1</button>
		    <button class="btn btn-info btn-block" type="submit" name="siren_type" value="siren_2.mp3">SIREN 2</button>
		    <button class="btn btn-info btn-block" type="submit" name="siren_type" value="siren_3.mp3">SIREN 3</button>
        </form>
	  </div>
	  <div id="menu2" class="tab-pane fade"> 
	    <br>
		<center>
		  <div><img id="mjpeg_dest" width="320"/></div>
		</center>
	  </div>
	</div>
</div>
</body>
</html>
