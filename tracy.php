<?php
/**
 * Config file for Tracy debugging library. Similar to Whoops
 */

namespace GiveApplePay\Tracy;


use Tracy\Debugger;

require GIVE_APPLE_PAY_DIR . '/vendor/autoload.php';


Debugger::enable();

Debugger::$showLocation = true;





//$arr = [ 10, 20.2, true, null, 'hello' ];
//
//dump( $arr );

