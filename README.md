# MilightAPI

## About

This library provide an high level abstraction of different Milight bulb. This is written in PHP and it's working with V6 API of limitessled.

/!\ Currently Only RGBWW led bulb are supported. Feel free to contribute and add new command.


## Example of use 
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