<?php
/**
 * Configuration for Whoops
 */
namespace GiveApplePay\Whoops;

use RuntimeException;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Whoops\Util\Misc;


require GIVE_APPLE_PAY_DIR . '/vendor/autoload.php';

$run = new Run();

// We want the error page to be shown by default, if this is a
// regular request, so that's the first thing to go into the stack:
$run->pushHandler( new PrettyPageHandler() );


// Now, we want a second handler that will run before the error page,
// and immediately return an error message in JSON format, if something
// goes awry.
if ( Misc::isAjaxRequest() ) {
	$jsonHandler = new JsonResponseHandler();


	// You can also tell JsonResponseHandler to give you a full stack trace:
	// $jsonHandler->addTraceToOutput(true);
	// You can also return a result compliant to the json:api spec
	// re: http://jsonapi.org/examples/#error-objects
	// tl;dr: error[] becomes errors[[]]
	$jsonHandler->setJsonApi( true );


	// And push it into the stack:
	$run->pushHandler( $jsonHandler );
}


// That's it! Register Whoops and throw a dummy exception:
$run->register();

//throw new RuntimeException( 'Oh fudge napkins!' );


