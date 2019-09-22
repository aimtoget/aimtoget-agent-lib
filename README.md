# aimtoget-agent-lib
PHP Wrapper for Aimtoget APIs

### Installation

Using composer
```
composer install aimtoget/aimtoget-agent-lib
```

Add to your PHP code by including the **autoload.php** file
```
require_once "__DIR__/aimtoget-agent-lib/autoload.php";
```

### **Usage**

- Configuration: You are required to initalize the configuration with your private key and wallet pin (Remember to always keep your private key **Private!!!**)

```php
<?php

use Aimtoget\Agent\Config;

$config = new Config('--Secret key--', '--Wallet Pin--');
```
The configuration can now be utilized for other methods.

- **To retrieve your wallet balance**
```php
<?php

use Aimtoget\Agent\Account;

$account = new Account($config);
echo $account->getBalance();
```

- **Airtime Purchase**:

```php
<?php

use Aimtoget\Agent\Airtime;

$airtime = new Airtime($config);

//Purchase NGN100 Airtime
$reference = $airtime->purchase([
    'phone' => '09061668519',
    'network_id' => 1,
    'amount' => 100
]);
```

- **Get all networks:** This is required for airtime and data purchase
```php
<?php

use Aimtoget\Agent\Networks;

$networks = new Networks($config);
$all_networks = $networks->getAllNetworks();
```

- **Get all data plans:** Required for data purchase
```php
<?php

use Aimtoget\Agent\Data;

$data = new Data($config);

//All Plans
$all = $data->getAllVariations();

//Retrieve plans for a certain network
$plans = $data->getNetworkVariations($network_id);
```

- **Purchase Data:**
```php
//Purchase 1GB of MTN data
$reference = $data->purchase([
    'phone' => '09061668519',
    'network_id' => 1,
    'variation' => 'M1024'
]);
```

- **Pay Bills & Services**
```php
<?php

use Aimtoget\Agent\Services;

$services = new Services($config);

//Get all services
$all = $services->getAll();
```

**Retrieve Service Data & Variations**
```php
$service = $services->getService($service_id);
```

**Verify service customer**
```php
$verify = $services->verifyCustomer($service_id, $customer_id);
```

**Purchase service**
```php
$reference = $service->pay($service_id, [
    'customer_id' => $customer_id,
    'amount' => $amount, //For services WITHOUT variations,
    'variation' => $variaiton, //For services WITH variations,
    'phone' => $customer_phone,
    'email' => $customer_email
 ]);
```
## **Bank transfer**

- **Get all banks**
```php
<?php

use Aimtoget\Agent\BankTransfer;

$bank = new BankTransfer($config);

//Get banks
$banks = $bank->getBanks();
```

- **Resolve Account Details**
```php
<?php

use Aimtoget\Agent\BankTransfer;

$bank = new BankTransfer($config);
$account_name = $bank->resolveAccount('-bank code--', '-account number-');

echo $account_name;
```

- **Make bank transfer**
```php
<?php

use Aimtoget\Agent\BankTransfer;

$bank = new BankTransfer($config);
$reference = $bank->transfer([
    'amount' => 2000,
    'bank_code' => '00007',
    'account_number' => '0123456789',
    'description' => 'Transfer narration'
]);

echo $reference;
```

## **Transaction Details**
- **Retrieve your transactions:**

Get a list of all your transactions using our APIs

```php
<?php

use Aimtoget\Agent\Transactions;

$transactions = new Transactions($config);
$list = $transactions->getTransactions(); //Fetches first 10 transactions
```

Get details for a single transaction
```php
$details = $transactions->getTransaction($reference_code);
```

For any issue and complaint kindly contact us via **developer@aimtoget.com**