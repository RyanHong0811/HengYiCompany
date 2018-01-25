<?php

namespace App\Http\Controllers;


use App\Cart;
use App\CartItem;
use Illuminate\Http\Request;
use App\EditItem;
use App\Hotel;
use App\HotelStyle;
use App\HotelSetting;
use App\HotelSpecialDay;
use App\Image;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Member;
use App\Banner;
use App\BrowserHistories;
use App\RoomOrder;
use App\RoomOrderDetail;
use App\Promotion;
use Input;
use Session;
use Picqer\Barcode\BarcodeGeneratorHTML;

class IndexController extends Controller
{
    /**
     * 回應對 GET /edititem/1 的請求
     */
    public function getIndex()
    {
      $hotel = Hotel::join('hotel_style', 'hotel.id', '=', 'hotel_style.hotel_id')
               ->where('hotel.popular', 1)
               ->limit(3)
        		   ->selectRaw("min(hotel_style.point) as point, `hotel`.`name_zh-tw`, hotel_style.price, hotel.image_1, hotel.id")
               ->orderBy('point', '-1')
          		 ->groupBy('hotel_style.hotel_id')
            	 ->get();
      $food = EditItem::where('popular', 1)
               ->where('item_type', 'food')
               ->limit(4)
               ->orderBy('orderby', '-1')
               ->get();
      $trafic = EditItem::where('popular', 1)
               ->where('item_type', 'trafic')
               ->limit(4)
               ->orderBy('orderby', '-1')
               ->get();
      $funny = EditItem::where('popular', 1)
               ->where('item_type', 'funny')
               ->limit(4)
               ->orderBy('orderby', '-1')
               ->get();
      $banner = Banner::get();

	    return view('index', [
	        'page' => 'index',
	        'keywords' => '',
	        'description' => '',
          'banners' => $banner,
	        'title' => '',
	        'hotels' => $hotel,
          'foods' => $food,
          'trafics' => $trafic,
          'funnys' => $funny,
          'type' => ''
	    ]);
    }

