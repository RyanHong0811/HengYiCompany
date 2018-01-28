// Generated by CoffeeScript 1.10.0
var app;

Vue.component("welcome-component", {
  template: '<div class="panel"> <div class="panel-box"> <p>�銁甇文�堒枂�𧋦銵典鱓�������𤌍嚗諹�𧢲�硋�坔�䔶�甈∪‵撖急�𣂷漱!</p> <div class="columns-12"> <div class="col-6"> <h2>�鰵摰Ｘ�</h2> <p style="padding-right: 3rem;">隢见��⏚�鍂銝𦠜䲮��鰵摰Ｘ��㕑酉�𠰴�蠘�質�枏恥��憛怨”<br>蝬㯄�舘�峕錇瘚�蝔�<strong>��钅�𡁜��</strong>嚗��漤�脖��躰ㄐ頛詨�亦㮾��𦦵�����鞈��𨳍��</p> </div> <div class="col-6"> <h2>��𠰴恥��</h2> <p>撠齿䲰��𠰴恥��嚗峕�典蘨��閬���𣂷�偦�𨀣䲰�𧋦甈∪�����蝝啁��朖�虾嚗峕�穃�烐���𥪜𨭌�䰻撣喃蒂��𥪜𨭌��讠�见�����</p> <ol class="kui-list"> <li>��𠰴恥����憪枏�� (靘偦�豢����虾隞亙�滨��)</li> <li>�𧋦甈∪�������煾��</li> <li>�刻�蝯血恥����撟游𥼚�祉��</li> <li>摰Ｘ���𤘪狡���𥲤甈暹�𤏸��(瘞游鱓)</li> </ol> </div> </div> </div> <div class="panel-footer"> <a @click="goSelectClientPage" class="btn size-lg color-primary"><i class="fa fa-check fa-fw"></i>&nbsp;��穃歇鈭�閫�𥼚隞嗆�蝔见�峕釣�譍�钅�</a> </div> </div>',
  methods: {
    goSelectClientPage: function() {
      app.current_step = 2;
      return app.currentView = "select-user-component";
    }
  }
});

Vue.component("select-user-component", {
  ready: function() {
    var self;
    self = this;
    return $.getJSON("/api/agent/clients").done(function(data) {
      self.$set("existing_clients", data.results.clients);
      self.in_progress = false;
      if ((app.formdata.client_id != null) && app.formdata.client_id !== null) {
        return self.existing_client_id = app.formdata.client_id;
      }
    });
  },
  data: function() {
    return {
      existing_client_id: 0,
      existing_clients: [],
      showExistingClientButton: false,
      in_progress: true
    };
  },
  computed: {
    showExistingClientSelect: function() {
      return this.existing_clients.length > 0;
    },
    disableExistingClientButton: function() {
      return this.existing_clients.length === 0;
    },
    disableExistingClientNextStepButton: function() {
      return this.existing_client_id <= 0 || this.existing_client_id === null;
    }
  },
  template: '<div class="modal" v-if="in_progress"> <div class="modal-box" style="font-size: 2rem; padding: 5rem; text-align: center;"> <h2><i class="fa fa-pulse fa-spinner fa-3x fa-fw"></i> 摰Ｘ�鞈��蹱䰻閰Ｖ葉��</h2> </div> </div> <div class="modal-overlay" v-if="in_progress"></div> <div class="panel"> <div class="panel-box"> <p>銝𧢲䲮�箸�函𤌍��滨凒頧�摰Ｘ���𡑒”嚗諹�见�硺葉�豢��𧋦甈∪𥼚隞嗥�摰Ｘ�</p> <select name="client_id" class="ctrl-input" v-model="existing_client_id" v-if="showExistingClientSelect"> <option v-for="c in existing_clients" value="{{ c.id }}">{{ c.username }} - {{ c.name_zh }} ({{ c.name_en }})</option> </select> <p v-else class="bg-focus" style="padding: 1rem;">�函𤌍��齿�埝�劐遙雿訫恥��嚗諹�见��鰵憓鮋�钅�𡁜���漤�𦒘��𥼚隞�</p> </div> <div class="panel-footer"> <a @click="fillContractConditions" :disabled="disableExistingClientNextStepButton" class="btn size-lg color-success"><i class="fa fa-arrow-right fa-fw"></i>&nbsp;憛怠神����璇苷辣</a> </div> </div>',
  methods: {
    fillContractConditions: function() {
      var self;
      self = this;
      app.formdata.client_id = parseInt(this.existing_client_id, 10);
      app.formdata.client_info = this.existing_clients.find(function(elm) {
        if (elm.id === app.formdata.client_id) {
          return elm;
        }
      });
      app.current_step = 4;
      return app.currentView = "contract-condition-component";
    }
  }
});

