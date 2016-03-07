<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main_content">
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/phpqrcode/qrlib.php');
QRcode::png("something to incode", 'tmp_qr/meh.png', 'QR_ECLEVEL_H', 4, 2 );
?>
<div id="logo">
<img src="system_images/logo.png" alt="ID System Logo"><br />
<form action="search.php" method="GET" style="display:inline">
<input class="input_button" type="submit" value="Search"/>
</form>
<form action="add.php" method="GET" style="display:inline">
<input class="input_button" type="submit"  value="Add Employee"/>
</form>

</div>
</div>
</body>
</html>