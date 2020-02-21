# PHP-OandaV20
PHP Wrapper for Oanda v20 REST API

Usage:

```php
$api = new OandaV20(true, '<your-token>', '<account-id>'); // true = production, false = practice
      
$account = $api->getAccounts();
echo '<pre>';
var_dump($account);
echo '</pre>';

$api->setAccountID('<account-id>'); // AccountID list in getAccounts()

echo '<pre>';
var_dump($api->getAccountSummary());
echo '</pre>';
```
