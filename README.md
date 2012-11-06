Copyright (C) 2011 by Kris

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

About
	Bitcoin subscription via walletbit.com for WHMCS.

Version 0.1
	Currency convert between all currencies automatically.
	Fetches current exchange rate from WalletBit.
	
System Requirements:
	WalletBit.com account
	WHMCS
	PHP 5+
	Curl PHP Extension
  
Configuration Instructions:
	1. Upload files to your WHMCS installation.
	2. Go to your WHMCS administration. Payment Gateways -> "WalletBit Subscription" click [Activate]
	3. In WalletBit.com IPN Handler URL (https://walletbit.com/businesstools#manageIPNhandler) Enter the link to your callback of WalletBit WHMCS Payment Module. (http://YOUR_WHMCS_URL/modules/gateways/callback/walletbitsubscription.php)
	4. Enter a strong Security Word in WalletBit Manage IPN.
	5. In module settings "Merchant Email" <- set your WalletBit.com email.
	6. In module settings "Token" <- copy from WalletBit.com (https://walletbit.com/businesstools#manageIPNhandler) "Token"
	7. In module settings "Security Word" <- Enter your Security Word.