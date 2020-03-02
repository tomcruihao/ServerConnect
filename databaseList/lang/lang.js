const messages = {
  en: {
    message: {
      chooseLanguage:'Language',
      // setting page
      h1_settings: 'Setting',
      generalSetting: 'General Setting',
      subject_setting: 'Subject Setting',
      subject_title: 'Subject Title',
      subject_name: 'Subject Name',
      subject_create_subject: 'New Subject',
      subject_create_subject_item: 'Create New Subject Item',
      tools: 'Tool Kits',
      create_alphabet_stokes: 'Create Alphabet and Strokes',
      // latest news management page
      h1_latestNews: 'Latest News',
      latest_form_setting: 'Form Setting',
      latest_form_name: 'Form Name',
      latest_form_number_of_showing: 'Number Of Showing',
      latest_publish_date: 'Publish Date',
      latest_publish_content: 'News Content',
      // Clicking Report page
      h1_clickingReport: 'Clicking Report',
      // dialogue
      dialogue_title: 'Title',
      // button
      btn_recover: 'Recover',
      btn_update: 'Update',
      btn_execute: 'Execute',
      btn_confirm: 'Confirm',
      btn_cancel: 'Cancel',
      btn_search: 'Search',
      btn_download_report: 'Download Report'
    }
  },
  tw: {
    message: {
      chooseLanguage:'選擇語言',
      // setting page
      h1_settings: '設定',
      generalSetting: '一般設定',
      subject_setting: '主題設定',
      subject_title: '主題標題',
      subject_name: '主題名',
      subject_create_subject: '新增檢索主題',
      subject_create_subject_item: '新增主題',
      tools: '小工具',
      create_alphabet_stokes: '建立注音與比劃',
      // latest news management page
      h1_latestNews: '最新消息管理',
      latest_form_setting: '表格設定',
      latest_form_name: '表格設定',
      latest_form_number_of_showing: '顯示筆數',
      latest_publish_date: '發佈日期',
      latest_publish_content: '消息內容',
      // Clicking Report page
      h1_clickingReport: '使用率報表',
      // dialogue
      dialogue_title: '標題',
      // button
      btn_recover: '復原',
      btn_update: '更新',
      btn_execute: '執行',
      btn_confirm: '確定',
      btn_cancel: '取消',
      btn_search: '搜尋',
      btn_download_report: '下載報表'
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
