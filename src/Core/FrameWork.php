<?
namespace App\Core;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrameWork 
{
    private UrlMatcher $matcher;
    private ControllerResolver $controllerResolver;
    private ArgumentResolver $argumentResolver;
    public function __construct(
        UrlMatcher $matcher,
        ControllerResolver $controllerResolver,
        ArgumentResolver $argumentResolver
    ){
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function handle(Request $request):Response
    {
        $this->matcher->getContext()->fromRequest($request);
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);
            
            return $response = call_user_func_array($controller, $arguments);

        } catch (ResourceNotFoundException $exp) {
            return $response = new Response('page introvable', 404);
        }catch(Exception $exp){
            return $response = new Response('An error occurred', 500);
        }
    }

}