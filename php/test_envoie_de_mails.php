<?php
if(isset($_POST['mailform'])){

$header="MIME-Version: 1.0\r\n";
$header.='From:"Benjamin"<mail@domail>'."\n";
$header.='Content-Type:text/html; charset="uft-8"'."\n";
$header.='Content-Transfer-Encoding: 8bit';

$message='
<html>
	<body>
		<div align="center">
			<br />
			J\'ai envoyé ce mail avec PHP !
			<br />
		</div>
	</body>
</html>
';

mail("mail@domail", "Salut tout le monde !", $message, $header);
}
?>
<form method="POST" action="">
	<input type="submit" value="Recevoir un mail !" name="mailform"/>
</form>
