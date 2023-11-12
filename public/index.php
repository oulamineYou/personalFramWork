<?
//front Contreller
require_once __DIR__.'/../vendor/autoload.php';

$routes = require __DIR__.'/../src/routes.php';

$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();

//récupérer le path et les paramtéres de lien sous forme d'u tableau ['_route'=>'/hello, 'name'=>bonsoir];
$urlMatch = new Symfony\Component\Routing\Matcher\UrlMatcher($routes, new Symfony\Component\Routing\RequestContext());

$controllerResolver = new Symfony\Component\HttpKernel\Controller\ControllerResolver();
$argumentResolver = new Symfony\Component\HttpKernel\Controller\ArgumentResolver();

$framwork = new App\Core\FrameWork($urlMatch, $controllerResolver, $argumentResolver);

$response = $framwork->handle($request);

$response->send();