<?php
/**
 * 初始化参数
 * User: alex
 * Date: 2019-1-17
 */

namespace App\Http\Middleware;

use Closure;
use App\Support\GValue;
use DB;
use Config;
use Auth;

class InitParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        GValue::$orderBy = $request->input("order_by");
        GValue::$perPage = $request->input("per_page");
        GValue::$page = $request->input("page");
        GValue::$user = Auth::user();
        GValue::$httpMethod = $request->getMethod();
        GValue::$debug = $debug = $request->input("debug",0);
        GValue::$nopage = $request->input("nopage",0);

        if(config('app.debug') && 1 == $debug){
            // 开启 sql log
            DB::enableQueryLog();
            $connections = array_keys(Config::get('database.connections', []));
            foreach ($connections as $connection){
                // 循环开启每一种数据库的 log
                DB::connection($connection)->enableQueryLog();
            }
        }

        return $next($request);
    }
}
