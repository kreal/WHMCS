<?php

# Required File Includes
include("../../../dbconnect.php");
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

$gatewaymodule = "walletbitsubscription"; # Enter your gateway module name here replacing template

$gateway = getGatewayVariables($gatewaymodule);
if (!$gateway["type"]) die("Module Not Activated"); # Checks gateway module is active before accepting callback

$str =
$_POST["merchant"].":".
$_POST["customer_email"].":".
$_POST["amount"].":".
$_POST["batchnumber"].":".
$_POST["txid"].":".
$_POST["address"].":".
$gateway["securityword"];

$hash = strtoupper(hash('sha256', $str));

// proccessing subscription only if hash is valid
if ($_POST["merchant"] == $gateway["merchant"] && $_POST["encrypted"] == $hash && $_POST["status"] == 1)
{
	print '1';

	$invoiceid = checkCbInvoiceID($_POST["invoice"], $gateway["name"]); # Checks invoice ID is a valid invoice number or ends processing
	
	addInvoicePayment($invoiceid, $_POST["txid"], $_POST["amount"], 0, $gatewaymodule); # Apply Payment to Invoice: invoiceid, transactionid, amount paid, fees, modulename
	logTransaction($gateway["name"], $_POST, 'Successful'); # Save to Gateway Log: name, data array, status
}
else
{
	logTransaction($gateway["name"], $_POST, 'Unsuccessful'); # Save to Gateway Log: name, data array, status
}

?>