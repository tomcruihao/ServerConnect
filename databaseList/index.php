<!DOCTYPE html>
<?php
  date_default_timezone_set('Asia/Taipei');
  $jsonFile_direct = 'data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  // get Proxy
  $getSettingJsonData = file_get_contents('data/settings.json');
  $settingData = json_decode($getSettingJsonData, true);

  $proxy = $settingData['proxy'];
  $GA_ID = $settingData['GA_ID'];
  $numberOfDatabaseOnPage = $settingData['numberOfDatabaseShowing'];

  $result = [];
  $result_en = [];
  $result_local = [];

  foreach($resourceList as $key => $value) {
    $temp_local = [];
    $temp_en = [];
    $isProxy = false;
    $display = true;

    foreach($value as $vkey => $vValue) {
      // put content without languages
      // $i_en = array_search('en', array_keys($value));

      if(!(strcasecmp('local', $vkey) == 0) && !(strcasecmp('en', $vkey) == 0)) {
        $temp_local[$vkey] = $vValue;
        $temp_en[$vkey] = $vValue;
      }

      if(strcasecmp('isProxy', $vkey) == 0) {
        $isProxy = filter_var($vValue, FILTER_VALIDATE_BOOLEAN);
      }
    }

    // get en value and write
    foreach($value['en'] as $ekey => $eValue) {
      $temp_en[$ekey] = $eValue;
    }

    foreach($value['local'] as $tkey => $tValue) {
      $temp_local[$tkey] = $tValue;
    }

    if($isProxy) {
      $temp_en['resourceUrl'] = $proxy.$temp_en['resourceUrl'];
      $temp_local['resourceUrl'] = $proxy.$temp_local['resourceUrl'];
    }

    if (!filter_var($value['expiredChecking'], FILTER_VALIDATE_BOOLEAN) && $value['startDate'] !== '' && $value['expireDate'] !== '') {
      $currentTime = strtotime(date("Y-m-d"));
      $temp_startTime = strtotime($value['startDate']);
      $temp_endTime = strtotime($value['expireDate']);

      if($currentTime > $temp_endTime || $currentTime < $temp_startTime) {
        $display = false;
      }
    }

    if($display) {
      array_push($result_en, $temp_en);
      array_push($result_local, $temp_local);
    }
  }
  
  $result['en'] = $result_en;
  $result['local'] = $result_local;

  $getJsonData = json_encode($result, JSON_UNESCAPED_UNICODE);
?>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>圖書館 - 電子資料庫 powered by EBSCO Database Listing</title>
  <link rel="stylesheet" type="text/css" href="lib/css/index.css?v=1.1"/>
  <script>
    function isIE() {
      ua = navigator.userAgent;
      /* MSIE used to detect old browsers and Trident used to newer ones*/
      var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;
      
      return is_ie; 
    }
    if(isIE()) {
      window.location.replace("index_ie.php");
    }
  </script>
