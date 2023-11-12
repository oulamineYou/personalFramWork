<?
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractController
{
    public function render_template(Request $request):Response
    {
        extract($request->attributes->all(), EXTR_SKIP);
        ob_start();
        require sprintf(__DIR__.'/../../src/Views/%s.php', $_route);
        return new Response(ob_get_clean());
    }
}