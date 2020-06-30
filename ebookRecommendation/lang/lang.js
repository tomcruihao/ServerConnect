const messages = {
  en: {
    message: {
      chooseLanguage:'Language',
      // Applying page
      applying_userInfo_title: 'User Info',
      applying_userInfo_yourName: 'Your Name',
      applying_userInfo_bussinessUnit: 'Business Unit',
      applying_userInfo_capacity: 'Capacity',
      applying_options_staff: 'Staff',
      applying_options_doctoral: 'Doctoral',
      applying_options_postgraduate: 'Postgraduate',
      applying_options_undergraduate: 'Undergraduate',
      applying_options_pleaseSelectYourBusinessUnit: 'Please select your Business Unit',
      applying_userInfo_email: 'eMail',
      applying_userInfo_faculty: 'Faculty',
      applying_userInfo_phone: 'Phone',
      applying_ebookInfo_title: 'eBook Info',
      applying_ebookInfo_isbn: 'ISBN',
      applying_ebookInfo_bookTitle: 'Book Title',
      applying_ebookInfo_publisher: 'Publisher',
      applying_ebookInfo_publishDate: 'Date',
      applying_ebookInfo_comment: 'Comment',
      applying_submit: 'Submit',
      requirement_applyDate: 'Date of Application',
      requirement_bookInfo: 'Book Info',
      requirement_link: 'Link',
      dialogue_info: 'Info',
      dialogue_title_error: 'Error',
      dialogue_title_success: 'Success',
      dialogue_content_fillAllBlank: 'Please fill all blanks has star sign',
      dialogue_content_applicationHasBeenReceived: 'Your application has been received',
      dialogue_deleteInfo: 'Are you sure to delete it',
      button_confirm: 'Confirm',
      button_close: 'Close',
      button_exportCsv: 'Export to CSV File',
      button_delete: 'Delete'
    }
  },
  local: {
    message: {
      chooseLanguage:'選擇語言',
      // Applying page
      applying_userInfo_title: '读者信息',
      applying_userInfo_yourName: '姓名',
      applying_userInfo_bussinessUnit: '学号/工号',
      applying_userInfo_capacity: '身份信息',
      applying_options_staff: '教职工',
      applying_options_doctoral: '博士生',
      applying_options_postgraduate: '研究生',
      applying_options_undergraduate: '本科生',
      applying_options_pleaseSelectYourBusinessUnit: '请选择您的部门',
      applying_userInfo_email: 'Email',
      applying_userInfo_faculty: '单位/学院',
      applying_userInfo_phone: '电话号码',
      applying_ebookInfo_title: '申请购买电子书信息',
      applying_ebookInfo_isbn: 'ISBN',
      applying_ebookInfo_bookTitle: '书名',
      applying_ebookInfo_publisher: '出版社',
      applying_ebookInfo_publishDate: '出版日期',
      applying_ebookInfo_comment: '备注信息',
      applying_submit: '提交',
      requirement_applyDate: '申请日期',
      requirement_bookInfo: '书本详细',
      requirement_link: '链接',
      dialogue_info: '信息',
      dialogue_title_error: '错误',
      dialogue_title_success: '请求成功',
      dialogue_content_fillAllBlank: '请确实将星号处的信息完整',
      dialogue_content_applicationHasBeenReceived: '您的信息已经收到了',
      dialogue_deleteInfo: '您确定要删除吗',
      button_confirm: '确定',
      button_close: '关闭',
      button_exportCsv: '导出CSV',
      button_delete: '删除'
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