Vue.component("new-client-component", {
  data: function() {
    return {
      name_zh: "",
      identity_type: "",
      identity_number: "",
      identity_image: null,
      bank_card_image: null,
      in_progress: false,
      selected_identity_filename: null,
      selected_bank_card_filename: null,
      identity_error_message: null,
      bank_card_error_message: null,
      identity_number_error_message: null,
      identity_type_error_message: null,
      identity_name_zh_error_message: null
    };
  },
  ready: function() {
    this.identity_error_message = null;
    this.bank_card_error_message = null;
    this.identity_name_zh_error_message = null;
    this.identity_number_error_message = null;
    this.identity_type_error_message = null;
    this.in_progress = false;
    if (app.formdata.client != null) {
      this.name_zh = app.formdata.client.name_zh;
      this.identity_type = app.formdata.client.identity_type;
      this.identity_number = app.formdata.client.identity_number;
      this.identity_image = app.formdata.client.identity_image;
      this.selected_identity_filename = app.formdata.client.identity_image;
      this.bank_card_image = app.formdata.client.bank_card_image;
      return this.selected_bank_card_filename = app.formdata.client.bank_card_image;
    }
  },
  computed: {
    showIdentityError: function() {
      return this.identity_error_message !== null;
    },
    showBankCardError: function() {
      return this.bank_card_error_message !== null;
    },
    showIdentityNumberError: function() {
      return this.identity_name_zh_error_message !== null;
    },
    showIdentityNumberError: function() {
      return this.identity_error_message !== null;
    },
    showNameError: function() {
      return this.identity_name_zh_error_message !== null;
    },
    showRateError: function() {
      return this.rate_error_message !== null;
    },
    disableSubmitButton: function() {
      return this.in_progress === true || this.selected_identity_filename === null || this.selected_bank_card_filename === null || this.identity_error_message !== null || this.bank_card_error_message !== null;
    },
    showCurrentIdentityImageButton: function() {
      return this.identity_image !== null;
    },
    showCurrentBankCardImageButton: function() {
      return this.bank_card_image !== null;
    },
    identity_image_url: function() {
      return "/file/" + this.identity_image;
    },
    bank_card_image_url: function() {
      return "/file/" + this.bank_card_image;
    }
  },
  template: '<div class="panel"> <div class="panel-box"> <p>隢见‵�仿�嗘�齿鰵摰Ｘ����抅�𧋦鞈���</p> <p class="bg-primary" style="padding: 1rem;"><small><strong><i class="fa fa-fw fa-warning"></i>&nbsp;瘜冽�𧶏��</strong>&nbsp;�躰ㄐ銝齿糓摰峕㟲鞈��嗵�頛詨�乩�滨蔭嚗諹�见���訫�𤾸恥���秐 <a href="http://www.waldorfbullion.com/" target="_blank" style="color: #FF0;">摰䀹䲮蝬脩��</a> 憛怠神閮餃�𠺪�屸�躰ㄐ��鞈��蹱糓�箔�霈𤘪�穃�𤏸�賢�惩���䀹䲮蝬脩�嗘�羓�鞈��䠷�脰���齿��</small></p> <div class="columns-12"> <div class="col-2"><strong>銝剜���枏��</strong></div> <div class="col-3"><input v-model="name_zh" type="text" @keyup="checkFields"  length="5" class="ctrl-input"></div> <div v-if="showNameError" style="font-size: 0.8rem; color: #F00; margin: 1rem 0;"><i class="fa fa-warning fa-fw"></i>&nbsp;&nbsp;{{ identity_name_zh_error_message }}</div> </div> <h3>頨思遢���辣</h3> <div class="columns-12"> <div class="col-2"><strong>頨思遢���辣憿𧼮��</strong></div> <div class="col-3"> <select v-model="identity_type" class="ctrl-input" @onchange="checkFields"> <option value="頨思遢霅�">頨思遢霅�</option> <option value="霅瑞��">霅瑞��</option> </select> <div v-if="showIdentityTypeError" style="font-size: 0.8rem; color: #F00; margin: 1rem 0;"><i class="fa fa-warning fa-fw"></i>&nbsp;&nbsp;{{ identity_type_error_message }}</div> </div> </div> <div class="columns-12"> <div class="col-2"><strong>頨思遢���辣��毺Ⅳ</strong></div> <div class="col-3"><input v-model="identity_number" @keyup="checkFields" type="text" length="5" class="ctrl-input"></div> <div v-if="showIdentityNumberError" style="font-size: 0.8rem; color: #F00; margin: 1rem 0;"><i class="fa fa-warning fa-fw"></i>&nbsp;&nbsp;{{ identity_number_error_message }}</div> </div> <div class="columns-12"> <div class="col-2"><strong>頨思遢���辣��𣇉��</strong></div> <div class="col-8"> <file-upload name="identity_image" action="/api/uploadImage" accept="image/jpeg,image/png"><small>(���𦻖��� JPG ��� PNG)</small></file-upload> <div v-if="showCurrentIdentityImageButton" style="margin: 1rem;"> <a :href="identity_image_url" class="btn" target="_blank"><i class="fa fa-download"></i> 銝贝�㗇䰻���</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<small><strong><i class="fa fa-info-circle fa-fw"></i>&nbsp;��鞟內嚗�</strong> �典虾隞乩�𠰴�喃�撘菜鰵��靘���碶誨�𤌍��滢�𠰴�喟���𣇉��</small> </div> <div v-if="showIdentityError" style="font-size: 0.8rem; color: #F00; margin: 1rem 0;"><i class="fa fa-warning fa-fw"></i>&nbsp;&nbsp;{{ identity_error_message }}</div> </div> </div> <h3>��銵�董��鞈���</h3> <div class="columns-12"> <div class="col-2"><strong>摮䁅介��㚚�銵�㨃��𣇉��</strong></div> <div class="col-8"> <file-upload name="bank_card_image" action="/api/uploadImage" accept="image/jpeg,image/png"><small>(���𦻖��� JPG ��� PNG)</small></file-upload> <div v-if="showCurrentBankCardImageButton" style="margin: 1rem;"> <a :href="bank_card_image_url" class="btn" target="_blank"><i class="fa fa-download"></i> 銝贝�㗇䰻���</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<small><strong><i class="fa fa-info-circle fa-fw"></i>&nbsp;��鞟內嚗�</strong> �典虾隞乩�𠰴�喃�撘菜鰵��靘���碶誨�𤌍��滢�𠰴�喟���𣇉��</small> </div> <div v-if="showBankCardError" style="font-size: 0.8rem; color: #F00; margin: 1rem 0;"><i class="fa fa-warning fa-fw"></i>&nbsp;&nbsp;{{ bank_card_error_message }}</div> </div> </div> </div> <div class="panel-footer"> <a @click="goPreviousPage" class="btn-outline size-lg"><i class="fa fa-arrow-left fa-fw"></i>&nbsp;��𧼮�銝𠹺�甇�</a>&nbsp;&nbsp; <a @click="submitFormAndUpload" :disabled="disableSubmitButton" class="btn size-lg color-common"><i class="fa fa-send fa-fw"></i>&nbsp;���枂����璇苷辣</a> </div> </div> <div class="modal" v-if="in_progress"> <div class="modal-box" style="font-size: 2rem; padding: 5rem; text-align: center;"> <h2><i class="fa fa-pulse fa-spinner fa-3x fa-fw"></i> 鞈��坔�喲��銝凌��</h2> </div> </div> <div class="modal-overlay" v-if="in_progress"></div>',
  methods: {
    goPreviousPage: function() {
      var self;
      self = this;
      this.selected_identity_filename = null;
      this.selected_bank_card_filename = null;
      app.current_step = 2;
      return app.currentView = "select-user-component";
    },
    submitFormAndUpload: function() {
      this.in_progress = true;
      if (this.identity_image === null && this.bank_card_image === null) {
        return this.$broadcast("processFileUpload");
      }
      if (this.selected_identity_filename !== this.identity_image || this.selected_bank_card_filename !== this.bank_card_image) {
        return this.$broadcast("processFileUpload");
      }
      return this.checkAllFieldsUpload();
    },
    checkFields: function() {
      this.identity_error_message = null;
      this.bank_card_error_message = null;
      if (this.selected_identity_filename === null) {
        this.identity_error_message = "隢衤�𠰴�喳恥��銝𢠃𢒰����帋�贝澈隞賣��辣����𣇉��";
      }
      if (this.selected_bank_card_filename === null) {
        return this.bank_card_error_message = "隢衤�𠰴�喳恥��蝬�摰𡁶���銵�㨃��硋�䁅介��𣇉��";
      }
    },
    checkAllFieldsUpload: function() {
      if (this.identity_image === null || this.bank_card_image === null) {
        return;
      }
      app.formdata.client = {
        name_zh: this.name_zh,
        identity_type: this.identity_type,
        identity_number: this.identity_number,
        identity_image: this.identity_image,
        bank_card_image: this.bank_card_image
      };
      app.current_step = 4;
      return app.currentView = "contract-condition-component";
    }
  },
  events: {
    onAllFilesUploaded: function(data, field) {
      this[field] = parseInt(data[0], 10);
      return this.checkAllFieldsUpload();
    },
    onFileChange: function(data, input_name) {
      switch (input_name) {
        case "identity_image":
          this.selected_identity_filename = data[0].name;
          break;
        case "bank_card_image":
          this.selected_bank_card_filename = data[0].name;
      }
      return this.checkFields();
    }
  }
});