</head>
<body>
  <header id="header">
    <div class="logo">
      <a href="index.php">
        <img src="img/logo.png" alt="EBSCO" title="EBSCO"/>
      </a>
    </div>
    <nav>
      <label for="mobile_btn" class="mobile-btn-frame">
        <img src="img/icon/dehaze.svg"/>
      </label>
      <input type="checkbox" id="mobile_btn">
      <ul class="nav-list">
        <li v-for="(link, index) in links" v-bind:class="{ multi: link.child.length != 0}">
          <div v-if="link.child.length === 0">
            <a :href="link.link" class="nav-tag" v-if="lang === 'en'">{{link.title.en}}</a>
            <a :href="link.link" class="nav-tag" v-else-if="lang === 'local'">{{link.title.local}}</a>
          </div>
          <div v-else>
            <label class="nav-tag" :for="'tag'+index" v-if="lang === 'en'">{{link.title.en}}</label>
            <label class="nav-tag" :for="'tag'+index" v-else-if="lang === 'local'">{{link.title.local}}</label>
            <input type="checkbox" :id="'tag'+index">
            <ul>
              <li v-for="(childLink, c_index) in link.child">
                <a :href="childLink.link" v-if="lang === 'en'">{{childLink.title.en}}</a>
                <a :href="childLink.link" v-if="lang === 'local'">{{childLink.title.local}}</a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </nav>
  </header>
  <section class="loading-field">
    <div class="loading-wrap">
      <div>Loading...</div>
    </div>
  </section>
  <section class="main-field">
    <div id="mainTitle" class="mainTitle">
      <h1 v-text="$t('message.h1_resource_list')"></h1>
      <div class="lang-wrap"  v-if="show">
        <img src="img/icon/language.svg"/>
        <select v-model="selector_lang" @change="setLang($event)">
          <option value="en">English</option>
          <option value="local">中文</option>
        </select>
      </div>
    </div>
    <div>
      <div id="filterField">
        <div class="search-wrap">
          <div class="search-frame">
            <input type="text" class="search" :placeholder="$t('message.index_placeholder_text')" v-model="searchTerm"/>
          </div>
        </div>
        <div class="atoz-wrap">
          <div class="atoz-title">{{$t('message.index_total')}}:</div>
          <div class="atoz-field">
            <div class="link-field">
              <a href="javascript:searchAll()" id="searchTotal" class="clicked">{{$t('message.index_show_all')}}</a>
            </div>
          </div>
        </div>
        <div class="atoz-wrap" v-if="Object.keys(anchorList).includes('englishAlphabet')">
          <div class="atoz-title">{{$t('message.index_atoz')}}:</div>
          <div class="atoz-field">
            <div class="link-field" v-for="(alphabet, index) in anchorList.englishAlphabet">
              <a :id="'alpha'+index" @click="search(alphabet, 'englishAlphabet', 'alpha'+index)">{{alphabet}}</a>
            </div>
          </div>
        </div>
        <div class="atoz-wrap" v-if="Object.keys(anchorList).includes('zhuyin')">
          <div class="atoz-title">{{$t('message.index_zhuyin')}}:</div>
          <div class="atoz-field">
            <div class="link-field" v-for="(zhuyin, index) in anchorList.zhuyin">
              <a :id="'zhutin'+index" @click="search(zhuyin, 'zhuyin', 'zhutin'+index)">{{zhuyin}}</a>
            </div>
          </div>
        </div>
        <div class="atoz-wrap" v-if="Object.keys(anchorList).includes('strokes')">
          <div class="atoz-title">{{$t('message.index_strokes')}}:</div>
          <div class="atoz-field">
            <div class="link-field" v-for="(strokes, index) in anchorList.strokes">
              <a :id="'strokes'+index" @click="search(strokes, 'strokes', 'strokes'+index)">{{strokes}}</a>
            </div>
          </div>
        </div>
        <div class="sort-wrap">
          <div class="sort-title">{{$t('message.index_sort')}}:</div>
          <div class="btn-wrap">
            <button @click="processSort(buttons[0])" v-bind:class="buttons[0].options.order">{{$t('message.btn_sort_1')}}</button>
            <button @click="processSort(buttons[1])" v-bind:class="buttons[1].options.order">{{$t('message.btn_sort_2')}}</button>
            <button @click="processSort(buttons[2])" v-bind:class="buttons[2].options.order">{{$t('message.btn_sort_3')}}</button>
            <button @click="processSort(buttons[3])" v-bind:class="buttons[3].options.order">{{$t('message.btn_sort_4')}}</button>
            <!-- <button v-for="(buttonInfo, index) in buttons" @click="processSort(buttonInfo)" v-bind:class="buttonInfo.options.order">{{buttonInfo.btnName}}</button> -->
          </div>
        </div>
      </div>
      <div class="content-field" id="databaseList">
        <article>
          <ol class="list" id="resourceList">
          </ol>
          <ul class="pagination"></ul>
        </article>
        <aside id="aside" v-bind:class="{ show: mobile_frame }">
          <button class="btn-accordion" @click="set_mobile_show_switch(true)">
            <img src="img/icon/view_list.svg">
          </button>
          <div class="aside-mobile-header">
            <div class="title">{{$t('message.index_bulletin')}}</div>
            <img src="img/icon/clear.svg" class="close" @click="set_mobile_show_switch(false)">
          </div>
          <div class="aside-content">
            <div class="bulletin-board-frame" id="latestNews">
              <div>
                <h3 v-if="lang === 'en'">{{bulletinTitle.en}}</h3>
                <h3 v-else-if="lang === 'local'">{{bulletinTitle.local}}</h3>
              </div>
              <ul v-if="lang === 'en'">
                <li v-for="(latestNews, index) in latestNewsList" class="latest-news">
                  <span class="latest-title" @click="showContent(latestNews.en)">{{latestNews.en.title}}</span>
                  <div class="datetime">{{latestNews.publishDate}}</div>
                </li>
                <li class="more" v-if="latestNewsList.length >= displayNumber">
                  <a href="allLatestNews.html">{{$t('message.index_more')}}...</a>
                </li>
              </ul>
              <ul v-else-if="lang === 'local'">
                <li v-for="(latestNews, index) in latestNewsList" class="latest-news">
                  <span class="latest-title" @click="showContent(latestNews.local)">{{latestNews.local.title}}</span>
                  <div class="datetime">{{latestNews.publishDate}}</div>
                </li>
                <li class="more" v-if="latestNewsList.length >= displayNumber">
                  <a href="allLatestNews.html">{{$t('message.index_more')}}...</a>
                </li>
              </ul>
            </div>
            <div class="bulletin-board-frame" v-if="commonlyResources.resources.length !== 0 && commonlyResources.enabled === 'true'">
              <div>
                <h3>{{$t('message.index_commonly_title')}}</h3>
              </div>
              <ul>
                <li v-for="(resource, index) in commonlyResources.resources" class="popular-databases">
                  <span class="title" @click="linkTo(resource.en.uuid, resource.en.resourceUrl)" v-if="lang === 'en'">
                    {{resource.en.resourceName}}
                  </span>
                  <span class="title" @click="linkTo(resource.local.uuid, resource.local.resourceUrl)" v-else>
                    {{resource.local.resourceName}}
                  </span>
                </li>
              </ul>
            </div>
            <!-- popular database field -->
            <div class="bulletin-board-frame" v-if="popularDatabases.length !== 0">
              <div>
                <h3>{{$t('message.index_popular_frameTitle')}}</h3>
              </div>
              <ul>
                <li class="popular-databases">
                  <span class="meta-title">{{$t('message.index_popular_title')}}</span>
                  <div class="meta-clickAmount">{{$t('message.index_popular_clickAmount')}}</div>
                </li>
                <li v-for="(database, index) in popularDatabases" class="popular-databases">
                  <span class="title" @click="linkTo(database.uuid, database.resourceUrl)" v-if="lang === 'en'">
                    {{database.name.en}}
                  </span>
                  <span class="title" @click="linkTo(database.uuid, database.resourceUrl)" v-else>
                    {{database.name.local}}
                  </span>
                  <div class="clickAmount">{{database.clickTimes}}</div>
                </li>
              </ul>
            </div>
            <div id="subjectField">
              <div v-if="lang === 'en'">
                <div class="bulletin-board-frame" v-for="(subjectInfo, index) in subjects.en">
                  <h3>{{subjectInfo.subjectTitle}}</h3>
                  <ul>
                    <li v-for="(subject, index) in subjectInfo.subjectList">
                      <span @click="search(subject.name, subject.className)">{{subject.name}}</span>
                    </li>
                  </ul>
                </div>
              </div>
              <div v-else-if="lang === 'local'">
                <div class="bulletin-board-frame" v-for="(subjectInfo, index) in subjects.local">
                  <h3>{{subjectInfo.subjectTitle}}</h3>
                  <ul>
                    <li v-for="(subject, index) in subjectInfo.subjectList">
                      <span @click="search(subject.name, subject.className)">{{subject.name}}</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </section>
  <footer class="footer">
    <img src="img/logo_white.svg">
    <p>© 2020 EBSCO Industries, Inc. All rights reserved</p>
  </footer>
  <div class="mask-dia" id="dialogue" v-if="show" :class="{ show: show }">
    <div class="cover" @click="closeDialogue()"></div>
    <div class="dialogue-message-frame">
      <div class="dialogue-head">
        <h4>{{dialogueMessage.title}}</h4>
        <img src="img/icon/closeWhite.svg" class="close" @click="closeDialogue">
      </div>
      <div class="dialogue-body">
        <div class="content" v-html="dialogueMessage.content"></div>
      </div>
    </div>
  </div>
