<?php

namespace App\Http\Middleware;

use Closure;

class DouyuToken
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
        if ($request->exists(['signature','timestamp','nonce'])){
            $params = $request->only('signature','timestamp','nonce');
            $token = env('DOUYU_POST_TOKEN');
            $tmpArr = [$token,$params['timestamp'],$params['nonce']];
            sort($tmpArr,SORT_STRING);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );
            if ($tmpStr == $params['signature']){
                return $next($request);
            }
        }
        return response([
            'msg' => '认证失败',
            'code' => 401
        ],401);
    }
}
