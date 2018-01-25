<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// 首頁
Route::get('/', ['uses'=>'IndexController@getIndex']);

Route::get('/search-hotel', ['uses'=>'IndexController@getSearch']);
Route::post('/addItem', ['uses'=>'CartController@addItem']);
Route::post('/register', ['uses'=>'IndexController@postRegister']);
Route::post('/login', ['uses'=>'IndexController@postLogin']);
Route::post('/verify', ['uses'=>'SendSMSController@postVerify']);
Route::post('/checkPhone', ['uses'=>'SendSMSController@checkPhone']);
Route::post('/checkVerifyCode', ['uses'=>'SendSMSController@checkVerifyCode']);
Route::get('/logout', ['uses'=>'IndexController@getLogout']);
Route::post('/generateMACString', ['uses' => 'GoldFlowController@generateMACString']);
Route::post('/registerCard', ['uses' => 'GoldFlowController@registerCard']);
Route::post('/creditResult', ['uses' => 'GoldFlowController@creditResult']);
Route::get('/decrypt', ['uses' => 'GoldFlowController@decrypt']);
Route::post('/reservation', ['uses'=>'IndexController@postReservation']);
Route::post('/verifyPromotion', ['uses'=>'IndexController@verifyPromotion']);

Route::post('/cardSendPresent', ['uses'=>'GoldFlowController@cardSendPresent']);
Route::post('/BalanceInquiry', ['uses'=>'GoldFlowController@BalanceInquiry']);


//收藏商品
Route::post('/postFavorite', function (Request $request) {
    $member = App\Member::find(Session::get('member.id'));
    $input = $request->only(['type', 'id', 'status']);
    if ($input['type'] == 'hotel') {
        $favorite = json_decode($member->hotel_favorite, true);
    } elseif ($input['type'] == 'item') {
        $favorite = json_decode($member->item_favorite, true);
    }
    $favorite = (empty($favorite)) ? [] : $favorite;

    if ($input['status'] == 1) {
        $favorite = array_diff($favorite, [$request->id]);
    } else {
        $favorite[] = $request->id;
    }
    if ($input['type'] == 'hotel') {
        $member['hotel_favorite'] = json_encode($favorite);
    } elseif ($input['type'] == 'item') {
        $member['item_favorite'] = json_encode($favorite);
    }

    $member->save();
    return ['result' => true];
});



//會員登入
Route::post('/fbLogin', function (Request $request) {
    $member = App\Member::where('fb_Id', $request->input('fb_Id'))
                        ->first();
    if (!$member) {
        return json_encode(['result' => false]);
    }
    Session::put('member.name', $member->gm_name);
    Session::put('member.gm_point', $member->gm_point);
    Session::put('member.id', $member->id);
    Session::put('member.isLogin', true);
    return json_encode(['result' => true]);
});
Route::post('/fbCheck', function (Request $request) {
    $member = App\Member::where('fb_Id', $request->input('fb_Id'))
                        ->first();
    if (!$member) {
        return json_encode(['result' => true]);
    }
    return json_encode(['result' => false]);
});
// Route::post('/getAddress', function () {
//     $hotel = App\Hotel::select('address_zh-tw')
//              ->get()
//              ->groupBy('address_zh-tw')
//              ->toArray();
//     return $hotel;
// });

//重設密碼
Route::post('/reset-password', function (Request $request) {
    $member = App\Member::where('verify_code', $request->input('verify_code'))
                        ->where('gm_mobile', $request->input('phone'))
                        ->first();
    if ($member) {
        $member->gm_pwd = md5($request->input('password'));
        $member->save();
        return redirect('/?msg=reset_success');
    } else {
        return redirect('/?msg=reset_false');
    }
});


// 飯店介紹頁
Route::post('/hotel/{hotel_id}', ['uses'=>'IndexController@getHotel']);
Route::get('/hotel/{hotel_id}', ['uses'=>'IndexController@getHotel']);

