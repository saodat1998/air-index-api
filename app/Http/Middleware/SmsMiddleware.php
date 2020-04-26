<?php
namespace App\Http\Middleware;

use App\Models\SmsApp;
use App\Models\Topic;
use App\Models\User;
use Auth;
use Closure;

class SmsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        $appId = $request->input('app_id');
        if ($appId) {
            /** @var SmsApp $app */
            $app = SmsApp::where('app_id', $appId)->first();

            /** @var User $user */
            $user = Auth::user();

            if (!$app) {
                return response([
                    'code' => 500,
                    'type' => "error",
                    "message" => 'App not found!.'
                ], 500);
            }

            if ($user->email != $app->user->email
                && $app->status == SmsApp::STATUS_ACTIVE
            ) {
                return response([
                    'code' => 403,
                    'type' => "error",
                    "message" => 'Not permission to this app!.'
                ], 403);
            }
        }

        return $next($request);
    }
}
