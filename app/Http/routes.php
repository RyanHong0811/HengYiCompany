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

Route::get('/', function () {
    return view('homepage.index', ['menu' => '']);
});

Route::get('/about', function () {
    return view('homepage.about', ['menu' => 'about']);
});

Route::get('/companies', function () {
    return view('homepage.companies', ['menu' => 'companies']);
});

Route::get('/investor', function () {
    return view('homepage.investor', ['menu' => 'investor']);
});

Route::get('/login', function (Request $request) {
    return view('layout.login');
});

Route::get('/test', function (Request $request) {
    return bcrypt('xzc111');
});

Route::post('/login', function (Request $request) {
    if (Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {
        $user = App\User::where('username', $request->input('username'))->first();
        if ($user['type'] == 2) {
            Session::put('member.isLogin', 1);
            Session::put('member.username', $user['username']);
            return redirect('/user');
        } else {
            Session::put('member.isLogin', 1);
            Session::put('member.username', $user['username']);
            Session::put('member.name', $user['name']);
            Session::put('member.name_en', $user['name_en']);
            return redirect('/admin');
        }
    }
    return view('layout.login', ['error' => 1]);
});


Route::group(['middleware' => 'user'], function () {
    Route::get('/user/contracts', function (Request $request) {
        $end_contract = App\Contract::where('user_id', $request->user['id'])->where('end_day', '<=', Carbon\Carbon::today()->toDateString())->get();
        $start_contract = App\Contract::where('user_id', $request->user['id'])->where('end_day', '>=', Carbon\Carbon::today()->toDateString())->get();

        return view('backend.customer.contracts', ['user' => $request->user, 'menu' => 'contracts', 'end_contract' => $end_contract, 'start_contract' => $start_contract]);
    });

    Route::get('/user/announcements', function (Request $request) {
        $announcement = App\Announcement::get();
        return view('backend.customer.announcements', ['user' => $request->user, 'menu' => 'announcements', 'announcement' => $announcement]);
    });

    Route::get('/user/wallet', function (Request $request) {
        return view('backend.customer.wallet', ['user' => $request->user, 'menu' => 'wallet']);
    });

    Route::get('/user/profile', function (Request $request) {
        return view('backend.customer.profile', ['user' => $request->user, 'menu' => 'profile']);
    });

    Route::get('/user/dashboard', function (Request $request) {
        $announcement = App\Announcement::limit(2)->get();
        return view('backend.customer.dashboard', ['user' => $request->user, 'menu' => 'dashboard', 'announcement' => $announcement]);
    });

    Route::get('/user/', function (Request $request) {
        $announcement = App\Announcement::limit(2)->get();
        return view('backend.customer.dashboard', ['user' => $request->user, 'menu' => 'dashboard', 'announcement' => $announcement]);
    });

    Route::get('/user/announcement/{id}', function ($id, Request $request) {
        $announcement = App\Announcement::find($id);
        return view('backend.customer.announcements-content', ['user' => $request->user, 'menu' => 'announcements', 'announcement' => $announcement]);
    });


    Route::get('/user/contract/{id}', function ($id, Request $request) {
        $contract = App\Contract::find($id);
        $contract_year = Carbon\Carbon::parse($contract['start_day'])->diffInYears(Carbon\Carbon::parse($contract['end_day']));
        $contract_month = Carbon\Carbon::parse($contract['start_day'])->diffInMonths(Carbon\Carbon::parse($contract['end_day']));
        $next_month = Carbon\Carbon::today()->addMonth();
        $next_month->day = 15;
        $every_month_amount = $contract['amount']/100/$contract_month * $contract['rate'];

        return view('backend.customer.contract-content', [
                                                        'menu' => 'contracts', 
                                                        'contract' => $contract, 
                                                        'contract_year' => $contract_year, 
                                                        'next_month' => $next_month->toDateString(),
                                                        'user' => $request->user,
                                                        'every_month_amount' => $every_month_amount
                                                    ]);
    });
});


Route::group(['middleware' => 'admin'], function () {

    Route::get('/admin/', function () {
        $announcement = App\Announcement::get();
        return view('backend.admin.announcements', ['menu' => 'announcements', 'announcement' => $announcement]);
    });

    Route::get('/admin/announcements', function () {
        $announcement = App\Announcement::get();
        return view('backend.admin.announcements', ['menu' => 'announcements', 'announcement' => $announcement]);
    });

    Route::get('/admin/announcement/{id}', function ($id) {
        $announcement = App\Announcement::find($id);
        return view('backend.admin.announcements-content', ['menu' => 'announcements', 'announcement' => $announcement]);
    });

    Route::get('/admin/contracts', function () {
        $end_contract = App\Contract::where('end_day', '<=', Carbon\Carbon::today()->toDateString())->get();
        $start_contract = App\Contract::where('end_day', '>=', Carbon\Carbon::today()->toDateString())->get();

        return view('backend.admin.contracts', ['menu' => 'contracts', 'end_contract' => $end_contract, 'start_contract' => $start_contract]);
    });

    Route::get('/admin/contract/{id}', function ($id) {
        $contract = App\Contract::find($id);
        $contract_year = Carbon\Carbon::parse($contract['start_day'])->diffInYears(Carbon\Carbon::parse($contract['end_day']));
        $contract_month = Carbon\Carbon::parse($contract['start_day'])->diffInMonths(Carbon\Carbon::parse($contract['end_day']));
        $next_month = Carbon\Carbon::today()->addMonth();
        $next_month->day = 15;
        $every_month_amount = $contract['amount']/100/$contract_month * $contract['rate'];
        return view('backend.admin.contract-content', [
                                                        'menu' => 'contracts', 
                                                        'contract' => $contract, 
                                                        'contract_year' => $contract_year, 
                                                        'next_month' => $next_month->toDateString(),
                                                        'every_month_amount' => $every_month_amount
                                                    ]);
    });


    Route::get('/admin/clients', function () {
        $user = App\User::where('type', 2)->get();
        return view('backend.admin.clients', ['menu' => 'clients', 'users' => $user]);
    });

    Route::get('/admin/create/client', function () {
        return view('backend.admin.create-client', ['menu' => 'create-client']);
    });

    Route::get('/admin/create/contract', function () {
        $user = App\User::where('type', 2)->get();
        return view('backend.admin.create-contract', ['menu' => 'create-contract', 'users' => $user]);
    });

    Route::get('/admin/create/announcements', function () {
        return view('backend.admin.create-annoucements', ['menu' => 'create-announcement']);
    });

    Route::get('/admin/client/{id}', function ($id) {
        $user = App\User::find($id);
        $contract = App\Contract::where('user_id', $id)->get();
        return view('backend.admin.client-content', ['menu' => 'clients', 'user' => $user, 'contracts' => $contract]);
    });


    Route::post('/admin/create/contract', function (Request $request) { 
        $input = $request->only('rate','amount', 'user_id');
        $contract = new App\Contract;
        foreach ($input as $key => $value) {
            $contract[$key] = $value;
        }
        $contract->start_day = Carbon\Carbon::today()->toDateString();
        $contract->end_day = Carbon\Carbon::today()->addYear()->toDateString();
        $contract->save();
        return redirect('/admin/contracts');
    });

    Route::post('/admin/create/announcements', function (Request $request) { 
        $input = $request->only('content','title');
        $announcement = new App\Announcement;
        foreach ($input as $key => $value) {
            $announcement[$key] = $value;
        }
        $announcement->save();
        return redirect('/admin/announcements');
    });

    Route::post('/admin/create/client', function (Request $request) { 
        $input = $request->only("username", "password", 'address', "name", "name_en", "email", "phone", "bank_name", "bank_name_en", "bank_address", "bank_account", "bank_user_name");
        $input['password'] = bcrypt($input['password']);
        $user = new App\User;
        foreach ($input as $key => $value) {
            $user[$key] = $value;
        }
        $user->type = 2;
        $user->save();
        return redirect('/admin/clients');
    });
});

Route::get('/logout', function() {
    Session::pull('member');
    return redirect('/');
});