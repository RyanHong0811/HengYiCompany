// Generated by CoffeeScript 1.10.0
var app;

Vue.component("withdraw-welcome-component", {
  template: '<div class="modal-header"> <h3 class="modal-title">提取至銀行帳戶</h3> </div> <div class="modal-box"> <ul class="steps step-sm" style="margin: 1rem 0;"> <li class="step-sm-item active">提取說明</li> <li class="step-sm-item">填寫提取額</li> <li class="step-sm-item">確認提取內容</li> <li class="step-sm-item">完成提取</li> </ul> <p>您可以利用這個功能將帳戶裡的餘額提現至您的銀行帳戶。以下是一些相關的注意事項：</p> <ol class="kui-list"> <li>本服務最低提款額為 <strong class="text-focus">100 美元</strong> (或其他等值幣種)</li> <li>您需要在執行本功能前進行銀行帳戶綁定，請至 <strong class="text-focus">個人資料</strong> 裡 <strong class="text-focus">我要修改…</strong> 選擇 <strong class="text-focus">銀行帳戶</strong> 進行設定。</li> <li>本公司匯出時並不額外扣除手續費，惟銀行端可能會有相對應費用<br>如：<strong class="text-focus">銀行匯出手續費、中轉銀行手續費、收款銀行手續費及匯差</strong></li> <li>為減少手續費支出，建議您可以使用在我們有設立帳戶的地區的銀行帳戶</li> <li>本公司將會在匯出後，附上<strong class="text-focus">匯款指示(收據)</strong>給您進行參考及查帳，這樣如果有任何問題較易可和銀行調到相關信息</li> <li>若轉帳時發生問題，請連絡我們華都集團的行政或您的主管</li> </ol> </div> <div class="modal-footer"> <button type="submit" @click="goNextStep" class="btn color-primary size-lg"><i class="fa fa-fw fa-check"></i>&nbsp;我已了解轉帳說明</button> <a class="btn pull-right" @click="hideModal"><i class="fa fa-times fa-fw"></i>&nbsp;取消操作</a> </div>',
  methods: {
    hideModal: function() {
      return app.hideModal();
    },
    goNextStep: function() {
      return app.currentView = "withdraw-amountInput-component";
    }
  }
});

Vue.component("withdraw-amountInput-component", {
  template: '<div class="modal-header"> <h3 class="modal-title">提取至銀行帳戶</h3> </div> <div class="modal-box"> <ul class="steps step-sm" style="margin: 1rem 0;"> <li class="step-sm-item">提取說明</li> <li class="step-sm-item active">填寫提取額</li> <li class="step-sm-item">確認提取內容</li> <li class="step-sm-item">完成提取</li> </ul> <p>請輸入您要提取的金額</p> <div class="input-grp"> <span class="adorn">{{ current_currency }}</span> <input type="number" step="0.01" :min="minimumAmount" v-model="amount" max="{{ current_balance }}" class="ctrl-input" /> </div> <p class="help-block">可提取總額： <strong>{{ current_currency }} {{ current_balance }}</strong></p> </div> <div class="modal-footer"> <button type="submit" @click="goNextStep" class="btn color-primary size-lg"><i class="fa fa-fw fa-check"></i>&nbsp;我已確認數額</button> <a class="btn pull-right" @click="hideModal"><i class="fa fa-times fa-fw"></i>&nbsp;取消操作</a> </div>',
  data: function() {
    return {
      current_currency: current_currency,
      current_balance: current_balance,
      amount: 0.00
    };
  },
  computed: {
    minimumAmount: function() {
      if (this.current_currency === "USD") {
        return 100;
      }
      if (this.current_currency === "HKD") {
        return 780;
      }
    }
  },
  ready: function() {
    return this.amount = this.minimumAmount;
  },
  methods: {
    hideModal: function() {
      return app.hideModal();
    },
    goNextStep: function() {
      if (this.amount > current_balance) {
        alert("您輸入的金額大於可提取總額，請確認後重新確認");
        return;
      }
      if (this.amount < this.minimumAmount) {
        alert("您輸入的金額低於最低提款額，請等累積到一定數額再進行提取。\n\n若有一定要提取的情形，請和我們的行政詢問");
        return;
      }
      app.currentView = "withdraw-confirm-component";
      return app.amount = this.amount;
    }
  }
});

