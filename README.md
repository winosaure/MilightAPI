# MilightAPI
PHP implementation of Milight v6 API

Example of use : 
```php
<?php

require_once __DIR__ . '/v6/Milight.php';

$milight = new v6\Milight("192.168.0.42");

try {
   $milight->setColorRendering(v6\ColorRendering::WW);
   $milight->exec("link", 0x01);
   sleep(5);
   $milight->exec("off", 0x01);
   sleep(2);
   $milight->exec("on", 0x01);
   sleep(2);
   $milight->exec("color", 0x01, "white");
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

unset ($milight);
```