</body>
</html>
<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
<script src="lib/js/basicParameters.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-i18n/8.15.3/vue-i18n.min.js"></script>
<script src="lang/lang.js?v=1"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script src="lib/js/header_front.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $GA_ID; ?>"></script>
<script>
  // window.dataLayer = window.dataLayer || [];
  // function gtag(){dataLayer.push(arguments);}
  // gtag('js', new Date());

  // gtag('config', 'UA-XXXXX');

  // 
  const GA_ID = '<?php echo $GA_ID; ?>';
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

 

  ga('create', `${GA_ID}`, 'auto');
  ga('send', 'pageview');
</script>

<script type="text/javascript">
  var dataList = <?php echo $getJsonData; ?>;

  var ary_dataList = new Array();
  ary_dataList['en'] = dataList.en;
  ary_dataList['local'] = dataList.local;

  var contactList

  function changeRsourceListLanguage() {
    contactList.clear();
    let ary_lang

    // check the language type
    if("lang" in localStorage) {
      ary_lang = localStorage.getItem('lang');
    } else {
      ary_lang = 'local';
    }

    let index_numbering = 1;
    ary_dataList[ary_lang].forEach((res, index) => {
      res['numbering'] = index_numbering;
      index_numbering++;
      contactList.add(res);
    })
  }

  function resetNumbering() {
    let count = 1;
    contactList.items.forEach(item => {
      if(contactList.searched === item.found && contactList.filtered === item.filtered) {
        let tempObj = Object.assign({}, item['_values']);
        tempObj['numbering'] = count;
        item.values(tempObj);
        count++;
      }
    })
  }

  function sortBy(sortName, options) {
    contactList.sort(sortName, options);
    resetNumbering();
    // sort template
    // sort(valueName, {
    //   order: 'desc',
    //   alphabet: undefined,
    //   insensitive: true,
    //   sortFunction: undefined
    // })
  }

  var mainTitle = new Vue({
    el:'#mainTitle',
    i18n,
    data: {
      selector_lang: '',
      show: true
    },
    created: function() {
      let self = this;
      $.ajax({
        url: `${apiPath}/getSetting.php`,
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          self.show = res.localization;
          // self.settings = res;          
        }
      });
    },
    mounted: function() {
      this.selector_lang = i18n.locale;
    },
    methods: {
      async setLang(event) {
        i18n.locale = event.target.value;
        localStorage.setItem('lang', event.target.value);
        // changeRsourceListLanguage();

        aside.setLocale(i18n.locale);
        filterField.setLocale(i18n.locale);
        header.setLocale(i18n.locale);

        genDatalistStructure(true);
      }
    }
  })

  var filterField = new Vue({
    el:'#filterField',
    i18n,
    data: {
      anchorList: {
        englishAlphabet: [],
        zhuyin: [],
        strokes: []
      },
      searchTerm: '',
      temp_anchorList: {},
      buttons: [
        {
          btnName: 'btn_sort_1',
          sortName: 'resourceName',
          options: {
            order: ''
          }
        },
        {
          btnName: 'btn_sort_2',
          sortName: 'language',
          options: {
            order: ''
          }
        },
        {
          btnName: 'btn_sort_3',
          sortName: 'publisher',
          options: {
            order: ''
          }
        },
        {
          btnName: 'btn_sort_4',
          sortName: 'category',
          options: {
            order: ''
          }
        }
      ]
    },
    watch: {
      searchTerm: function(val, oldVal) {
        searchBy(val);
      }
    },
    created: function() {
      let self = this;
      $.ajax({
        url: `${apiPath}/getStrokes.php`,
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          self.temp_anchorList = res;
          if("lang" in localStorage) {
            switch (localStorage.getItem('lang')) {
              case 'en':
                self.anchorList = JSON.parse(JSON.stringify(res.en));
                break;
              case 'local':
                self.anchorList = JSON.parse(JSON.stringify(res.local));
                break;            
              default:
                self.anchorList = JSON.parse(JSON.stringify(res.local));
                break;
            }
            let lang = localStorage.getItem('lang');
          } else {
            self.anchorList = JSON.parse(JSON.stringify(res.local));
          }
          // fillAnchor(res);
        }
      });
    },
    methods: {
      setKeyword: function(keyword) {
        this.searchTerm = keyword;
      },
      searchbox: function(e) {
        console.log(e);
        console.log(this.searchTerm);
      },
      search: function(trem, row, id) {
        const anchor = document.querySelector(`#${id}`);
        initAndAddClickedClass(anchor);
  
        contactList.search(trem, [row]);
        resetNumbering();
      },
      processSort: function(obj) {
        if(obj.options.order === '') {
          this.initAllBtn();
          obj.options.order = 'asc';
        } else if(obj.options.order === 'asc') {
          obj.options.order = 'desc';
        } else if(obj.options.order === 'desc') {
          obj.options.order = 'asc';
        }
        sortBy(obj.sortName, obj.options);
        // addSortResultAfterTitle(obj);
      },
      setLocale: function(language) {
        switch (language) {
          case 'en':
            this.anchorList = JSON.parse(JSON.stringify(this.temp_anchorList.en));
            break;
          case 'local':
            this.anchorList = JSON.parse(JSON.stringify(this.temp_anchorList.local));
            break;            
          default:
            this.anchorList = JSON.parse(JSON.stringify(this.temp_anchorList.local));
            break;
        }
      },
      initAllBtn() {
        this.buttons.forEach((res, index) => {
          res.options.order = '';
        })
      }
    }
  })

  var aside = new Vue({
    el:'#aside',
    i18n,
    data: {
      subjects: {
        'en': [],
        'local': []
      },
      lang: '',
      bulletinTitle: {
        'en': '',
        'local': ''
      },
      popularDatabases: [],
      displayNumber: 0,
      latestNewsList: [],
      mobile_frame: false,
      commonlyResources: {
        enabled: false,
        resources: []
      }
    },
    created: function() {
      let self = this;

      $.ajax({
        url: `${apiPath}/getSubject.php`,
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          // Object.keys(res.subjects).forEach(key => {
          //   self.subjects[key] = res.subjects[key];
          // })
          res.forEach((val, index) => {
            let tempSubList_en = [];
            let tempSubList_local = [];
            val.subjectList.forEach((sVal, sIndex) => {
              let obj_en = {
                "name": sVal.name.en,
                "className": sVal.className
              }
              let obj_local = {
                "name": sVal.name.local,
                "className": sVal.className
              }
              tempSubList_en.push(obj_en);
              tempSubList_local.push(obj_local);
            })
            
            let temp_obj_en = {
              "subjectID": val.subjectID,
              "subjectTitle": val.subjectTitle.en,
              "subjectList": tempSubList_en
            }

            let temp_obj_local = {
              "subjectID": val.subjectID,
              "subjectTitle": val.subjectTitle.local,
              "subjectList": tempSubList_local
            }

            self.subjects.en.push(temp_obj_en);
            self.subjects.local.push(temp_obj_local);
          })
        }
      });

      $.ajax({
        url: `${apiPath}/getLatestNews.php`,
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          self.bulletinTitle.en = res.bulletinTitle.en;
          self.bulletinTitle.local = res.bulletinTitle.local;

          if(res.hotNews.turnOn) {
            for(let newIndex in res.newsList) {
              if(res.hotNews.newsID === res.newsList[newIndex].uuid) {
                self.displayHotNews(res.newsList[newIndex]);
              }
            }
          }

          const sortingList = res.newsList.slice().sort((a, b) => new Date(b.publishDate) - new Date(a.publishDate));
          // self.latestNewsList.local = res.newsList.slice().sort((a, b) => new Date(b.publishDate) - new Date(a.publishDate));
          // self.latestNewsList = res.newsList.slice().sort((a, b) => new Date(b.publishDate) - new Date(a.publishDate));
          self.displayNumber = res.displayNumber;

          for(let index in sortingList) {
            if(index >= self.displayNumber) {
              break;
            }
            self.latestNewsList.push(sortingList[index]);
          }
        }
      });

      $.ajax({
        url: `${apiPath}/getPopularDatabases.php`,
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          self.popularDatabases = res;
        }
      });

      $.ajax({
        url: `${apiPath}/getCommonlyResources.php`,
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          self.processCommonlyResource(res);
        }
      });
    },
    mounted: function() {
      if("lang" in localStorage) {
        this.lang = localStorage.getItem('lang');
      } else {
        this.lang = 'local';
      }

      // check hot news
    },
    methods:{
      processCommonlyResource: function(Obj_commonlyResourcesInfo) {
        if(Obj_commonlyResourcesInfo.enabled) {
          let tempAry = [];
          Obj_commonlyResourcesInfo.resources.forEach((element) => {
            let en_resource = '';
            let local_resource = '';
            dataList.en.forEach(element_en => {
              if(element_en.uuid === element) {
                en_resource = element_en;
              }
            });
            dataList.local.forEach(element_local => {
              if(element_local.uuid === element) {
                local_resource = element_local;
              }
            });
            let Obj = {
              en: en_resource,
              local: local_resource
            }
            this.commonlyResources.resources.push(Obj);
            this.commonlyResources.enabled = Obj_commonlyResourcesInfo.enabled;
          });
        }
      },
      displayHotNews: function(news) {
        let self = this;
        $.ajax({
          url: `${apiPath}/checkSessionForFrontStageUser.php`,
          type: 'POST',
          xhrFields: {
            withCredentials: true
          },
          data: {
            type: 'hotNewsField',
            processData: JSON.stringify(self.hotNewsField)
          },
          error: function(jqXHR, exception) {
            //use url variable here
            console.log(jqXHR);
            console.log(exception);
          },
          success: function(res) {
            console.log(res);
            console.log(res.data === 'not yet');
            if(res.data.indexOf('not yet') !== -1) {
              let lang = localStorage.getItem('lang');
              let message = {
                'title': '',
                'content': ''
              }
              if(lang === 'local') {
                message.title = news.local.title;
                message.content = news.local.content;
              } else {
                message.title = news.en.title;
                message.content = news.en.content;
              }

              dialogue.setDialogue('latestNews', message);
            }
          }
        });
      },
      search: function(subject, className) {
        searchBy(subject, className);
        this.set_mobile_show_switch(false);
        // aside('close');
      },
      setLocale: function(language) {
        this.lang = language;
      },
      closeDialogue: function() {
        this.show = false;
      },
      showContent: function(latestNews) {
        let message = {
          'title': latestNews.title,
          'content': latestNews.content
        }
        dialogue.setDialogue('latestNews', message);
      },
      set_mobile_show_switch (status) {
        // true = open, false = close
        this.mobile_frame = status;
      },
      linkTo(id, url) {
        directTo(id, url);
      }
    }
  })

