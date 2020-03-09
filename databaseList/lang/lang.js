const messages = {
  en: {
    message: {
      chooseLanguage:'Language',
      // index page
      h1_resource_list: 'e-Resource List',
      index_total: 'Total',
      index_atoz: 'A to Z',
      index_zhuyin: 'Zhu Yin',
      index_strokes: 'Strokes',
      index_sort: 'Sort',
      index_bulletin: 'Bulletin',
      index_more: 'More',
      index_placeholder_text: 'Search Resource',
      // All Latest News page
      h1_all_latestNews: 'Latest News',
      // Resource Management page
      h1_resource_management: 'Resource Management',
      resource_resourceName: 'Resource Name',
      resource_resourceType: 'Resource Type',
      resource_faculty: 'Faculty',
      resource_department: 'Department',
      resource_subject: 'Subject',
      resource_category: 'Category',
      resource_publisher: 'Publisher',
      resource_language: 'Language',
      resource_resourceDescribe: 'Resource Description',
      resource_relevanceUrlDescribe: 'Relevance Url Name',
      resource_startDate: 'Start Date',
      resource_expireDate: 'Expire Date',
      resource_isProxy: 'Proxy',
      resource_resourceUrl: 'Resource Url',
      resource_relevanceUrl: 'Relevance Url',
      resource_select_yes: 'yes',
      resource_select_no: 'no',
      resource_btn_modify: 'Modify',
      resource_btn_add: 'Add',
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
      latest_form_number_of_showing: 'Number of Showing',
      latest_publish_date: 'Publish Date',
      latest_publish_title: 'News Title',
      latest_publish_content: 'News Content',
      // Clicking Report page
      h1_clickingReport: 'Clicking Report',
      clickingReport_start_date: 'Start Date',
      clickingReport_end_date: 'End Date',
      clickingReport_display_by: 'Display by',
      clickingReport_day: 'Day',
      clickingReport_month: 'Month',
      clickingReport_download_the_report: 'Report Download',
      // dialogue
      dialogue_title: 'Title',
      // button
      btn_recover: 'Recover',
      btn_update: 'Update',
      btn_execute: 'Execute',
      btn_confirm: 'Confirm',
      btn_cancel: 'Cancel',
      btn_search: 'Search',
      btn_close: 'Close',
      btn_download_report: 'Download Report',
      btn_resource_name: 'Resource Name',
      btn_resource_subject: 'Subject',
      btn_resource_catalog: 'Catalog',
      btn_resource_type: 'Type',
      // tag
      tag_chinese: 'Chinese',
      tag_english: 'English'
    }
  },
  local: {
    message: {
      chooseLanguage:'選擇語言',
      // index page
      h1_resource_list: '電子資源',
      index_total: '全部',
      index_atoz: 'A to Z',
      index_zhuyin: '注音',
      index_strokes: '筆劃',
      index_sort: '排序',
      index_bulletin: '公佈欄',
      index_more: '更多',
      index_placeholder_text: '搜尋資源',
      // All Latest News page
      h1_all_latestNews: '最新消息',
      // Resource Management page
      h1_resource_management: '資源管理',
      resource_resourceName: '資源名稱',
      resource_resourceType: '資源類型',
      resource_faculty: '適用學院',
      resource_department: '適用科系',
      resource_subject: '主題',
      resource_category: '分類',
      resource_publisher: '出版商',
      resource_language: '語言',
      resource_resourceDescribe: '資源簡述',
      resource_relevanceUrlDescribe: '相關連結名稱',
      resource_startDate: '起訂日期',
      resource_expireDate: '迄訂日期',
      resource_isProxy: '代理',
      resource_resourceUrl: '資源連結',
      resource_relevanceUrl: '相關資源連結',
      resource_select_yes: '是',
      resource_select_no: '否',
      resource_btn_modify: '修改',
      resource_btn_add: '新增',
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
      latest_publish_title: '消息標頭',
      latest_publish_content: '消息內容',
      // Clicking Report page
      h1_clickingReport: '使用率報表',
      clickingReport_start_date: '起始時間',
      clickingReport_end_date: '結束時間',
      clickingReport_display_by: '顯示方式',
      clickingReport_day: '日',
      clickingReport_month: '月',
      clickingReport_download_the_report: '下載報表',
      // dialogue
      dialogue_title: '標題',
      // button
      btn_recover: '復原',
      btn_update: '更新',
      btn_execute: '執行',
      btn_confirm: '確定',
      btn_cancel: '取消',
      btn_search: '搜尋',
      btn_close: '關閉',
      btn_download_report: '下載報表',
      btn_resource_name: '資源名稱',
      btn_resource_subject: '主題',
      btn_resource_catalog: '分類',
      btn_resource_type: '類型',
      // tag
      tag_chinese: '中文',
      tag_english: '英文'
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
