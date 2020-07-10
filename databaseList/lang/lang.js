const messages = {
  en: {
    message: {
      chooseLanguage:'Language',
      header_logout: 'Logout',
      // index page
      h1_resource_list: 'e-Resource List',
      index_total: 'ALL',
      index_show_all: 'Show All',
      index_atoz: 'A to Z',
      index_zhuyin: 'Zhu Yin',
      index_strokes: 'Strokes',
      index_sort: 'Sort by',
      index_bulletin: 'Bulletin',
      index_more: 'More',
      index_placeholder_text: 'Search Resource',
      index_popular_frameTitle: 'Popular Resources',
      index_popular_title: 'Resource Name',
      index_popular_clickAmount: 'Clicks',
      adminIndex_verifyCode: 'Verify Code',
      // All Latest News page
      h1_all_latestNews: 'Latest News',
      // admin index page
      adminIndex_account: 'Account',
      adminIndex_password: 'Password',
      adminIndex_account_pwd_rror: 'Invalid Account/Password',
      // Resource Management page
      h1_resource_management: 'Resource Setting',
      resource_resourceName: 'Title',
      resource_resourceType: 'Type',
      resource_faculty: 'School',
      resource_department: 'Department',
      resource_subject: 'Subject',
      resource_category: 'Category',
      resource_publisher: 'Publisher',
      resource_language: 'Language',
      resource_resourceDescribe: 'Description',
      resource_relevanceUrlDescribe: 'Information Link Name',
      resource_startDate: 'Start Day',
      resource_expireDate: 'End Day',
      resource_isProxy: 'Apply Proxy/Redirector',
      resource_resourceUrl: 'Access Link',
      resource_relevanceUrl: 'Information Link',
      resource_select_yes: 'yes',
      resource_select_no: 'no',
      resource_btn_modify: 'Modify',
      resource_btn_add: 'Add',
      resource_expired_display: 'Display this resource when expired',
      // setting page
      h1_settings: 'Settings',
      generalSetting: 'General Settings',
      tools: 'Tool Kits',
      build_alphabet_stokes: 'Generate Index for Zhuyin and Strokes',
      setting_ga: 'Google Analytics Tracking ID',
      setting_localization: 'Show Language Option',
      setting_update_the_account_and_password: 'Update the account and password',
      setting_account_info: 'Account Information',
      setting_password_wronging: 'Your password is wrong',
      setting_password_not_matching: 'Your password and confirm password are not match',
      setting_import_csv_data: 'Import resource list (txt file)',
      setting_proxy: 'Proxy/Redirector Prefix URL',
      setting_total_resources: 'Total Resources',
      setting_show_popular_resources: 'The number of Popular resources to show',
      setting_exportDatabaseFile: 'Export Database List',
      // latest news management page
      h1_latestNews: 'News Management',
      latest_form_setting: 'News Block Settings',
      latest_form_name: 'Block Title',
      latest_form_number_of_showing: 'How many news to show in the block',
      latest_publish_date: 'Date',
      latest_publish_title: 'Title',
      latest_publish_content: 'Content',
      latest_hot_news: 'Hot News',
      latest_hot_news_show_or_not_show: 'Show',
      latest_hot_news_message: 'Choose Message',
      latest_hot_news_message_select: 'Select',
      // Subject management page
      h1_subject: 'Facets Management',
      subject_setting: 'Facets Management',
      subject_title: 'Facet Title',
      subject_name: 'Item',
      subject_create_subject: 'New Item',
      subject_create_subject_item: 'Add New Facet Block',
      subject_facet_field: 'Facet Field',
      // identity management page
      h1_identity: 'Identity Management',
      identity_validateIdentity: 'Identity Validate feature',
      identity_addNewItem: 'Add New Item',
      identity_title_department: 'Department',
      identity_title_Identity: 'Identity',
      select_options: 'Options',
      select_sameLevel: 'Add item for same level',
      select_nextLevel: 'Add item for next level',
      // Clicking Report page
      h1_clickingReport: 'Clicking Report',
      clickingReport_start_date: 'Start Day',
      clickingReport_end_date: 'End Day',
      clickingReport_display_by: 'Display by',
      clickingReport_day: 'Day',
      clickingReport_month: 'Month',
      clickingReport_departmemnt: 'Department',
      clickingReport_userIdentity: 'User Identity',
      clickingReport_download_the_report: 'Report Download',
      // dialogue
      dialogue_title: 'Title',
      dialogue_title_info: 'Info',
      dialogue_title_actpwd: 'Account and Password Setting',
      dialogue_title_account: 'Account',
      dialogue_title_old_password: 'Old Password',
      dialogue_title_new_password: 'New Password',
      dialogue_title_confirm_new_password: 'Confirm New Password',
      dialogue_content_expired: 'The credential has expired, please log in again',
      dialogue_content_updateSuccess: 'Update Successful',
      dialogue_content_account_updateSuccess: 'Your account has updated successfully, please re-login',
      dialogue_content_logout: 'Log out successfully',
      dialogue_content_import_successful: 'Import Successful',
      // button
      btn_recover: 'Recover',
      btn_update: 'Update',
      btn_execute: 'Execute',
      btn_confirm: 'Confirm',
      btn_cancel: 'Cancel',
      btn_search: 'Search',
      btn_close: 'Close',
      btn_download_report: 'Download Report',
      btn_sort_1: 'Resource Name',
      btn_sort_2: 'Language',
      btn_sort_3: 'Publisher',
      btn_sort_4: 'Category',
      btn_login: 'Login',
      btn_change: 'Change',
      // resourceTable
      resource_table_resourceName: "Title",
      resource_table_resourceUrlTitle: "Access Link",
      resource_table_resourceUrlDisplayName: "Link",
      resource_table_isProxy: "Proxy",
      resource_table_resourceType: "Type",
      resource_table_startDate: "Start Date",
      resource_table_expireDate: "End Date",
      resource_table_faculty: "School",
      resource_table_department: "Department",
      resource_table_subject: "Subject",
      resource_table_category: "Category",
      resource_table_type: "Type",
      resource_table_publisher: "Publisher",
      resource_table_language: "Language",
      resource_table_resourceDescribe: "Description",
      resource_table_relevanceUrlDescribe: "Information Link",
      resource_table_moreDetail: "more...",
      // tag
      tag_chinese: 'Chinese',
      tag_english: 'English'
    }
  },
  local: {
    message: {
      chooseLanguage:'選擇語言',
      header_logout: '登出',
      // index page
      h1_resource_list: '電子資源',
      index_total: '全部',
      index_show_all: '全部',
      index_atoz: 'A to Z',
      index_zhuyin: '注音',
      index_strokes: '筆劃',
      index_sort: '排序',
      index_bulletin: '公佈欄',
      index_more: '更多',
      index_placeholder_text: '搜尋資源',
      index_popular_frameTitle: '熱門資源',
      index_popular_title: '題名',
      index_popular_clickAmount: '次數',
      // All Latest News page
      h1_all_latestNews: '最新消息',
      // admin index page
      adminIndex_account: '帳號',
      adminIndex_password: '密碼',
      adminIndex_account_pwd_rror: '帳號密碼錯誤',
      adminIndex_verifyCode: '驗證碼',
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
      resource_isProxy: '套用Proxy/Redirector',
      resource_resourceUrl: '資源連結',
      resource_relevanceUrl: '相關資源連結',
      resource_select_yes: '是',
      resource_select_no: '否',
      resource_btn_modify: '修改',
      resource_btn_add: '新增',
      resource_expired_display: '過期是否顯示',
      // setting page
      h1_settings: '設定',
      generalSetting: '一般設定',
      tools: '建立索引與資源匯入',
      build_alphabet_stokes: '建立注音與筆畫索引',
      setting_ga: 'Google Analytics 追蹤ID',
      setting_localization: '顯示「選擇語言」選項',
      setting_update_the_account_and_password: '帳號密碼設定',
      setting_account_info: '帳號資訊',
      setting_password_wronging: '密碼驗證錯誤',
      setting_password_not_matching: '密碼和確認密碼不匹配',
      setting_import_csv_data: '上傳資源 txt 檔案',
      setting_proxy: 'Proxy/Redirector 前綴網址',
      setting_total_resources: '資源數',
      setting_show_popular_resources: '熱門資源顯示數量',
      setting_exportDatabaseFile: '匯出資料庫',
      // latest news management page
      h1_latestNews: '消息管理',
      latest_form_setting: '消息區塊設定',
      latest_form_name: '消息區塊標題',
      latest_form_number_of_showing: '顯示筆數',
      latest_publish_date: '發佈日期',
      latest_publish_title: '標題',
      latest_publish_content: '內容',
      latest_hot_news: '焦點消息',
      latest_hot_news_show_or_not_show: '是否顯示',
      latest_hot_news_message: '是否顯示',
      latest_hot_news_message_select: '請選擇',
      // Subject management page
      h1_subject: '後分類管理',
      subject_setting: '後分類管理',
      subject_title: '後分類區塊標題',
      subject_name: '項目名稱',
      subject_create_subject: '新增分類項目',
      subject_create_subject_item: '新增後分類區塊',
      subject_facet_field: '後分類欄位',
      // identity management page
      h1_identity: '身份管理',
      identity_validateIdentity: '身份驗證功能',
      identity_addNewItem: '新增項目',
      identity_title_department: '部門',
      identity_title_Identity: '身份',
      select_options: '請選擇',
      select_sameLevel: '增加同層項目',
      select_nextLevel: '增加子項目',
      // Clicking Report page
      h1_clickingReport: '使用率報表',
      clickingReport_start_date: '起始時間',
      clickingReport_end_date: '結束時間',
      clickingReport_display_by: '顯示方式',
      clickingReport_day: '日',
      clickingReport_month: '月',
      clickingReport_departmemnt: '部門',
      clickingReport_userIdentity: '身份',
      clickingReport_download_the_report: '下載報表',
      // dialogue
      dialogue_title: '標題',
      dialogue_title_info: '訊息',
      dialogue_title_actpwd: '帳號密碼修改',
      dialogue_title_account: '帳號',
      dialogue_title_old_password: '舊密碼',
      dialogue_title_new_password: '新密碼',
      dialogue_title_confirm_new_password: '確認新密碼',
      dialogue_content_expired: '憑證已失效, 請重新登入',
      dialogue_content_updateSuccess: '更新成功',
      dialogue_content_account_updateSuccess: '帳號更新成功, 請重新登入',
      dialogue_content_logout: '登出成功',
      dialogue_content_import_successful: '匯入成功',
      // button
      btn_recover: '復原',
      btn_update: '更新',
      btn_execute: '執行',
      btn_confirm: '確定',
      btn_cancel: '取消',
      btn_search: '搜尋',
      btn_close: '關閉',
      btn_download_report: '下載報表',
      btn_sort_1: '資源名稱',
      btn_sort_2: '語言',
      btn_sort_3: '出版商',
      btn_sort_4: '分類',
      btn_login: '登入',
      btn_change: ' 變更',
      // resourceTable
      resource_table_resourceName: "資源名稱",
      resource_table_resourceUrlTitle: "連結",
      resource_table_resourceUrlDisplayName: "點我連結",
      resource_table_isProxy: "代理",
      resource_table_resourceType: "資源類型",
      resource_table_startDate: "起訂日期",
      resource_table_expireDate: "迄訂日期",
      resource_table_faculty: "適用學院",
      resource_table_department: "適用科系",
      resource_table_subject: "主題",
      resource_table_category: "分類",
      resource_table_type: "類型",
      resource_table_publisher: "出版商",
      resource_table_language: "語言",
      resource_table_resourceDescribe: "資源簡述",
      resource_table_relevanceUrlDescribe: "相關連結",
      resource_table_moreDetail: "更多...",
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


// Statement heading of Resource List
let listTitles = [];
listTitles['en'] = {
  "resourceName": messages.en.message.resource_table_resourceName,
  "resourceUrlTitle": messages.en.message.resource_table_resourceUrlTitle,
  "resourceUrlDisplayName": messages.en.message.resource_table_resourceUrlDisplayName,
  "isProxy": messages.en.message.resource_table_isProxy,
  "resourceType": messages.en.message.resource_table_resourceType,
  "startDate": messages.en.message.resource_table_startDate,
  "expireDate": messages.en.message.resource_table_expireDate,
  "faculty": messages.en.message.resource_table_faculty,
  "department": messages.en.message.resource_table_department,
  "subject": messages.en.message.resource_table_subject,
  "category": messages.en.message.resource_table_category,
  "type": messages.en.message.resource_table_type,
  "publisher": messages.en.message.resource_table_publisher,
  "language": messages.en.message.resource_table_language,
  "resourceDescribe": messages.en.message.resource_table_resourceDescribe,
  "relevanceUrlDescribe": messages.en.message.resource_table_relevanceUrlDescribe,
  "moreDetail": messages.en.message.resource_table_moreDetail
}
listTitles['local'] = {
  "resourceName": messages.local.message.resource_table_resourceName,
  "resourceUrlTitle": messages.local.message.resource_table_resourceUrlTitle,
  "resourceUrlDisplayName": messages.local.message.resource_table_resourceUrlDisplayName,
  "isProxy": messages.local.message.resource_table_isProxy,
  "resourceType": messages.local.message.resource_table_resourceType,
  "startDate": messages.local.message.resource_table_startDate,
  "expireDate": messages.local.message.resource_table_expireDate,
  "faculty": messages.local.message.resource_table_faculty,
  "department": messages.local.message.resource_table_department,
  "subject": messages.local.message.resource_table_subject,
  "category": messages.local.message.resource_table_category,
  "type": messages.local.message.resource_table_type,
  "publisher": messages.local.message.resource_table_publisher,
  "language": messages.local.message.resource_table_language,
  "resourceDescribe": messages.local.message.resource_table_resourceDescribe,
  "relevanceUrlDescribe": messages.local.message.resource_table_relevanceUrlDescribe,
  "moreDetail": messages.local.message.resource_table_moreDetail
}
