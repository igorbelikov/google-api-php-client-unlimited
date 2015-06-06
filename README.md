# Google APIs Client Wrapper For PHP (free unlimited requests for google services)
Google APIs Client Wrapper for PHP with multi keys (for free using)

This extension has been developed to overcome the maximum number of requests to Google API services free of charge.

For example service Custom Search Engine (https://cse.google.com/cse/all).
There are free of charge can only be made 100 requests per day ($ 5 - 1000 requests, etc.), which is very small, so it is now possible to create multiple applications and take each token, with the identifier of the application remains a CSE, that is, in other words - we can use every 100 requests from each application we have created. We simply create an application and take with them the ID.

And this method can be applied to any API, provided to reduce constraints.

Example:
```php

// Custom Search Engine Example

// https://console.developers.google.com/project
$keys = array(
	'YOUR_DEVELOPER_KEY_1', // app-1, for one project available 100 free requests
	'YOUR_DEVELOPER_KEY_2', // app-2 + 100 requests
	'YOUR_DEVELOPER_KEY_3', // app-3 + 100 requests
	// ...
);

// In total count all tokens eq 300 requst/day! Ha-Ha!

$client = new Google_Client_Multi();
$client->setKeys($keys)->prepareMulti();

$service = new Google_Service_Customsearch($client);
try {
	$cse = $service->cse->listCse("weather", array('cx' => 'YOUR_CUSTOM_SEARCH_ENGINE_ID'));
	var_dump($cse->getItems());
} catch(Google_Service_Exception $e) {
	echo $e->getMessage();
} catch(Google_Client_Multi_Exception $e) {
	echo $e->getMessage();
}
```

# Install/Autoload
Composer:

This version of `google-api-php-client-multi` using [Composer](http://getcomposer.org).
The first step to use `google-api-php-client-multi` is to download composer:

```bash
$ curl -s http://getcomposer.org/installer | php
```

Now we can use autoloader from Composer by:
```
php composer.phar require 'igorbelikov/google-api-php-client-multi:dev-master'
```
or
```json
{
    "require": {
		"igorbelikov/google-api-php-client-multi": "dev-master"
    }
}
```
# RU
Это расширение было разработано для преодоления максимального количества запросов в сервисах Google API на бесплатной основе.

Например сервис Custom Search Engine (https://cse.google.com/cse/all).
Там на бесплатной основе можно делать только 100 запросов в день (5$ - 1000 запросов и т.д.), что очень мало, поэтому теперь есть возможность создать несколько приложений и взять у каждого токен, при этом идентификатор самого CSE приложение остается один, то есть другими словами - мы можем использовать каждые 100 запросов из каждого созданного нами приложения. Нам достаточно просто создавать приложения и брать с них идентификатор.

И этот способ можно применить к любому API, чтобы уменьшить предоставленные ограничения.
