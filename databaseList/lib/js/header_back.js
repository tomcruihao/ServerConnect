var header = new Vue({
  el:'#header',
  i18n,
  data: {
    links: '',
    lang: '',
    expiringNumber: 0
  },
  created: function() {
    let self = this;
    $.ajax({
      url: `${apiPath}/getHeader_back.php`,
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

    this.getExpiryCheckingResult();
  },
  mounted: function() {
    this.lang = i18n.locale;
  },
  methods: {
    setLocale: function(language) {
      this.lang = language;
    },
    getExpiryCheckingResult() {
      let self = this;
      $.ajax({
        url: `${apiPath}/checkDatabaseExpiry.php`,
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          self.expiringNumber = res.resourceList.length;
        }
      });
    },
    logout() {
      $.ajax({
        url: `${apiPath}/logout.php`,
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