// note: Need to include the lang.js before
  function genDatalistStructure(local = false) {
    let ul_Dom = document.getElementById("resourceList");
    if(local){
      ul_Dom.innerHTML = '';
    }

    let ary_lang
    if("lang" in localStorage) {
      ary_lang = localStorage.getItem('lang');
    } else {
      ary_lang = 'local';
    }

    // create li and append to ul
    ary_dataList[ary_lang].forEach((res, index) => {
      let li_dom = document.createElement('li');

      let newLabel = document.createElement('label');
      newLabel.setAttribute("for", 'checkbox_' + index);
      // newLabel.innerHTML = `<div class="resourceName">${res.resourceName}<div class="sort_tag"></div></div>`;
      newLabel.innerHTML = `<div class="numbering">${index + 1}</div>\
                            <div class="row">\
                              <div class="title">${listTitles[ary_lang].resourceName}</div>\
                              <div class="resourceName">${res.resourceName}</div>\
                            </div>\
                            <div class="row">\
                              <div class="title">${listTitles[ary_lang].resourceType}</div>\
                              <div class="resourceType">${res.resourceType}</div>\
                            </div>\
                            <div class="row">\
                              <div class="title">${listTitles[ary_lang].subject}</div>\
                              <div class="subject">${res.subject}</div>\
                            </div>\
                            <div class="row">\
                              <div class="title">${listTitles[ary_lang].resourceUrlTitle}</div>\
                              <div class="resourceUrl">\
                                <a href="javascript:directTo('${res.uuid}', '${res.resourceUrl}')"><img src="img/icon/link.svg" alt="link" title="link"/>${listTitles[ary_lang].resourceUrlDisplayName}</a>\
                              </div>\
                            </div>`;

      let newCheckBox = document.createElement('input');
      newCheckBox.type = 'checkbox';
      newCheckBox.className = 'collapse-checkbox';
      newCheckBox.id = 'checkbox_' + index;

      let box_div_dom = document.createElement('div');
      box_div_dom.className = 'box';
      box_div_dom.innerHTML = `<div class="row">\
                                <div class="title">${listTitles[ary_lang].startDate}</div>\
                                <div class="startDate">${res.startDate}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].expireDate}</div>\
                                <div class="expireDate">${res.expireDate}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].faculty}</div>\
                                <div class="faculty">${res.faculty}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].department}</div class="title">\
                                <div class="type">${res.department}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].category}</div>\
                                <div class="category">${res.category}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].publisher}</div class="title">\
                                <div class="publisher">${res.publish}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].language}</div class="title">\
                                <div class="language">${res.language}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].resourceDescribe}</div class="title">\
                                <div class="resourceDescribe">${res.resourceDescribe}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].relevanceUrlDescribe}</div class="title">\
                                <div class="relevanceUrlDescribe"><a href="${res.relevanceUrlDescribe}" target="_blank">${res.relevanceUrlDescribe}</a></div>\
                              </div>\
                              <div class="row hide">\
                                <div class="title">注音</div class="title">\
                                <div class="zhuyin">${res.zhuyin}</div>\
                              </div>\
                              <div class="row hide">\
                                <div class="title">筆劃</div class="title">\
                                <div class="strokes">${res.strokes}</div>\
                              </div>\
                              <div class="row hide">\
                                <div class="title">英文</div class="title">\
                                <div class="englishAlphabet">${res.englishAlphabet}</div>\
                              </div>`;
      let moreLabel = document.createElement('label');
      moreLabel.setAttribute("for", 'checkbox_' + index);
      moreLabel.className = 'more-detail';
      moreLabel.innerHTML = `<div class="more"><img src="img/icon/expand_more.svg" alt="expand" title="expand"/></div><div class="less"><img src="img/icon/expand_less.svg" alt="less" title="less"/></div>`;

      li_dom.appendChild(newLabel);
      li_dom.appendChild(newCheckBox);
      li_dom.appendChild(box_div_dom);
      li_dom.appendChild(moreLabel);
      ul_Dom.appendChild(li_dom);
    });
    if(local){
      window.setTimeout(( () => {
        // contactList.update();
        contactList.reIndex();
      } ), 500);
    }
  }
  genDatalistStructure();

  var dialogue = new Vue({
    el:'#dialogue',
    i18n,
    data: {
      show: false,
      type: '',
      dialogHead_title: '',
      message: {
        title: '',
        content: ''
      }
    },
    computed: {
      dialogueMessage: {
        get: function () {
          return this.message;
        }
        // ,set: function () {
        // }
      }
    },
    methods: {
      setDialogue: function(type, messageInfo) {
        this.type = type;
        this.message = messageInfo;
        this.show = true;
        switch (type) {
          case 'latestNews':
            this.dialogHead_title = '公告';
            break;
          default:
            this.dialogHead_title = ' ';
            break;
        }
      },
      closeDialogue: function() {
        this.show = false;
      }
    }
  });

  async function directTo(id, url) {
    let exist = await checkSessionExist();
    if(exist) {
      window.open(url, '_blank');
      $.ajax({
        url: `${apiPath}/processLogClick.php`,
        type: 'POST',
        data: {
          directionID: id
        },
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          console.log(res);
          // self.bulletinTitle = res.bulletinTitle;
          // self.latestNewsList = res.newsList.slice().sort((a, b) => new Date(b.publishDate) - new Date(a.publishDate));
          // self.displayNumber = res.displayNumber;
        }
      });
    } else {
      window.location.replace("authLogin.html");
    }
  }
  function checkSessionExist() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiPath}/verifyUserSession.php`,
        type: 'GET',
        xhrFields: {
          withCredentials: true
        },
        error: function(jqXHR, exception) {
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          if(res.type === 'pass') {
            resolve(true);
          } else {
            resolve(false);
          }          
        }
      });
    });
  }
  function errorMsg (code) {
    switch (code) {
      case 1:
        alert('沒有該連結喔!');
        break;
      default:
        alert('未知訊息');
    }
  }

  function initAndAddClickedClass(anchor = null) {
    document.querySelectorAll('.link-field > a').forEach(res => {
      res.classList.remove("clicked");

      if (anchor !== null) {
        anchor.className = 'clicked';
      } else {
        document.getElementById('searchTotal').className = 'clicked';
      }
    });
  }

  function searchBy(term, field = '') {
    if(field !== '') {
      contactList.search(term, [field]);
    } else {
      contactList.search(term);
    }
    resetNumbering();
  }
  function searchAll(anchor) {
    initAndAddClickedClass();

    // remove all condition of search
    contactList.search();

    // remove all conditions of filter
    contactList.filter();
    resetNumbering();
  }

  document.addEventListener("DOMContentLoaded", function(event) {
    // Close the loading page
    document.querySelector(".loading-field").setAttribute("style", "display: none");
    document.querySelector(".main-field").setAttribute("style", "display: block");
    

    // Init list
    var options = {
      valueNames: ['numbering', 'resourceName', 'resourceType', 'startDate', 'expireDate', 'faculty', 'subject', 'category', 'type', 'publisher', 'language', 'resourceDescribe', 'zhuyin', 'strokes', 'englishAlphabet'],
      page: '<?php echo $numberOfDatabaseOnPage; ?>',
      pagination: {
        innerWindow: 1,
        outerWindow: 1
      }
      // indexAsync: true
    };
    contactList = new List('databaseList', options);

    let url_string = window.location.href;
    let url = new URL(url_string);
    let param_keyword = url.searchParams.get("keyword");
    
    // if param have value, set the keyword to search-box
    if(param_keyword) {
      filterField.setKeyword(param_keyword);
    }
  });
</script>
