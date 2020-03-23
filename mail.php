<?php

die("Page is disabled to prevent spam.");

$to = 'rodica.pamfil@gmail.com';

// Subject
$subject = 'Special Message for Ana';

// Message
$message = '
<html>
<head>
  <title>Special Message for Ana</title>
</head>
<body>

	<p>I don\'t know what to write here... I just configured this shiz and i wanted to send you a message :)))</p>

	<p>take care,</p>
	<p>bubu</p>

	<hr>

	<p>"Automated" message sent using PHP and Postfix relayed through Gmail</p>

</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'From: Portal LTPM <ltpm.automated@gmail.com>';
$headers[] = 'Cc: Laur <laurcons@outlook.com>';

// Mail it
mail($to, $subject, $message, implode("\r\n", $headers));