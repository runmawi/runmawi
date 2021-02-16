<?php
namespace App\Http\Middleware;
use Auth;
use App\Article;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Redirect;


class AdminMiddleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role !== "admin") {
            return Redirect::to('/')->with(array('note' => 'Access Denied', 'note_type' => 'error') );
        }

        return $next($request);
    }
}
