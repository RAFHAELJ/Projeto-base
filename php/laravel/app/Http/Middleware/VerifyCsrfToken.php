<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Support\Facades\Log;

use Closure;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'py/messages',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, Closure $next)
    {
        if (config('app.env') === 'local') {
            return $next($request);
        }
        return parent::handle($request, $next);
    }

    /**
     * Add the CSRF token to the response cookies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addCookieToResponse($request, $response)
    {
        $config = config('session');

        if ($response instanceof Responsable) {
            $response = $response->toResponse($request);
        }

        $domainCookie = $this->getDomain($request->getHost());

        $response->headers->setCookie(
            new Cookie(
                'XSRF-TOKEN', $request->session()->token(), $this->availableAt(60 * $config['lifetime']),
                $config['path'], $domainCookie, $config['secure'], false, false, $config['same_site'] ?? null
            )
        );

        Log::info('CSRF token added to cookies for domain: ' . $domainCookie);

        return $response;
    }

    /**
     * Get the domain for the CSRF token cookie.
     *
     * @param string $host
     * @return string
     */
    protected function getDomain($host)
    {
        // Implemente a lógica para determinar o domínio, se necessário.
        // Pode ser algo como:
        // return parse_url($host, PHP_URL_HOST);
        return $host;
    }
}
