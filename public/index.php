<?
//front Contreller
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;

require_once __DIR__.'/../vendor/autoload.php';

$routes = require __DIR__.'/../src/routes.php';
$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);
//récupérer le path et les paramtéres de lien sous forme d'u tableau ['_route'=>'/hello, 'name'=>bonsoir];
$urlMatch = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

try {
    $request->attributes->add($urlMatch->match($request->getPathInfo()));
    $controller = $controllerResolver->getController($request);
    $arguments = $argumentResolver->getArguments($request, $controller);
    $response = call_user_func_array($controller, $arguments);
} catch (ResourceNotFoundException $exp) {
    $response = new Response('page introvable', 404);
}catch(Exception $exp){
    $response = new Response('An error occurred', 500);
}

$response->send();