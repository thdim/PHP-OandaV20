# PHP-OandaV20
PHP Wrapper for Oanda v20 REST API

Usage:

```php
$api = new OandaV20(true, '<your-token>', '<account-id>'); // true = production, false = practice
      
// getAccounts method  
$account = $api->getAccounts();
echo '<pre>';
var_dump($account);
echo '</pre>';

// getAccountSummary method
$api->setAccountID('<account-id>'); // AccountID list in getAccounts()
echo '<pre>';
var_dump($api->getAccountSummary());
echo '</pre>';

// getInstrumentCandles method
$queryArr = array(
  'price' => 'M', // M (midpoint candles) B (bid candles) A (ask candles)
  'granularity' => 'D', // S5 S10 S15 S30 (seconds) M1 M2 M5 M10 M15 M30 (minutes) H1 H2 H3 H4 H6 H8 H12 (hours) D W M
  'count' => '1000', // The number of candlesticks to return in the response. [default=500, maximum=5000]
  'from' => '2012-10-02T00:00:00Z', // RFC3339 or Unix
  // 'to' => '', // Cannot be used when count is used
  'smooth' => 'False', // A smoothed candlestick uses the previous candle’s close price as its open price, while an un-smoothed candlestick uses the first price from its time range as its open price. [default=False]
  'includeFirst' => 'True', // A flag that controls whether the candlestick that is covered by the from time should be included in the results. [default=True]
  'dailyAlignment' => '17', // The hour of the day (in the specified timezone) to use for granularities that have daily alignments. [default=17, minimum=0, maximum=23]
  'alignmentTimezone' => 'America/New_York', // The timezone to use for the dailyAlignment parameter. [default=America/New_York]
  'weeklyAlignment' => 'Friday' // The day of the week used for granularities that have weekly alignment. [default=Friday]
);
echo '<pre>';
var_dump($api->getInstrumentCandles('XAU_USD', $queryArr));
echo '</pre>';
```
