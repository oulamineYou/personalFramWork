<?
//front Contreller
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require_once __DIR__.'/../vendor/autoload.php';

$routes = require __DIR__.'/../src/app.php';
$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);
//récupérer le path et les paramtéres de lien sous forme d'u tableau ['_route'=>'/hello, 'name'=>bonsoir];
$urlMatch = new UrlMatcher($routes, $context);


try {
    extract($urlMatch->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();
    require sprintf(__DIR__.'/../src/pages/%s.php', $_route);
    $response = new Response(ob_get_clean());
} catch (ResourceNotFoundException $exp) {
    $response = new Response('page introvable', 404);
}catch(Exception $exp){
    $response = new Response('An error occurred', 500);
}

$response->send();