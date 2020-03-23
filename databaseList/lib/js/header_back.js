var header = new Vue({
  el:'#header',
  i18n,
  data: {
    links: '',
    lang: ''
  },
  created: function() {
    let self = this;
    $.ajax({
      url: 'https://gss.ebscohost.com/chchang/ServerConnect/databaseList/features/getHeader_back.php',
      type: 'GET',
      error: function(jqXHR, exception) {
        //use url variable here
        console.log(jqXHR);
        console.log(exception);
      },
      success: function(res) {
        self.links = res;
        // self.settings = res;          
      }
    });
  },
  mounted: function() {
    this.lang = i18n.locale;
  },
  methods: {
    setLocale: function(language) {
      this.lang = language;
    },
    logout() {
      $.ajax({
        url: 'https://gss.ebscohost.com/chchang/ServerConnect/databaseList/features/logout.php',
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          console.log(res);
          localStorage.removeItem('user');
          dialogue.setDialogue('logout', 'logout');
          // self.settings = res;          
        }
      });
    }
  }
})