const messages = {
  en: {
    message: {
      h1_settings: 'Setting',
      chooseLanguage:'Language',
      generalSetting: 'General Setting',
      subject_setting: 'Subject Setting',
      subject_title: 'Subject Title',
      subject_name: 'Subject Name',
      subject_create_subject: 'New Subject',
      subject_create_subject_item: 'Create New Subject Item',
      tools: 'TOOL',
      create_alphabet_stokes: 'Create Alphabet and Strokes',
      btn_recover: 'Recover',
      btn_update: 'Update',
      btn_execute: 'Execute'
    }
  },
  tw: {
    message: {
      h1_settings: '設定',
      chooseLanguage:'選擇語言',
      generalSetting: '一般設定',
      subject_setting: '主題設定',
      subject_title: '主題標題',
      subject_name: '主題名',
      subject_create_subject: '新增檢索主題',
      subject_create_subject_item: '新增主題',
      tools: '小工具',
      create_alphabet_stokes: '建立注音與比劃',
      btn_recover: '復原',
      btn_update: '更新',
      btn_execute: '執行'
    }
  }
}

var lang = '';
function initLanguage () {
  if("lang" in localStorage) {
    lang = localStorage.getItem('lang');
  } else {
    lang = navigator.language || navigator.userLanguage;
    if (lang === 'en-US') {
      lang = 'en';
    }
    localStorage.setItem('lang', lang);
  }
}
initLanguage();

var i18n = new VueI18n({
  locale: lang, // set locale
  messages, // set locale messages
})