    /**
     * 回應對 GET /edititem/1 的請求
     */
    public function getSearch(Request $request)
    {
      $params = $request->all();
      $hotel = HotelStyle::leftJoin('hotel', 'hotel.id', '=', 'hotel_style.hotel_id')
               ->leftJoin('hotel_setting', 'hotel.id', '=', 'hotel_setting.hotel_id')
               ->select('hotel.id as hotel_id', 'hotel_style.id as hotel_style_id', 'hotel.address_zh-tw', 'hotel.name_zh-tw as hotel_name', 'hotel.image_1', DB::raw('MIN(hotel_style.point) AS point'), 'hotel_style.price', 'hotel_style.name_zh-tw as hotel_style_name', 'hotel_style.holiday_point as holiday_point', 'hotel_style.holiday_price as holiday_price', 'hotel_setting.weekend', 'hotel_setting.star');
      $pageNow = 1;

      if(empty($params)) {
          $hotel = $hotel->where('hotel.popular', 1);
      }

      foreach ($params as $key => $param) {
        if (!empty($param)) {
          switch ($key) {
            case 'type':
              $hotel = $hotel->where(function ($query) use ($params) {
                foreach ($params['type'] as $key => $value) {
                  $query->orWhere('hotel_setting.type', 'like', "%\"{$value}\"%");
                }
              });
              break;
            case 'name':
              $hotel = $hotel->where('hotel.name_zh-tw', 'like', "%{$param}%");
              break;
            case 'facility':
              foreach ($params['facility'] as $key => $value) {
                $hotel = $hotel->where('hotel_setting.facility', 'like', "%\"{$value}\"%");
              }
            break;
            case 'star':
              $hotel = $hotel->where('hotel_setting.star', '>=', $params['star']);
              break;
            case 'price':
              $price  = explode(',', $params['price']);
              $hotel = $hotel->whereBetween('hotel_style.point', [$price[0], $price[1]]);
              break;
            case 'pageNow':
              $page = ceil($hotel->count()/10);
              if ($params['pageNow'] > 0 && $params['pageNow'] <= $page) {
                $pageNow = $params['pageNow'];
              }
              break;
            default:
              # code...
              break;
          }
        }
      }

      $tags = ['type', 'facility', 'star'];
      foreach ($tags as $value) {
        $params[$value] = (!empty($params[$value])) ? $params[$value] : [];
      }

      $page = ceil($hotel->count()/10);
      if (isset($params['pageNow'])) {
        if ($params['pageNow'] > 0 && $params['pageNow'] <= $page) {
          $pageNow = $params['pageNow'];
        } else {
          $pageNow = ($params['pageNow'] == 0) ? 1 : $page;
        }
      }

      if (empty($params['price_orderby']) || $params['price_orderby'] == -1) {
        $hotels = $hotel->orderBy('hotel_style.point', 'desc')->groupBy('hotel.id')->forPage($pageNow, 10)->get();
      } else {
        $hotels = $hotel->orderBy('hotel_style.point', 'asc')->groupBy('hotel.id')->forPage($pageNow, 10)->get();
      }
      if (empty($params['start_day'])) {
        $params['start_day'] = Carbon::today()->format('Y/m/d');
      }
      if (empty($params['end_day'])) {
        $params['end_day'] = Carbon::today()->addDay(1)->format('Y/m/d');
      }

      $start_day = Carbon::parse($params['start_day']);
      $end_day = Carbon::parse($params['end_day']);
      foreach ($hotels as &$hotel) {
          $week = ($hotel['weekend']) ? json_decode($hotel['weekend'], true) : [];
          $hotel['sum_price'] = 0;
          $hotel['sum_point'] = 0;
          for ($i = 0; $i <= $start_day->diffInDays($end_day) - 1; $i++) {
            $day = Carbon::parse($params['start_day']);
            $hotelSpecialDay = new HotelSpecialDay;
            if ($i != 0) {
                $day->addDay($i);
            }
            $hotelSpecialDay = $hotelSpecialDay->getSpecialPoint($day, $hotel['hotel_style_id']);
            if (!empty($hotelSpecialDay['date'])) {
                $hotel['sum_price'] += $hotelSpecialDay['price'];
                $hotel['sum_point'] += $hotelSpecialDay['point'];
            } elseif (in_array($day->dayOfWeek, $week)) {
                $hotel['sum_price'] += $hotel['holiday_price'];
                $hotel['sum_point'] += $hotel['holiday_point'];
            } else {
                $hotel['sum_price'] += $hotel['price'];
                $hotel['sum_point'] += $hotel['point'];
            }
          }
          $hotel['average_price'] = round($hotel['sum_price'] / $i, 0);
          $hotel['average_point'] = round($hotel['sum_point'] / $i, 0);
      }

      if ($request->session()->get('member.isLogin')) {
        $histories = BrowserHistories::where('user_id', $request->session()->get('member.id'));
      } else {
        $histories = BrowserHistories::where('session_id', $request->session()->getId());
      }
      $histories = $histories->limit(3)->orderBy('created_at', '-1')->get();
      return view('search-hotel', [
          'page' => 'search-hotel',
          'params' => $params,
          'pageCount' => ceil($page),
          'pageNow' => $pageNow,
          'keywords' => '',
          'description' => '',
          'title' => '',
          'type' => 'hotel',
          'hotels' => $hotels,
          'hotel_count' => $hotel->count(),
          'histories' => $histories
      ]);
    }

