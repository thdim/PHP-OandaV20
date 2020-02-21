# PHP-OandaV20
PHP Wrapper for Oanda v20 REST API

Usage:

```php
$api = new OandaV20(true, '<your-token>'); // true = production, false = practice
      
$account = $api->getAccounts();
echo '<pre>';
var_dump($account);
echo '</pre>';
```
