<?
//front Contreller
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require_once __DIR__.'/../vendor/autoload.php';

$routes = require __DIR__.'/../src/routes.php';
$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);
//récupérer le path et les paramtéres de lien sous forme d'u tableau ['_route'=>'/hello, 'name'=>bonsoir];
$urlMatch = new UrlMatcher($routes, $context);


try {
    $request->attributes->add($urlMatch->match($request->getPathInfo()));
    $response = call_user_func($request->attributes->get('_controller'), $request);
} catch (ResourceNotFoundException $exp) {
    $response = new Response('page introvable', 404);
}catch(Exception $exp){
    $response = new Response('An error occurred', 500);
}

$response->send();