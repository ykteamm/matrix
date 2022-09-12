<?php
namespace App\Http\Middleware;
use App\User;
use Closure;
use Auth;
use Cache;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;

class ActivityByUser
{
    public function handle($request, Closure $next)
    {
        if (Session::has('user')) {
            $expiresAt = Carbon::now()->addMinutes(1); // keep online for 1 min
            Cache::put('user-is-online-' . Session::get('user')->id, true, $expiresAt);
            // last seen
            DB::table('tg_user')->where('id', Session::get('user')->id)->update(['last_seen' => (new \DateTime())->format("Y-m-d H:i:s")]);
        }
        return $next($request);
    }
}