Vue.component("contract-condition-component", {
  data: function() {
    return {
      interest_yearly_rate: 6.00,
      amount: 10000,
      currency: "USD",
      receipt_image: null,
      agent_commission_rate: agent_commission_rate,
      in_progress: false,
      selected_contract_filename: null,
      file_error_message: "隢衤�𠰴�單𧋦甈∪𥲤甈曄��𤏸�� (瘞游鱓)",
      rate_error_message: null
    };
  },
  ready: function() {
    this.file_error_message = null;
    this.rate_error_message = null;
    this.in_progress = false;
    if ((app.formdata.receipt_image != null) && app.formdata.receipt_image > 0) {
      this.receipt_image = app.formdata.receipt_image;
      return this.selected_contract_filename = app.formdata.receipt_image;
    }
  },
  computed: {
    showFileError: function() {
      return this.file_error_message !== null;
    },
    showRateError: function() {
      return this.rate_error_message !== null;
    },
    disableSubmitButton: function() {
      return this.in_progress === true || this.selected_contract_filename === null || this.file_error_message !== null || this.rate_error_message !== null;
    },
    showCurrentImageButton: function() {
      return this.receipt_image !== null;
    },
    receipt_image_url: function() {
      return "/file/" + this.receipt_image;
    }
  },
  template: '<div class="panel"> <div class="panel-box"> <p>隢见‵�交𧋦甈∪�����璇苷辣</p> <div class="columns-12"> <div class="col-2"><strong>�𧋦甈∪�����煾��</strong></div> <div class="col-2"> <select v-model="currency" class="ctrl-input"> <option value="USD">USD</option> <option value="HKD">HKD</option> </select> </div> <div class="col-2"><input v-model="amount" type="number" step="0.01" min="0" class="ctrl-input"></div> </div> <div class="columns-12"> <div class="col-2"><strong>摰Ｘ�瘥誩僑�⏚�舐��</strong></div> <div class="col-2"> <div class="input-grp"> <input type="number" step="0.01" v-model="interest_yearly_rate" min="0" max="{{ agent_commission_rate }}" @keyup="checkFields" class="ctrl-input"> <span class="adorn">%</span> </div> <div v-if="showRateError" style="font-size: 0.8rem; color: #F00; margin: 1rem 0;"><i class="fa fa-warning fa-fw"></i>&nbsp;&nbsp;{{ rate_error_message }}</div> </div> </div> <div class="columns-12" style="margin: 2rem 0;"> <div class="col-2"><strong>�𧋦甈∪𥲤甈暹�𤏸��</strong></div> <div class="col-8"> <file-upload name="remit_receipt" action="/api/uploadImage" accept="image/jpeg,image/png"><small>(���𦻖��� JPG ��� PNG)</small></file-upload> <div v-if="showCurrentImageButton" style="margin: 1rem;"> <a :href="receipt_image_url" class="btn" target="_blank"><i class="fa fa-download"></i> 銝贝�㗇䰻���</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<small><strong><i class="fa fa-info-circle fa-fw"></i>&nbsp;��鞟內嚗�</strong> �典虾隞乩�𠰴�喃�撘菜鰵��靘���碶誨�𤌍��滢�𠰴�喟���𣇉��</small> </div> <div v-if="showFileError" style="font-size: 0.8rem; color: #F00; margin: 1rem 0;"><i class="fa fa-warning fa-fw"></i>&nbsp;&nbsp;{{ file_error_message }}</div> </div> </div> </div> <div class="panel-footer"> <a @click="goPreviousPage" class="btn-outline size-lg"><i class="fa fa-arrow-left fa-fw"></i>&nbsp;��𧼮�銝𠹺�甇�</a>&nbsp;&nbsp; <a @click="submitFormAndUpload" :disabled="disableSubmitButton" class="btn size-lg color-common"><i class="fa fa-send fa-fw"></i>&nbsp;���枂����璇苷辣</a> </div> </div> <div class="modal" v-if="in_progress"> <div class="modal-box" style="font-size: 2rem; padding: 5rem; text-align: center;"> <h2><i class="fa fa-pulse fa-spinner fa-3x fa-fw"></i> 鞈��坔�喲��銝凌��</h2> </div> </div> <div class="modal-overlay" v-if="in_progress"></div>',
  methods: {
    goPreviousPage: function() {
      var self;
      self = this;
      this.selected_contract_filename = null;
      if (app.formdata.client_id !== null) {
        app.current_step = 2;
        app.currentView = "select-user-component";
        return;
      }
      app.current_step = 3;
      return app.currentView = "new-client-component";
    },
    submitFormAndUpload: function() {
      this.in_progress = true;
      if (this.receipt_image === null || this.selected_contract_filename !== this.receipt_image) {
        return this.$broadcast("processFileUpload");
      }
      return this.$emit("onAllFilesUploaded", [this.receipt_image]);
    },
    checkFields: function() {
      this.file_error_message = null;
      this.rate_error_message = null;
      if (this.interest_yearly_rate > agent_commission_rate) {
        this.rate_error_message = "雿删策摰Ｘ���雿��𤑳��之�䲰雿㰘䌊撌脩��瑞�𡁶�䪤n\n隢贝撓�乩�滩��擧�函��瑞�� " + agent_commission_rate + " %嚗誩僑���彍��";
      }
      if (this.selected_contract_filename === null) {
        return this.file_error_message = "隢衤�𠰴�單𧋦甈∪𥲤甈曄��𤏸�� (瘞游鱓)";
      }
    }
  },
  events: {
    onAllFilesUploaded: function(data) {
      this.receipt_image = parseInt(data[0], 10);
      app.formdata.currency = this.currency;
      app.formdata.amount = this.amount;
      app.formdata.interest_yearly_rate = this.interest_yearly_rate;
      app.formdata.receipt_image = parseInt(data[0], 10);
      app.current_step = 5;
      return app.currentView = "confirm-component";
    },
    onFileChange: function(data) {
      this.selected_contract_filename = data[0].name;
      return this.checkFields();
    }
  }
});