// 預約訂房
Route::get('/reservation/{hotel_id}', ['uses'=>'IndexController@getReservation']);

// 訂單完成（住宿）
Route::get('/order-finish-hotel', function () {
    return view('order-finish-hotel', [
        'page' => 'order-finish-hotel',
        'keywords' => '',
        'description' => '',
        'pageCount' => 1,
        'pageNow' => 1,
        'title' => '',
    ]);
});

// 商品介紹頁
Route::get('/introduce-trafic/{id}', function ($id) {
    $item = App\EditItem::find($id);
    $history = new App\BrowserHistories;
    if (Session::get('member.isLogin')) {
        $history->user_id = Session::get('member.id');
    } else {
        $history->session_id = Session::getId();
    }
    $history->point = $item->point;
    $history->type = 'item';
    $history->history_id = $item->id;
    $history->save();

    if (Session::get('member.isLogin')) {
        $histories = App\BrowserHistories::where('user_id', Session::get('member.id'));
    } else {
        $histories = App\BrowserHistories::where('session_id', Session::getId());
    }
        $histories = $histories->limit(3)->orderBy('created_at', '-1')->get();
    return view('introduce-food', [
        'page' => 'introduce-food',
        'histories' => $histories,
        'keywords' => '',
        'description' => '',
        'pageCount' => 1,
        'pageNow' => 1,
        'title' => '',
        'type' => 'trafic',
        'item' => $item,
    ]);
});

Route::get('/introduce-food/{id}', function ($id) {
    $item = App\EditItem::find($id);
    $history = new App\BrowserHistories;
    if (Session::get('member.isLogin')) {
        $history->user_id = Session::get('member.id');
    } else {
        $history->session_id = Session::getId();
    }
    $history->point = $item->point;
    $history->type = 'item';
    $history->history_id = $item->id;
    $history->save();

    if (Session::get('member.isLogin')) {
        $histories = App\BrowserHistories::where('user_id', Session::get('member.id'));
    } else {
        $histories = App\BrowserHistories::where('session_id', Session::getId());
    }
        $histories = $histories->limit(3)->orderBy('created_at', '-1')->get();
    return view('introduce-food', [
        'page' => 'introduce-food',
        'histories' => $histories,
        'keywords' => '',
        'description' => '',
        'pageCount' => 1,
        'pageNow' => 1,
        'title' => '',
        'type' => 'food',
        'item' => $item,
    ]);
});

Route::get('/introduce-funny/{id}', function ($id) {
    $item = App\EditItem::find($id);
    $history = new App\BrowserHistories;
    if (Session::get('member.isLogin')) {
        $history->user_id = Session::get('member.id');
    } else {
        $history->session_id = Session::getId();
    }
    $history->point = $item->point;
    $history->type = 'item';
    $history->history_id = $item->id;
    $history->save();

    if (Session::get('member.isLogin')) {
        $histories = App\BrowserHistories::where('user_id', Session::get('member.id'));
    } else {
        $histories = App\BrowserHistories::where('session_id', Session::getId());
    }
        $histories = $histories->limit(3)->orderBy('created_at', '-1')->get();
    return view('introduce-food', [
        'page' => 'introduce-food',
        'histories' => $histories,
        'keywords' => '',
        'description' => '',
        'pageCount' => 1,
        'pageNow' => 1,
        'title' => '',
        'type' => 'funny',
        'item' => $item,
    ]);
});

