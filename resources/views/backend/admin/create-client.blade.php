@extends('layout.admin')
@section('main-content')
<div class="main_content">
    <div class="container">
		<div class="columns-7">
		    <div class="col-7">
		        <h1>新增投資人帳戶</h1>
		        <p>要新增投資人帳戶，請在下面填入所需資料。</p>

		        <p class="bg-focus" style="padding: 1rem;"><strong><i class="fa fa-fw fa-warning"></i> 注意：</strong>&nbsp;請勿輸入重複的帳號以及密碼，如有此情況發生請立即洽詢工程師</p>

		        <form class="form-horizontal" method="POST" action="/admin/create/client"  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

		            <div class="columns-12 bank_info_box">
		                <div class="col-6">
		                    <h3>帳號資訊</h3>

		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">帳號</label>
		                        <div class="ctrls col-8">
		                            <input type="text" name="username" class="ctrl-input" required>
		                        </div>
		                    </div>

		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">密碼</label>
		                        <div class="ctrls col-8">
		                            <input type="text" name="password" class="ctrl-input" placeholder="" required>
		                        </div>
		                    </div>

		                    <h3>投資人信息</h3>


		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">名字</label>
		                        <div class="ctrls col-8">
		                            <input type="text" name="name" class="ctrl-input" required>
		                        </div>
		                    </div>

		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">名字 - 英文</label>
		                        <div class="ctrls col-8">
		                            <input type="text" name="name_en" class="ctrl-input" required>
		                        </div>
		                    </div>

		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">電子信箱</label>
		                        <div class="ctrls col-8">
		                            <input type="email" name="email" class="ctrl-input" required>
		                        </div>
		                    </div>


		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">聯絡電話</label>
		                        <div class="ctrls col-8">
		                            <input type="tel" name="phone" class="ctrl-input" required>
		                        </div>
		                    </div>

		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">地址</label>
		                        <div class="ctrls col-8">
		                            <input type="text" name="address" class="ctrl-input" required>
		                        </div>
		                    </div>
		                </div>
		                <div class="col-6">
		                <div class="col-6">
		                    <h3>銀行資訊</h3>

		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">銀行名稱</label>
		                        <div class="ctrls col-8">
		                            <input type="text" name="bank_name" class="ctrl-input" required>
		                        </div>
		                    </div>

		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">銀行名稱 - 英文</label>
		                        <div class="ctrls col-8">
		                            <input type="text" name="bank_name_en" class="ctrl-input" required>
		                        </div>
		                    </div>

		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">銀行地址</label>
		                        <div class="ctrls col-8">
		                            <input type="text" name="bank_address" class="ctrl-input" placeholder="地址" required>
		                        </div>
		                    </div>

		                    <h3>帳戶信息</h3>


		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">帳號</label>
		                        <div class="ctrls col-8">
		                            <input type="text" name="bank_account" class="ctrl-input" required>
		                        </div>
		                    </div>

		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">戶名</label>
		                        <div class="ctrls col-8">
		                            <input type="text" name="bank_user_name" class="ctrl-input" required>
		                        </div>
		                    </div>

<!-- 
		                    <div class="ctrl-grp columns-12">
		                        <label class="ctrl-label col-4">銀行卡正面</label>
		                        <div class="ctrls col-8">
		                            <input type="file" name="bank_card_image" class="ctrl-input" required>
		                        </div>
		                    </div> -->
		                </div>
		            </div>

		            <div class="ctrl-group columns-12">
		                <div class="ctrls col-10 col-offset-2">
		                    <button type="submit" class="btn size-lg color-primary">
		                        <i class="fa fa-fw fa-pencil"></i>&nbsp;
		                        新增投資人帳戶
		                    </button>
		                </div>
		            </div>
		        </form>
		    </div>
		</div>
</div>
@endsection
