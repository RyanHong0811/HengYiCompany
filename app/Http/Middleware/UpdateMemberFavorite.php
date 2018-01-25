<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;
use App\Member;

class UpdateMemberFavorite
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::get('member.isLogin')) {
              $member = Member::find($request->session()->get('member.id'));
              
              if ($member->hotel_favorite) {
                  $request->session()->put('member.hotel_favorite', json_decode($member->hotel_favorite, true));
              } else {
                  $request->session()->put('member.hotel_favorite', []);
              }

              if ($member->item_favorite) {
                  $request->session()->put('member.item_favorite', json_decode($member->item_favorite, true));
              } else {
                  $request->session()->put('member.item_favorite', []);
              }

              $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
              $barcode = $generator->getBarcode($member->gm_cardId, $generator::TYPE_CODE_128);
              $request->session()->put('member.barcode', $barcode);
        }

        return $next($request);
    }
}