Route::get('/introduce-popular/{id}', function ($id) {
    $item = App\EditItem::find($id);
    $history = new App\BrowserHistories;
    if (Session::get('member.isLogin')) {
        $history->user_id = Session::get('member.id');
    } else {
        $history->session_id = Session::getId();
    }
    $history->point = $item->point;
    $history->type = 'item';
    $history->history_id = $item->id;
    $history->save();

    if (Session::get('member.isLogin')) {
        $histories = App\BrowserHistories::where('user_id', Session::get('member.id'));
    } else {
        $histories = App\BrowserHistories::where('session_id', Session::getId());
    }
        $histories = $histories->limit(3)->orderBy('created_at', '-1')->get();
    return view('introduce-food', [
        'page' => 'introduce-food',
        'histories' => $histories,
        'keywords' => '',
        'description' => '',
        'pageCount' => 1,
        'pageNow' => 1,
        'title' => '',
        'type' => 'popular',
        'item' => $item,
    ]);
});

Route::get('/search-food', ['uses'=>'SearchController@getFood']);
Route::get('/search-trafic', ['uses'=>'SearchController@getTrafic']);
Route::get('/search-funny', ['uses'=>'SearchController@getFunny']);
Route::get('/search-popular', ['uses'=>'SearchController@getPopular']);


// 會員專區：帳戶資料
Route::get('/member-account', function () {
    $member = App\Member::find(Session::get('member.id'));
    if ($member) {
        return view('member-account', [
            'member' => $member,
            'company' => App\Company::get(['name']),
            'page' => 'member-account',
            'keywords' => '',
            'description' => '',
            'pageCount' => 1,
            'pageNow' => 1,
            'title' => '',
        ]);
    } else {
        return redirect('/?msg=need_login');
    }
});

Route::post('/save-member-account', function (Request $request) {
    $member = App\Member::find(Session::get('member.id'));
    if ($member) {
        if ($request->input('password')) {
            $member->gm_pwd = md5($request->input('password'));
        }
        $member->gm_gender = $request->input('gm_gender');
        $member->gm_birth = $request->input('year').'-'.$request->input('month').'-'.$request->input('day');
        $member->gm_birth = $request->input('year').'-'.$request->input('month').'-'.$request->input('day');
        $member->gm_fulladdress = $request->input('gm_fulladdress');
        $member->company = $request->input('company');
        $member->introducer = $request->input('introducer');
        $member->save();
    }
    return view('member-account', [
        'member' => $member,
        'company' => App\Company::get(['name']),
        'page' => 'member-account',
        'keywords' => '',
        'description' => '',
        'pageCount' => 1,
        'pageNow' => 1,
        'title' => '',
    ]);});


// 會員專區：點數交易
Route::get('/member-point-use', function () {
    return view('member-point-use', [
        'page' => 'member-point-use',
        'keywords' => '',
        'description' => '',
        'pageCount' => 1,
        'pageNow' => 1,
        'title' => '',
    ]);
});

// 會員專區：儲值紀錄
Route::get('/member-point-record', function () {
    $credits = App\Credit::where('user_id', Session::get('member.id'))->get();

    return view('member-point-record', [
        'page' => 'member-point-record',
        'credits' => $credits,
        'keywords' => '',
        'description' => '',
        'pageCount' => 1,
        'pageNow' => 1,
        'title' => '',
    ]);
});

// 會員專區：點數儲值
Route::get('/member-point-buy', function () {
    return view('member-point-buy', [
        'page' => 'member-point-buy',
        'keywords' => '',
        'description' => '',
        'pageCount' => 1,
        'pageNow' => 1,
        'title' => '',
    ]);
});

// 會員專區：點數轉贈
Route::get('/member-point-give', function () {
    $member = App\Member::where('gm_mobile', Session::get('member.mobile'))->first();
    if (!$member) {
        return redirect(explode('?', redirect()->back()->getTargetUrl())[0].'?msg=need_login');
    }
    if (!$member->gm_cardId) {
        return redirect(explode('?', redirect()->back()->getTargetUrl())[0].'?msg=notRegister');
    }
    return view('member-point-give', [
        'page' => 'member-point-give',
        'keywords' => '',
        'description' => '',
        'title' => '',
    ]);
});