    /**
     * 回應對 GET /edititem/1 的請求
     */
    public function getHotel($hotel_id, Request $request)
    {
      $params = $request->all();
      $hotel = Hotel::find($hotel_id);
      $hotel['check_in'] = Carbon::parse($hotel['check_in'])->format('h:i');
      $hotel['check_out'] = Carbon::parse($hotel['check_out'])->format('h:i');
      $hotel_rooms = HotelStyle::where('hotel_style.hotel_id', $hotel_id)
                     ->select('name_zh-tw', 'id', 'image_1', 'point', 'price', 'holiday_point', 'holiday_price')->get();

      if (empty($params['start_day'])) {
        $params['start_day'] = Carbon::today()->format('Y/m/d');
      }
      if (empty($params['end_day'])) {
        $params['end_day'] = Carbon::today()->addDay(1)->format('Y/m/d');
      }

      $start_day = Carbon::parse($params['start_day']);
      $end_day = Carbon::parse($params['end_day']);
      $smallest_Point = 999999;
      foreach ($hotel_rooms as &$hotel_room) {
          $week = ($hotel->setting['weekend']) ? json_decode($hotel->setting['weekend'], true) : [];
          $hotel_room['sum_price'] = 0;
          $hotel_room['sum_point'] = 0;
          for ($i = 0; $i <= $start_day->diffInDays($end_day) - 1; $i++) {
            $day = Carbon::parse($params['start_day']);
            $hotelSpecialDay = new HotelSpecialDay;
            if ($i != 0) {
                $day->addDay($i);
            }
            $hotelSpecialDay = $hotelSpecialDay->getSpecialPoint($day, $hotel_room['id']);
            if (!empty($hotelSpecialDay['date'])) {
                $hotel_room['sum_price'] += $hotelSpecialDay['price'];
                $hotel_room['sum_point'] += $hotelSpecialDay['point'];
            } elseif (in_array($day->dayOfWeek, $week)) {
                $hotel_room['sum_price'] += $hotel_room['holiday_price'];
                $hotel_room['sum_point'] += $hotel_room['holiday_point'];
            } else {
                $hotel_room['sum_price'] += $hotel_room['price'];
                $hotel_room['sum_point'] += $hotel_room['point'];
            }
          }
          $hotel_room['average_price'] = round($hotel_room['sum_price'] / $i, 0);
          $hotel_room['average_point'] = round($hotel_room['sum_point'] / $i, 0);
          $smallest_Point = ($hotel_room['average_point'] < $smallest_Point) ? $hotel_room['average_point'] : $smallest_Point;
      }

      $history = new BrowserHistories;
      if ($request->session()->get('member.isLogin')) {
        $history->user_id = $request->session()->get('member.id');
      } else {
        $history->session_id = $request->session()->getId();
      }
      $history->point = $smallest_Point;
      $history->type = 'hotel';
      $history->history_id = $hotel_id;
      $history->save();

      return view('introduce-hotel', [
          'page' => 'introduce-hotel',
          'keywords' => '',
          'description' => '',
          'title' => '',
          'hotel' => $hotel,
          'hotel_room' => $hotel_rooms,
          'type' => 'hotel',
          'params' => $params
      ]);
    }

    /**
     * 回應對 GET /edititem/1 的請求
     */
    public function getReservation($hotel_id, Request $request)
    {
      $member = Member::find($request->session()->get('member.id'));
      if (!$member) {
          return redirect(explode('?', redirect()->back()->getTargetUrl())[0].'?msg=need_login');
      } else {
          $cart = Cart::where('user_id', $request->session()->get('member.id'))->first();
      }
      $hotel = Hotel::find($hotel_id);
      $hotel['check_in'] = Carbon::parse($hotel['check_in'])->format('h:i');
      $hotel['check_out'] = Carbon::parse($hotel['check_out'])->format('h:i');
      $rooms = [];
      $sum_amount = 0;
      foreach ($cart->cartItems as $key => $item) {
        if ($item->room['hotel_id'] == $hotel_id) {
          $rooms[$key] = $item->room;
          $rooms[$key]['count'] = $item['item_count'];
        }
      }
      $start_day = Carbon::parse($cart->cartItems[0]['start_day']);
      $end_day = Carbon::parse($cart->cartItems[0]['end_day']);

      foreach ($rooms as &$room) {
          $week = ($hotel->setting['weekend']) ? json_decode($hotel->setting['weekend'], true) : [];
          $room['sum_price'] = 0;
          $room['sum_point'] = 0;
          for ($i = 0; $i <= $start_day->diffInDays($end_day) - 1; $i++) {
            $day = Carbon::parse($cart->cartItems[0]['start_day']);
            $hotelSpecialDay = new HotelSpecialDay;
            if ($i != 0) {
                $day->addDay($i);
            }
            $hotelSpecialDay = $hotelSpecialDay->getSpecialPoint($day, $room['id']);
            if (!empty($hotelSpecialDay['date'])) {
                $room['sum_price'] += $hotelSpecialDay['price'];
                $room['sum_point'] += $hotelSpecialDay['point'];
            } elseif (in_array($day->dayOfWeek, $week)) {
                $room['sum_price'] += $room['holiday_price'];
                $room['sum_point'] += $room['holiday_point'];
            } else {
                $room['sum_price'] += $room['price'];
                $room['sum_point'] += $room['point'];
            }
          }
          $sum_amount += $room['sum_point'];
      }
      $max_day = $start_day->diffInDays($end_day);
      $week = ['日', '一', '二', '三', '四', '五', '六'];
      $week = [$week[$start_day->dayOfWeek], $week[$end_day->dayOfWeek]];
      $start_day = explode('-', $start_day->toDateString());
      $end_day = explode('-', $end_day->toDateString());
      return view('order-hotel', [
          'page' => 'order-hotel',
          'keywords' => '',
          'description' => '',
          'title' => '',
          'hotel' => $hotel,
          'rooms' => $rooms,
          'start_day' => $start_day,
          'end_day' => $end_day,
          'max_day' => $max_day,
          'sum_amount' => $sum_amount,
          'week' => $week,
          'member' => $member,
          'cartItem' => $cart->cartItems[0]
      ]);
    }

