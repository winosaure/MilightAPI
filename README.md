# MilightAPI
PHP implementation of Milight v6 API

Example of use : 
```php
<?php

require_once "vendor/autoload.php";

use Winosaure\MilightApi\v6\Milight;
use Winosaure\MilightApi\v6\ColorRendering;

$milight = new Milight("192.168.0.42");

try {
   $milight->setColorRendering(ColorRendering::WW);
   
   $args = array (
       'action' => 'link',
       'zone'   => 0x01
   );
   $milight->exec($args);
   sleep(5);
   
   $args['action'] = 'off';  
   $milight->exec($args);
   sleep(2);
   
   $args['action'] = 'on';  
   $milight->exec($args);
   sleep(2);
   
   $args['action'] = 'color';
   $args['color'] = 'lime';
   $milight->exec($args);
   sleep(2);
   
   $args['color'] = 'white';
   $milight->exec($args);
   sleep(2);
   
   $args['action'] = 'brightness';
   $args['intensity'] = 0x32;
   $milight->exec($args);
   sleep(2);
   
   $args['action'] = 'off';
   $milight->exec($args);
   sleep(2);
   
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

unset ($milight);
```