// 會員專區：我的收藏（住宿）
Route::get('/member-favorite-hotel', ['uses'=>'FavoriteController@getFavoriteHotel']);
Route::get('/member-favorite-food', ['uses'=>'FavoriteController@getFavoriteFood']);
Route::get('/member-favorite-trafic', ['uses'=>'FavoriteController@getFavoriteTrafic']);
Route::get('/member-favorite-funny', ['uses'=>'FavoriteController@getFavoriteFunny']);


// 會員專區：我的訂單（住宿）
Route::get('/member-order-hotel/{status}', function ($status) {
    $statusArr = ['pending', 'ready', 'done', 'cancel'];
    if (!in_array($status, $statusArr)) {
        abort(404);
    }

    switch ($status) {
        case 'pending':
            $roomOrder = App\RoomOrder::where('status', '!=', 2)->where('trans_status', 0);
            break;
        case 'ready':
            $roomOrder = App\RoomOrder::where('status', 0)->where('end_day', '>', Carbon\Carbon::now());
            break;
        case 'done':
            $roomOrder = App\RoomOrder::where('status', 1)->where('trans_status', 1)->where('end_day', '<', Carbon\Carbon::now());
            break;
        case 'cancel':
            $roomOrder = App\RoomOrder::where('status', '!=', 2);
            break;
    }


    if ($status == 'pending') {
        $roomOrder = $roomOrder->where('phone', Session::get('member.mobile'))
                               ->orderBy('created_at', 'ASC');
    } else {
        $roomOrder = $roomOrder->where('phone', Session::get('member.mobile'))
                               ->orderBy('created_at', 'DESC');
    }
    $roomOrder = $roomOrder->select( array('end_day', 'start_day', 'id', DB::Raw('DATE(created_at) day')))
                           ->get()
                           ->groupBy('day');

    $week = ['日', '一', '二', '三', '四', '五', '六'];
    return view('member-order-hotel', [
        'page' => 'member-order-hotel',
        'week' => $week,
        'roomOrder' => $roomOrder,
        'status' => $status,
        'keywords' => '',
        'description' => '',
        'pageCount' => 1,
        'pageNow' => 1,
        'title' => '',
    ]);
});

// 靜態頁面：品味玩家
Route::get('/about', function () {
    return view('about', [
        'page' => 'about',
        'keywords' => '',
        'description' => '',
        'title' => '',
    ]);
});

// 靜態頁面：聯絡我們
Route::get('/contact', function () {
    return view('contact', [
        'page' => 'contact',
        'keywords' => '',
        'description' => '',
        'title' => '',
    ]);
});

// 靜態頁面：隱私權政策
Route::get('/privacy', function () {
    return view('privacy', [
        'page' => 'privacy',
        'keywords' => '',
        'description' => '',
        'title' => '',
    ]);
});

// 靜態頁面：使用條款
Route::get('/terms', function () {
    return view('terms', [
        'page' => 'terms',
        'keywords' => '',
        'description' => '',
        'title' => '',
    ]);
});


//backstage
Route::controller('admin/login', 'LoginController');

