const messages = {
  en: {
    message: {
      adminIndex_title: 'Discipline Search',
      adminIndex_subtitle: '',
      adminIndex_account: 'Account',
      adminIndex_password: 'Password',
      adminIndex_account_pwd_rror: 'Invalid Account/Password',
      btn_login: 'Login',
      btn_download: 'Download',
      searching: 'Searching',
      empty: 'Empty'
    }
  },
  local: {
    message: {
      adminIndex_title: '學科搜尋',
      adminIndex_subtitle: 'Discipline Search',
      adminIndex_account: '帳號',
      adminIndex_password: '密碼',
      adminIndex_account_pwd_rror: '帳號密碼錯誤',
      btn_login: '登入',
      btn_download: '下載',
      searching: '搜尋中',
      empty: '沒有資料'
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
    } else {
      lang = 'local';
    }
    localStorage.setItem('lang', lang);
  }
}
initLanguage();

var i18n = new VueI18n({
  locale: lang, // set locale
  messages, // set locale messages
})