Vue.component("confirm-component", {
  ready: function() {
    return this.formdata = app.formdata;
  },
  data: function() {
    return {
      formdata: {},
      in_progress: false
    };
  },
  computed: {
    receipt_image_url: function() {
      return "/file/" + this.formdata.receipt_image;
    },
    identity_image_url: function() {
      return "/file/" + this.formdata.client.identity_image;
    },
    bank_card_image_url: function() {
      return "/file/" + this.formdata.client.bank_card_image;
    },
    showExistingClientInfo: function() {
      return this.formdata.client_id !== null;
    },
    showNewClientInfo: function() {
      return this.formdata.client_id === null && (this.formdata.client != null);
    },
    disableButtons: function() {
      return this.in_progress === true;
    }
  },
  template: '<div class="panel"> <div class="panel-box"> <div class="columns-12"> <p class="bg-focus" style="padding: 1rem; ">隢讠Ⅱ隤滢誑銝贝���𠺪�諹𥅾��閬�靽格㺿嚗諹�𧢲�劐�𠹺�甇亙�𧼮��㮾��𣈯��𢒰��</p> <div class="col-6"> <h2>摰Ｘ�鞈���</h2> <div v-if="showNewClientInfo"> <dl> <dt>�鰵摰Ｘ�</dt> <dd> <i class="fa fa-child fa-fw"></i>&nbsp;{{ formdata.client.name_zh }} </dd> <dt>頨思遢���辣</dt> <dd> <i class="fa fa-fw fa-certificate"></i>&nbsp;{{ formdata.client.identity_type }}&nbsp;&nbsp; <small>{{ formdata.client.identity_number }}</small> <br> <br> <a :href="identity_image_url" class="btn size-sm" target="_blank"><i class="fa fa-download"></i> 銝贝�㗇䰻��贝澈隞賣��辣��𣇉��</a> </dd> <dt>��銵�㨃��𣇉��</dt> <dd><a :href="bank_card_image_url" class="btn size-sm" target="_blank"><i class="fa fa-download"></i> 銝贝�㗇䰻��钅�銵�㨃��𣇉��</a></dd> </dl> </div> <div v-if="showExistingClientInfo"> <dl> <dt>����摰Ｘ�</dt> <dd><i class="fa fa-child fa-fw"></i>&nbsp;{{ formdata.client_info.name_zh }} ({{ formdata.client_info.name_en }})</dd> </dl> </div> </div> <div class="col-6"> <h2>����璇苷辣</h2> <dl> <dt>������煾��</dt> <dd>{{ formdata.currency }} {{ formdata.amount }}</dd> <dt>摰Ｘ�瘥誩僑�⏚�舐��</dt> <dd>{{ formdata.interest_yearly_rate }} % / 撟�</dd> <dt>�𥲤甈暹偌�鱓</dt> <dd><a :href="receipt_image_url" class="btn" target="_blank"><i class="fa fa-download"></i> 銝贝�㗇䰻���</a></dd> </dl> </div> </div> </div> <div class="panel-footer"> <a @click="backToTypeSelector" :disabled="disableButtons" class="btn-outline size-lg"><i class="fa fa-arrow-left fa-fw"></i>&nbsp;��𧼮�銝𠹺�甇�</a>&nbsp;&nbsp; <a @click="submitData" :disabled="disableButtons" class="btn size-lg color-common"><i class="fa fa-send fa-fw"></i>&nbsp;���枂摰Ｘ�鞈���</a> </div> </div> <div class="modal" v-if="in_progress"> <div class="modal-box" style="font-size: 2rem; padding: 5rem; text-align: center;"> <h2><i class="fa fa-pulse fa-spinner fa-3x fa-fw"></i> 鞈��坔�喲��銝凌��</h2> </div> </div> <div class="modal-overlay" v-if="in_progress"></div>',
  methods: {
    backToTypeSelector: function() {
      app.current_step = 4;
      return app.currentView = "contract-condition-component";
    },
    submitData: function() {
      this.in_progress = true;
      if (app.formdata.client_id !== null) {
        return $.post("/api/agent/issues/new_contract", {
          client: app.formdata.client_id,
          contract: {
            currency: app.formdata.currency,
            amount: app.formdata.amount,
            interest_yearly_rate: app.formdata.interest_yearly_rate,
            receipt_image: app.formdata.receipt_image
          }
        }).done(function(data) {
          app.formdata.issue_id = data.results.issue_id;
          app.current_step = 6;
          return app.currentView = "success-component";
        });
      }
      return $.post("/api/agent/issues/new_client", {
        client: app.formdata.client
      }).done(function(data) {
        return $.post("/api/agent/issues/new_contract", {
          client_issue: data.results.issue_id,
          contract: {
            currency: app.formdata.currency,
            amount: app.formdata.amount,
            interest_yearly_rate: app.formdata.interest_yearly_rate,
            receipt_image: app.formdata.receipt_image
          }
        }).done(function(data) {
          app.formdata.issue_id = data.results.issue_id;
          app.current_step = 6;
          return app.currentView = "success-component";
        });
      });
    }
  }
});

