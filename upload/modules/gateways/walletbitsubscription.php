<?php
	function walletbitsubscription_config()
	{
		$configarray = array(
			"FriendlyName" => array("Type" => "System", "Value" => "WalletBit Subscription"),
			"merchant" => array("FriendlyName" => "Merchant Email", "Type" => "text", "Size" => "35", ),
			"token" => array("FriendlyName" => "Token", "Type" => "text", "Size" => "35", ),
			"securityword" => array("FriendlyName" => "Security Word", "Type" => "text", "Size" => "20", ),
			"adjustable" => array("FriendlyName" => "Adjustable-rate", "Type" => "yesno", "Description" => "Adjust amount based on average bitcoin price in USD.", ),
			"testmode" => array("FriendlyName" => "Test Mode", "Type" => "yesno", "Description" => "Sandbox mode (tests)", ),
		);
		return $configarray;
	}

	function walletbitsubscription_link($params)
	{
		$invoiceid = $params['invoiceid'];
		$getRecurringBillingValues = getRecurringBillingValues($invoiceid);

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, 'https://walletbit.com/btcusd');
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
		$ticker = curl_exec($ch);
		curl_close($ch);

		$amount = $params["amount"];

		if ($params['currency'] != 'USD')
		{
			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, 'http://www.google.com/ig/calculator?hl=en&q=' . $amount . $params['currency'] . '=?USD');
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			$rawdata = curl_exec($ch);
			curl_close($ch);

			$data = explode('"', $rawdata);
			$data = explode(' ', $data['3']);
			$var = $data['0'];

			$new_string = preg_replace("/[^0-9,.]/", "", $var);

			$amount = round($new_string, 3);
		}

		$amount = round($amount / $ticker, 8);

		$additional = 'invoiceid=' . $invoiceid;

		$code = '<form method="post" action="https://walletbit.com/checkout/subscribe">
<input type="hidden" name="token" value="' . $params["token"] . '" />
<input type="hidden" name="item_name" value="' . $params["description"] . '" />
<input type="hidden" name="amount" value="' . $amount . '" />
<input type="hidden" name="period" value="' . $getRecurringBillingValues['recurringcycleperiod'] . '" />
<input type="hidden" name="cycle" value="' . strtoupper(substr($getRecurringBillingValues['recurringcycleunits'], 0, 1)) . '" />
<input type="hidden" name="adjustable" value="' . ($params['adjustable'] == 'on' ? 1 : 0) . '" />
<input type="hidden" name="returnurl" value="' . $params['systemurl'] . '" />
<input type="hidden" name="additional" value="' . $additional . '" />
<input type="hidden" name="test" value="' . ($params['testmode'] == 'on' ? 1 : 0) . '" />
<input type="image" id="walletbitsubscribe" src="https://walletbit.com/includes/walletbit.png" name="submit" alt="WalletBit - Simple, Flexible & Secure Bitcoin" title="WalletBit - Simple, Flexible & Secure Bitcoin" border="0" />
</form>';

		return $code;
	}
?>