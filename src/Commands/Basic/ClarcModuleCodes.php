<?php


namespace nrslib\ClarcLaravelPlugin\Commands\Basic;


class ClarcModuleCodes
{
    public static $clarcProvider =
'<?php


namespace App\Providers;


use App\Http\Middleware\ClarcMiddleWare;
use Illuminate\Support\ServiceProvider;

/**
 * Class ClarcProvider
 * @package App\Providers
 */
class ClarcProvider extends ServiceProvider
{
    /**
     * register clarc objects
     */
    public function register()
    {
        $this->app->singleton(ClarcMiddleWare::class);
        $this->registerUseCases();
    }

    /**
     * register use cases
     */
    private function registerUseCases()
    {
    }
}
';

    public static $debugProvider =
'';

    public static $middleWare =
'<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

class ClarcMiddleWare
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var Router
     */
    private $router;

    /**
     * ClarcMiddleWare constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param mixed $data
     * @see \Illuminate\Routing\Router::toResponse()
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($this->data === null) {
            return $response;
        }

        return $this->router->prepareResponse($this->router->getCurrentRequest(), $this->data);
    }
}
';
}