Route::group(['middleware' => 'auth'], function () {
    Route::get('admin', function () {
        return view('layout.table');
    });

    Route::get('admin/order', function () {
        $roomOrder = App\RoomOrder::get();
        $status = ['訂單確認', '訂單成立', '訂單無效', '付款完成', '要求退款', '退款完成', '確認入住'];
        return view('admin.order-manage.order', ['orders' => $roomOrder, 'status' => $status]);
    });

    Route::get('admin/order-pending', function () {
        $roomOrder = App\RoomOrder::where('status', 0)->get();
        $status = ['訂單確認', '訂單成立', '訂單無效', '付款完成', '要求退款', '退款完成', '確認入住'];
        return view('admin.order-manage.order', ['orders' => $roomOrder, 'status' => $status]);
    });

    Route::get('admin/order-need', function () {
        $roomOrder = App\NeedRoomOrder::get();
        return view('admin.order-manage.order-need', ['orders' => $roomOrder]);
    });

    Route::controller('admin/manage-item', 'ManageItemController');
    Route::controller('admin/member', 'MemberController');
    Route::controller('admin/manage-hotel', 'ManageHotelController');
    Route::controller('admin/edit-item', 'EditItemController');
    Route::controller('admin/edit-hotel', 'EditHotelController');
    Route::post('admin/edit-item', ['as'=>'dropzone.store','uses'=>'EditItemController@postTodb']);
    Route::get('admin/setting-banner', ['uses' => 'ThemeController@listBanner']);
    Route::get('admin/edit-theme/add-banner', ['uses' => 'ThemeController@addBanner']);
    Route::post('admin/todb-banner', ['uses'=>'ThemeController@postTodb']);
    Route::get('admin/edit-theme/edit-banner/{id}', ['uses' => 'ThemeController@editBanner']);

    Route::get('/admin/order-detail/{order_id}', function ($order_id) {
        $orders = App\RoomOrderDetail::where('order_id', $order_id)->get(['name_zh-tw', 'point', 'order_id', 'hotel_id', 'sum_point', 'room_id']);
        $sum = $orders->sum('sum_point');
        $log = json_decode($orders[0]->order['log'], true);
        $log = ($log)? $log : [];
        return view('admin.order-manage.order-detail', ['orders' => $orders, 'sum' => $sum, 'logs' => $log]);
    });

    Route::get('/admin/order/add', function () {
        return view('admin.order-manage.order-add', ['hotels' => App\Hotel::get(), 'hotelStyle' => App\HotelStyle::where('hotel_id', 1)->get(), 'members' => App\Member::get(['gm_mobile'])]);
    });

    Route::get('/admin/point-log', function () {
        $transfers = App\Transfer::get();
        return view('admin.goldflow-manage.point-log', ['transfers' => $transfers]);
    });

    Route::get('/admin/credit-log', function () {
        $credits = App\Credit::get();
        return view('admin.goldflow-manage.credit-log', ['credits' => $credits]);
    });

    Route::get('/admin/promotion', function () {
        $promotions = App\Promotion::get();
        return view('admin.promotion.manage', ['promotions' => $promotions]);
    });

    Route::get('/admin/edit-promotion/add/', function () {
        return view('admin.promotion.add');
    });

    Route::post('/admin/todb-promotion', function(Request $request) {
        if ($request->input('id') != null) {
            $promotion = App\Promotion::find($request->id);
        } else {
            $promotion = new App\Promotion;
        }
        $promotion->code = $request->code;
        $promotion->point = $request->point;
        $promotion->save();
        return redirect("/admin/promotion");
    });

    Route::post('/admin/edit-member/todb', function(Request $request) {
        $member = App\Member::find($request->id);
        $member->remark = $request->remark;
        $member->save();
        return redirect("/admin/member/edit/{$member['id']}");
    });

    Route::post('/admin/edit-order-detail/save', function (Request $request) {
        $input = $request->all();
        $order = App\RoomOrder::find($input['id']);
        $order['status'] = $input['status'];
        $order['remark'] = $input['remark'];
        // $order['trans_status'] = $input['trans_status'];
        $order['check_amount'] = $input['check_amount'];
        $log = json_decode($order['log'], true);
        $log[] = ['user' => Auth::user()['name'], 'remark' => $input['remark'], 'status' => $input['status'], 'time' => Carbon\Carbon::now()->toDateTimeString()];
        $order['log'] = json_encode($log);
        $order['code'] = $input['code'];
        $order->save();
        return redirect("/admin/order-detail/{$input['id']}");
    });

    Route::post('/admin/edit-need-order-detail/save', function (Request $request) {
        $input = $request->all();
        $order = App\NeedRoomOrder::find($input['id']);
        $order['status'] = $input['status'];
        $order['remark'] = $input['remark'];
        $order->save();
        return redirect("/admin/order-need-detail/{$input['id']}");
    });

    Route::post('/admin/promotion/status-change', function (Request $request) {
        $promotion = App\Promotion::find($request->id);
        $promotion['status'] = $request->status;
        $promotion->save();
        return [true];
    });

    Route::get('/admin/edit-promotion/{id}', function ($id) {
        $promotion = App\Promotion::find($id);
        return view('admin.promotion.edit', ['promotion' => $promotion]);
    });

    Route::get('/admin/festival/list', ['uses' => 'FestivalController@list']);
    Route::get('/admin/edit-festival/add', ['uses' => 'FestivalController@add']);
    Route::post('/admin/todb-festival', ['uses' => 'FestivalController@todb']);
    Route::post('/admin/festival/status-change', ['uses' => 'FestivalController@saveStatusChange']);
    Route::get('/admin/edit-festival/edit/{i}', ['uses' => 'FestivalController@edit']);
    Route::get('/admin/edit-fesival_room_setting/{room}/{id}', ['uses' => 'FestivalController@editRoomMoney']);
    Route::get('/admin/add-fesival_room_setting/{room}', ['uses' => 'FestivalController@addRoomMoney']);

    Route::post('admin/todb-festival-room-setting', ['uses' => 'FestivalController@todbSettingMoney']);

    Route::get('/admin/thrift/list', ['uses' => 'ThriftController@list']);
    Route::get('/admin/edit-thrift/add', ['uses' => 'ThriftController@add']);
    Route::post('/admin/todb-thrift', ['uses' => 'ThriftController@todb']);
    Route::get('/admin/thrift-partner/list', ['uses' => 'ThriftController@listPartner']);
    Route::get('/admin/edit-thrift/edit/{i}', ['uses' => 'ThriftController@edit']);
    Route::post('/admin/thrift/status-change', ['uses' => 'ThriftController@saveStatusChange']);

    Route::get('/admin/edit-thrift-partner/add', ['uses' => 'ThriftController@addPartner']);
    Route::post('/admin/todb-thrift-partner', ['uses' => 'ThriftController@todbPartner']);
    Route::post('/admin/thrift/partner-status-change', ['uses' => 'ThriftController@savePartnerStatusChange']);
    Route::get('/admin/edit-thrift-partner/edit/{i}', ['uses' => 'ThriftController@editPartner']);
    Route::post('/admin/festival/getFestival', function(Request $request){
        return App\Festival::find($request->id);
    });
    
    Route::get('/admin/message/default-manage', ['uses' => 'MessageController@listDefaultManage']);
    Route::get('/admin/edit-default-manage/add', ['uses' => 'MessageController@addDefaultManage']);
    Route::get('/admin/edit-default-manage/edit/{id}', ['uses' => 'MessageController@editDefaultManage']);
    Route::post('/admin/edit-default-message/todb', ['uses' => 'MessageController@todbDefaultManage']);
    Route::get('/admin/message/send', ['uses' => 'MessageController@list']);
    Route::get('/admin/edit-message-send/add', ['uses' => 'MessageController@add']);
    Route::post('/admin/message/getDefaultMessage', function(Request $request){
        return App\DefaultMessage::find($request->id);
    });
    Route::post('/admin/send-message/todb', ['uses' => 'MessageController@todb']);

    Route::post('/admin/getHotelStyle', function(Request $request){
        return App\HotelStyle::where('hotel_id', $request->id)->get();
    });

    Route::post('/admin/getMember', function(Request $request){
        return App\Member::where('gm_mobile', $request->phone)->first();
    });

    Route::post('/admin/calculateAmount', ['uses' => 'OrderController@calculateAmount']);
    Route::post('/admin/order/hotelOrderTodb', ['uses' => 'OrderController@hotelOrderTodb']);
    Route::get('/admin/order-need/add', function(Request $request){
        return view('admin.order-manage.order-need-add', ['hotels' => App\Hotel::get(), 'hotelStyle' => App\HotelStyle::where('hotel_id', 1)->get(), 'members' => App\Member::get(['gm_mobile'])]);
    });

    Route::post('/admin/order/hotelNeedOrderTodb', ['uses' => 'OrderController@hotelNeedOrderTodb']);
    Route::post('/admin/order/needToOrder', ['uses' => 'OrderController@needToOrder']);

    Route::get('/admin/order-need-detail/{order_id}', function ($order_id) {
        $orders = App\RoomOrderDetail::where('need_order_id', $order_id)->get(['name_zh-tw', 'point', 'hotel_id', 'sum_point', 'need_order_id']);
        $sum = $orders->sum('sum_point');
        return view('admin.order-manage.order-need-detail', ['orders' => $orders, 'sum' => $sum]);
    });

    Route::post('/admin/changeHotelStyle', function (Request $request) {
        $room = App\HotelStyle::find($request->room_select_id);
        $url = explode('/', redirect()->back()->getTargetUrl());
        array_pull($url, count($url) - 1);
        $url = implode('/', $url);
        return redirect($url.'/'.$room['id']);
    });

    Route::get('/admin/news/list', function (Request $request) {
        $news = App\News::get();
        return view('admin.news.list', ['news' => $news]);
    });

    Route::get('/admin/edit-news/add', function (Request $request) {
        return view('admin.news.add');
    });

    Route::get('/admin/edit-news/edit/{id}', function ($id) {
        return view('admin.news.edit', ['new' => App\News::find($id)]);
    });

    Route::post('/admin/todb-news', function (Request $request) {
        if ($request->id != -1) {
            $news = App\News::find($request->id);
        } else {
            $news = new App\News;
        }
        foreach ($request->only('content', 'title') as $key => $value) {
            $news[$key] = $value;
        }
        $news->save();
        return redirect('/admin/news/list');
    });

    Route::post('/admin/manage-news/status-change', function (Request $request) {
        $news = App\News::find($request->id);
        foreach ($request->only('status') as $key => $value) {
            $news[$key] = $value;
        }
        $news->save();
    });

    Route::get('/admin/mail/list', function (Request $request) {
        $mails = App\Mail::get();
        foreach ($mails as $key => &$value) {
            $value['user_count'] = count(json_decode($value['user']));
        }
        return view('admin.mail.list', ['mails' => $mails]);
    });

    Route::get('/admin/edit-mail/add', function (Request $request) {
        $user = App\Member::get(['gm_mobile', 'id']);
        return view('admin.mail.add', ['users' => $user]);
    });

    Route::get('/admin/edit-mail/edit/{id}', function ($id) {
        $mail = App\Mail::find($id);
        $user = App\Member::whereIn('id', json_decode($mail['user'], true))->get();
        return view('admin.mail.edit', ['mail' => App\Mail::find($id), 'user' => $user]);
    });

    Route::post('/admin/todb-mail', function (Request $request) {
        if ($request->id != -1) {
            $mail = App\Mail::find($request->id);
        } else {
            $mail = new App\Mail;
        }
        foreach ($request->only('content', 'title', 'user') as $key => $value) {
            if ($key == 'user') {
                $value = json_encode($value);
            }
            $mail[$key] = $value;
        }
        $mail->save();
        return redirect('/admin/mail/list');
    });

    Route::post('/admin/getMessageContent', function (Request $request) {
        $message = App\Message::find($request->id);
        return $message;
    });
    
    Route::post('/admin/replicateHotelStyle/', ['uses' => 'EditHotelController@replicateHotelStyle']);
});

Route::get('uploads/{item_type}/{id}/{filename}', function ($item_type, $id, $filename)
{
    $path = storage_path("app/uploads/{$item_type}/{$id}/{$filename}");

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
