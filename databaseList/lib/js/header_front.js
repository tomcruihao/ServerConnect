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
      url: 'https://gss.ebscohost.com/chchang/ServerConnect/databaseList/features/getHeader_front.php',
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
    }
  }
})