<?

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$routes = new RouteCollection();

$routes->add('hello', new Route("/hello/{name}",
    [
        "name" => "world",
        "_controller" => function(Request $request){
            $response = App\Controller\AbstractController::render_template($request);
            return $response;
        }
    ]
));

$routes->add('bye', new Route("/bye", ["_controller" => 'App\Controller\AbstractController::render_template']));

return $routes;