    public function postReservation(Request $request)
    {
        $inputs = $request->only('name', 'email', 'phone', 'live_name', 'live_phone', 'special_require', 'start_day', 'end_day', 'coupon');
        $roomOrder = new RoomOrder;
        foreach ($inputs as $key => $input) {
          $roomOrder->{$key} = $input;
        }
        $roomOrder->save();
        $cart = Cart::where('user_id', $request->session()->get('member.id'))->first();

        $start_day = Carbon::parse($inputs['start_day']);
        $end_day = Carbon::parse($inputs['end_day']);
        foreach ($cart->cartItems as $key => $item) {
          if ($item->room['hotel_id'] == $request->hotel_id) {
              $room_order_detail = new RoomOrderDetail;
              $room_order_detail->order_id = $roomOrder->id;
              $week = ($item->room->setting['weekend']) ? json_decode($item->room->setting['weekend'], true) : [];
              $room = $item->room->toArray();
              $sum_price = 0;
              $sum_point = 0;
              for ($i = 0; $i <= $start_day->diffInDays($end_day) - 1; $i++) {
                $day = Carbon::parse($start_day);
                $hotelSpecialDay = new HotelSpecialDay;
                if ($i != 0) {
                    $day->addDay($i);
                }
                $hotelSpecialDay = $hotelSpecialDay->getSpecialPoint($day, $room['id']);
                if (!empty($hotelSpecialDay['date'])) {
                    $sum_price += $hotelSpecialDay['price'];
                    $sum_point += $hotelSpecialDay['point'];
                } elseif (in_array($day->dayOfWeek, $week)) {
                    $sum_price += $room['holiday_price'];
                    $sum_point += $room['holiday_point'];
                } else {
                    $sum_price += $room['price'];
                    $sum_point += $room['point'];
                }
              }
              $room['sum_price'] = $sum_price;
              $room['sum_point'] = $sum_point;
              unset($room['setting'], $room['updated_at'], $room['created_at']);
              foreach ($room as $key => $value) {
                if ($key == 'id') {
                  $room_order_detail->room_id = $value;
                } else {
                  $room_order_detail->{$key} = $value;
                }
              }
              $room_order_detail->save();
          }
        }
        CartItem::where('cart_id', $cart['id'])->delete();
        Cart::find($cart['id'])->delete();
        return redirect('/order-finish-hotel');
    }


    /**
     * 註冊
     */
    public function postRegister(Request $request)
    {
      $member = Member::where('gm_mobile', $request->input('phone'))->first();
      if ($member->verify_status == 'A') return redirect('/');
      $member->gm_name = $request->input('name');
      $member->gm_email = $request->input('email');
      $member->company = $request->input('company');
      $member->fb_Id = $request->input('fb_Id');
      $member->verify_status = 'A';
      $member->save();
      return redirect('/');
    }

    public function postLogin(Request $request)
    {
      $member = Member::where('gm_mobile', $request->input('phone'))
                ->where('gm_pwd', md5($request->input('password')))
                ->first();
      if (!$member) return json_encode(['result' => false]);
      $member->session_id = $request->session()->getId();
      $request->session()->put('member.name', $member->gm_name);
      $request->session()->put('member.mobile', $member->gm_mobile);
      $request->session()->put('member.gm_point', $member->gm_point);
      $request->session()->put('member.id', $member->id);
      $request->session()->put('member.isLogin', true);
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

      $generator = new BarcodeGeneratorHTML();
      $barcode = $generator->getBarcode($member->gm_cardId, $generator::TYPE_CODE_128);
      $request->session()->put('member.barcode', $barcode);

      $member->save();
      return json_encode(['result' => true, 'url' => explode('?', redirect()->back()->getTargetUrl())[0]]);
    }

    public function getLogout(Request $request)
    {
      $request->session()->pull('member');
      return redirect('/');
    }

    public function verifyPromotion(Request $request)
    {
      $point = $request->point;
      $promotion = Promotion::where('code', $request->promotion)->where('status', 1)->first();
      if ($promotion) {
        $promotion['amount'] = number_format($point - $promotion['point']);
        return $promotion;
      } else {
        return ['result' => false];
      }
    }
}
