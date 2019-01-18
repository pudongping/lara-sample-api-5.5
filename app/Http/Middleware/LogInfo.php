<?php

namespace App\Http\Middleware;

use Closure;
use Log;

class LogInfo
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
        Log::info('Request', $this->getRequestInfo($request));
        $response = $next($request);

        // 记录控制器中最终返回的数据
        $log = ['data' => $response->getContent()];
        if(property_exists($response, 'exception')){
            // 将异常写入日志记录
            $log['exception'] = $response->exception;
        }
        Log::info('Response', $log);
        return $response;
    }


    private function getRequestInfo($request){
        return [
            'ip' => $request->getClientIp(),
            'method' => $request->method(),
            'url' => $request->url(),
            'params' => $request->all(),
        ];
    }





}