Vue.component("success-component", {
  ready: function() {
    return this.issue_id = app.formdata.issue_id;
  },
  data: function() {
    return {
      issue_id: null
    };
  },
  template: '<div class="panel"> <div class="panel-box success-screen"> <i class="fa fa-check-circle fa-fw fa-3x"></i> <h2>�𥼚隞嗥𤚗隢见歇��𣂼��<br><small>撌亙鱓��� #{{ issue_id }}</small></h2> <p>雿惩歇��𣂼�笔‵撖怠�𣬚佅����厩�����鞈��𠺪�峕�穃�穃����鍂雿䭾�𣂷�𤤿�閮𦠜�臭��脰�諹�峕錇雿𨀣平</p> <p>��穃�穃����銁銵峕錇��匧�蓥�𨀣�嚗���枂靽∩辣�𡁶䰻��</p> <p>�其�笔虾隞亙銁銝𦠜䲮��蠘�質”&nbsp;<a href="/agent/issues" class="btn size-xs"><i class="fa fa-fw fa-history"></i> 銵峕錇�脣漲�䰻閰�</a>&nbsp;餈質馱�𧋦隞嗥��脣��</p> </div> </div>'
});

Vue.config.debug = true;

app = new Vue({
  el: "#contract_form",
  data: {
    currentView: "welcome-component",
    current_step: 1,
    formdata: {}
  },
  computed: {
    isStep1: function() {
      return this.current_step === 1;
    },
    isStep2: function() {
      return this.current_step === 2;
    },
    isStep3: function() {
      return this.current_step === 3;
    },
    isStep4: function() {
      return this.current_step === 4;
    },
    isStep5: function() {
      return this.current_step === 5;
    },
    isStep6: function() {
      return this.current_step === 6;
    }
  }
});