Vue.component("withdraw-confirm-component", {
  template: '<div class="modal-header"> <h3 class="modal-title">提取至銀行帳戶</h3> </div> <div class="modal-box"> <ul class="steps step-sm" style="margin: 1rem 0;"> <li class="step-sm-item">提取說明</li> <li class="step-sm-item">填寫提取額</li> <li class="step-sm-item active">確認提取內容</li> <li class="step-sm-item">完成提取</li> </ul> <p>請確認以下提款數額和受款銀行帳號，並操作下方的簡訊驗証以資查核。</p> <div class="columns-12 transfer_instr"> <div class="col-5"> <p class="balance_number"> <strong>{{ current_currency }}</strong> {{ amount }} </p> </div> <div class="col-1"> <i class="fa fa-arrow-right fa-fw"></i> </div> <div class="col-6"> <p class="receiver_bank"> <strong>{{ bank.name }}</strong> ({{ bank.swift }})<br> {{ bank.account }}<br> {{ bank.account_name }} </p> </div> </div> <p>若以上資料沒錯，請進行以下簡訊驗證作為交易驗證。</p> <div class="columns-12"> <div class="col-4">1. 取得簡訊驗證碼</div> <div class="col-8"> <a class="btn" @click="submitWithdraw" v-if="!disableSMSButton"><i class="fa fa-fw fa-mobile"></i>&nbsp;索取簡訊認證碼</a> <a class="btn" @click="submitWithdraw" disabled v-if="disableSMSButton"><i class="fa fa-fw fa-history"></i>&nbsp;{{ tick }} 秒後可以再寄送</a> </div> </div> <div class="columns-12"> <div class="col-4">2. 輸入簡訊驗證碼</div> <div class="col-8"><input type="number" step="1" maxlength="6" v-model="pin" width="6" style="width: 7rem;" class="ctrl-input" required /></div> </div> <div class="bg-focus" style="padding: 1rem;" v-if="msg">{{ msg }}</div> </div> <div class="modal-footer"> <button type="submit" @click="submitVaildatePIN" :disabled="disableWithdrawButton" class="btn color-primary size-lg"><i class="fa fa-fw fa-credit-card"></i>&nbsp;進行轉帳</button> <a class="btn pull-right" @click="hideModal"><i class="fa fa-times fa-fw"></i>&nbsp;取消操作</a> </div>',
  ready: function() {
    console.log(app.amount);
    this.amount = app.amount;
    return this.msg = app.msg;
  },
  data: function() {
    return {
      bank: {
        name: bank_name,
        swift: bank_swift_code,
        address: bank_address,
        account: bank_account,
        account_name: bank_account_name
      },
      amount: 0.00,
      current_currency: current_currency,
      pin: "",
      issue_id: null,
      msg: "",
      tick: null
    };
  },
  computed: {
    disableWithdrawButton: function() {
      return this.issue_id === null;
    },
    disableSMSButton: function() {
      return this.tick !== null;
    }
  },
  methods: {
    hideModal: function() {
      return app.hideModal();
    },
    submitVaildatePIN: function() {
      var self;
      self = this;
      return $.post("/api/user/wallet/withdraw", {
        issue_id: this.issue_id,
        pin: this.pin
      }).done(function(data) {
        if (data.meta.status !== 200) {
          self.msg = data.meta.msg;
          return;
        }
        return app.currentView = "withdraw-done-component";
      });
    },
    tickSMS: function() {
      if (this.tick <= 1) {
        return this.tick = null;
      }
      this.tick--;
      return setTimeout(this.tickSMS, 1000);
    },
    submitWithdraw: function() {
      var self;
      self = this;
      return $.post("/api/user/wallet/withdraw", {
        amount: app.amount,
        currency: current_currency
      }).done(function(data) {
        if (data.meta.status !== 200) {
          this.msg = data.meta.msg;
          return;
        }
        self.issue_id = data.results.issue_id;
        self.disableSMSButton = true;
        self.tick = 60;
        return setTimeout(self.tickSMS, 1000);
      });
    }
  }
});

Vue.component("withdraw-done-component", {
  template: '<div class="modal-header"> <h3 class="modal-title">提取至銀行帳戶</h3> </div> <div class="modal-box"> <ul class="steps step-sm" style="margin: 1rem 0;"> <li class="step-sm-item">提取說明</li> <li class="step-sm-item">填寫提取額</li> <li class="step-sm-item ">確認提取內容</li> <li class="step-sm-item active">完成提取</li> </ul> <p>已完成轉帳的動作</p> <div class="columns-12 transfer_instr"> <div class="col-5"> <p class="balance_number"> <strong>{{ current_currency }}</strong> {{ amount }} </p> </div> <div class="col-1"> <i class="fa fa-arrow-right fa-fw"></i> </div> <div class="col-6"> <p class="receiver_bank"> <strong>{{ bank.name }}</strong> ({{ bank.swift }})<br> {{ bank.account }}<br> {{ bank.account_name }} </p> </div> </div> </div> <div class="modal-footer"> <button @click="pageRefresh" class="btn color-primary size-lg"><i class="fa fa-fw fa-check"></i>&nbsp;關閉本頁</button> </div>',
  methods: {
    pageRefresh: function() {
      return window.location.reload();
    }
  },
  ready: function() {
    var self;
    self = this;
    return this.amount = app.amount;
  },
  data: function() {
    return {
      successTransfer: false,
      bank: {
        name: bank_name,
        swift: bank_swift_code,
        address: bank_address,
        account: bank_account,
        account_name: bank_account_name
      },
      amount: 0.00,
      current_currency: current_currency
    };
  }
});

app = new Vue({
  el: "body",
  data: {
    currentView: null,
    amount: 0.00
  },
  computed: {
    modalEnabled: function() {
      return this.currentView !== null;
    }
  },
  methods: {
    showBankModal: function() {
      return this.currentView = "withdraw-welcome-component";
    },
    hideModal: function() {
      app.currentView = null;
      return app.amount = 0.00;
    }
  }
});