<!DOCTYPE xtml PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<?php
  $jsonFile_direct = 'data/eResourceList.json';

  // get resource list
  $getResourceListJsonData = file_get_contents($jsonFile_direct);
  $resourceList = json_decode($getResourceListJsonData, true);

  $result = [];
  $result_en = [];
  $result_local = [];

  foreach($resourceList as $key => $value) {
    $temp_local = [];
    $temp_en = [];
    foreach($value as $vkey => $vValue) {
      // put content without languages
      // $i_en = array_search('en', array_keys($value));

      if(!(strcasecmp('local', $vkey) == 0) && !(strcasecmp('en', $vkey) == 0)) {
        $temp_local[$vkey] = $vValue;
        $temp_en[$vkey] = $vValue;
      }
    }

    // get en value and write
    foreach($value['en'] as $ekey => $eValue) {
      $temp_en[$ekey] = $eValue;
    }

    foreach($value['local'] as $tkey => $tValue) {
      $temp_local[$tkey] = $tValue;
    }
    array_push($result_en, $temp_en);
    array_push($result_local, $temp_local);
  }
  
  $result['en'] = $result_en;
  $result['local'] = $result_local;

  $getJsonData = json_encode($result, JSON_UNESCAPED_UNICODE);
?>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>資料庫</title>
  <link rel="stylesheet" type="text/css" href="lib/index.css"/>
</head>
<body>
  <header id="header">
    <div class="logo">
      <img src="img/logo.png" alt="EBSCO" title="EBSCO"/>
    </div>
    <nav>
      <label for="mobile_btn" class="mobile-btn-frame">
        <img src="img/dehaze.svg"/>
      </label>
      <input type="checkbox" id="mobile_btn">
      <ul class="nav-list">
        <li>
          <a href="#" class="nav-tag">link 1</a>
        </li>
        <li class="multi">
          <label class="nav-tag" for="tag1">link 2</label>
          <input type="checkbox" id="tag1">
          <ul>
            <li>
              <a href="#">link 2-1</a>
            </li>
            <li>
              <a href="#">link 2-2</a>
            </li>
            <li>
              <a href="#">link 2-3</a>
            </li>
            <li>
              <a href="#">link 2-4</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#" class="nav-tag">link 3</a>
        </li>
      </ul>
    </nav>
  </header>
  <section>
    <div id="mainTitle" class="mainTitle">
      <h1 v-text="$t('message.h1_resource_list')"></h1>
      <div class="lang-wrap">
        <div>{{$t('message.chooseLanguage')}}:</div>
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
            <input type="text" class="search" :placeholder="$t('message.index_placeholder_text')"/>
          </div>
        </div>
        <div class="atoz-wrap">
          <div class="atoz-title">{{$t('message.index_total')}}:</div>
          <div class="atoz-field">
            <div class="link-field">
              <a href="javascript:searchAll()" id="searchTotal" class="clicked">{{$t('message.index_total')}}</a>
            </div>
          </div>
        </div>
        <div class="atoz-wrap" v-if="Object.keys(anchorList).includes('alphabet')">
          <div class="atoz-title">{{$t('message.index_atoz')}}:</div>
          <div id="atozField" class="atoz-field"></div>
        </div>
        <div class="atoz-wrap" v-if="Object.keys(anchorList).includes('zhuyin')">
          <div class="atoz-title">{{$t('message.index_zhuyin')}}:</div>
          <div class="atoz-field" v-for="(zhuyin, index) in anchorList.zhuyin">
            <div class="link-field">
              
            </div>
          </div>
        </div>
        <div class="atoz-wrap" v-if="Object.keys(anchorList).includes('strokes')">
          <div class="atoz-title">{{$t('message.index_strokes')}}:</div>
          <div id="strokesField" class="atoz-field"></div>
        </div>
        <div class="sort-wrap">
          <div class="sort-title">{{$t('message.index_sort')}}:</div>
          <div class="btn-wrap">
            <button @click="processSort(buttons[0])" v-bind:class="buttons[0].options.order">{{$t('message.btn_resource_name')}}</button>
            <button @click="processSort(buttons[1])" v-bind:class="buttons[1].options.order">{{$t('message.btn_resource_subject')}}</button>
            <button @click="processSort(buttons[2])" v-bind:class="buttons[2].options.order">{{$t('message.btn_resource_catalog')}}</button>
            <button @click="processSort(buttons[3])" v-bind:class="buttons[3].options.order">{{$t('message.btn_resource_type')}}</button>
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
            <img src="img/view_list.svg">
          </button>
          <div class="aside-mobile-header">
            <div class="title">{{$t('message.index_bulletin')}}</div>
            <img src="img/clear.svg" class="close" @click="set_mobile_show_switch(false)">
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
  <div class="mask-dia" id="dialogue" v-if="show" :class="{ show: show }">
    <div class="dialogue-message-frame">
      <div class="dialogue-head">
        <h4>{{dialogueMessage.title}}</h4>
        <img src="img/closeWhite.svg" class="close" @click="closeDialogue">
      </div>
      <div class="dialogue-body">
        <div class="content" v-html="dialogueMessage.content"></div>
      </div>
    </div>
  </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-i18n/8.15.3/vue-i18n.min.js"></script>
<script src="lang/lang.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
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
      selector_lang: ''
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

        genDatalistStructure(true);
      }
    }
  })

  var filterField = new Vue({
    el:'#filterField',
    i18n,
    data: {
      anchorList: {
        alphabet: [],
        zhuyin: [],
        strokes: []
      },
      temp_anchorList: {

      },
      buttons: [
        {
          btnName: '資源名稱',
          sortName: 'resourceName',
          options: {
            order: ''
          }
        },
        {
          btnName: '主題',
          sortName: 'subject',
          options: {
            order: ''
          }
        },
        {
          btnName: '分類',
          sortName: 'category',
          options: {
            order: ''
          }
        },
        {
          btnName: '類型',
          sortName: 'type',
          options: {
            order: ''
          }
        }
      ]
    },
    created: function() {
      $.ajax({
        url: 'https://gss.ebscohost.com/chchang/ServerConnect/databaseList/features/getStrokes.php',
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          console.log(res);
          temp_anchorList = res;
          // fillAnchor(res);
        }
      });
    },
    mounted: function() {
    },
    methods: {
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
      displayNumber: 0,
      latestNewsList: [],
      mobile_frame: false
    },
    created: function() {
      let self = this;

      $.ajax({
        url: 'https://gss.ebscohost.com/chchang/ServerConnect/databaseList/features/getSubject.php',
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
        url: 'https://gss.ebscohost.com/chchang/ServerConnect/databaseList/features/getLatestNews.php',
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          self.bulletinTitle.en = res.bulletinTitle.en;
          self.bulletinTitle.local = res.bulletinTitle.local;
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
          console.log(self.latestNewsList);
        }
      });
    },
    mounted: function() {
      if("lang" in localStorage) {
        this.lang = localStorage.getItem('lang');
      } else {
        this.lang = 'local';
      }
    },
    methods:{
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
      }
    }
  })

  let listTitles = [];
  listTitles['en'] = {
    "resourceName": "Resource Name",
    "resourceUrlTitle": "Link",
    "resourceUrlDisplayName": "Click Me",
    "isProxy": "Proxy",
    "resourceType": "Resource Type",
    "startDate": "Start Date",
    "expireDate": "Expire Date",
    "faculty": "Faculty",
    "department": "Department",
    "subject": "Subject",
    "category": "Category",
    "type": "Type",
    "publisher": "Publisher",
    "language": "Language",
    "Description": "test",
    "relevanceUrlDescribe": "Revelance Link"
  }
  listTitles['local'] = {
    "resourceName": "資源名稱",
    "resourceUrlTitle": "連結",
    "resourceUrlDisplayName": "點我連結",
    "isProxy": "代理",
    "resourceType": "資源類型",
    "startDate": "起訂日期",
    "expireDate": "迄訂日期",
    "faculty": "適用學院",
    "department": "適用科系",
    "subject": "主題",
    "category": "分類",
    "type": "類型",
    "publisher": "出版商",
    "language": "語言",
    "Description": "資源簡述",
    "relevanceUrlDescribe": "相關連結"
  }

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
                                <a href="javascript:directTo('${res.uuid}', '${res.resourceUrl}')">${listTitles[ary_lang].resourceUrlDisplayName}</a>\
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
                                <div class="title">${listTitles[ary_lang].category}</div>\
                                <div class="category">${res.category}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].type}</div class="title">\
                                <div class="type">${res.type}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].publisher}</div class="title">\
                                <div class="publisher">${res.publisher}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">語言</div class="title">\
                                <div class="language">${res.language}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].resourceDescribe}</div class="title">\
                                <div class="resourceDescribe">${res.resourceDescribe}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">${listTitles[ary_lang].relevanceUrlDescribe}</div class="title">\
                                <div class="relevanceUrlDescribe">${res.relevanceUrlDescribe}</div>\
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

      li_dom.appendChild(newLabel);
      li_dom.appendChild(newCheckBox);
      li_dom.appendChild(box_div_dom);
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

  function directTo(id, url) {
    console.log(`${id}, ${url}`);
    window.open(url, '_blank');
    $.ajax({
      url: 'https://gss.ebscohost.com/chchang/ServerConnect/databaseList/features/processLogClick.php',
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

  // function searchAtoZ(upperCharacter, anchor) {
  //   initAndAddClickedClass(anchor);

  //   let lowCharater = upperCharacter.toLowerCase();
  //   // contactList.search(param);
  //   contactList.filter(function(item) {
  //     // the item includes html tag to impact the result
  //     var regex = /(<([^>]+)>)/ig;
  //     removeTagResult = item.values().resourceName.replace(regex, "").trim();

  //     if (removeTagResult.charAt(0) === upperCharacter || removeTagResult.charAt(0) === lowCharater) {
  //       return true;
  //     } else {
  //       return false;
  //     }
  //   });
  // }

  // function searchAtoZ(upperCharacter, anchor) {
  //   initAndAddClickedClass(anchor);
  
  //   contactList.search(upperCharacter, ['englishAlphabet']);
  //   resetNumbering();
  // }

  // function searchZhuYin(zhuYinChar, anchor) {
  //   initAndAddClickedClass(anchor);
  
  //   contactList.search(zhuYinChar, ['zhuyin']);
  //   resetNumbering();
  // }

  // function searchStrokes(stroke, anchor) {
  //   initAndAddClickedClass(anchor);
  //   contactList.search(stroke, ['strokes']);
  //   resetNumbering();
  // }
  function searchBy(term, field) {
    contactList.search(term, [field]);
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

  // async function fillAnchor(allAnchor) {
  //   // create hyper link of a to z
  //   let englishAnchor = await createAnchor('english', allAnchor.englishAlphabet);
  //   document.getElementById("atozField").appendChild(englishAnchor);

  //   // create hyper link of ZhuYin
  //   let zhuYinAnchor = await createAnchor('zhuyin', allAnchor.zhuyin);
  //   document.getElementById("zhuYinField").appendChild(zhuYinAnchor);

  //   // create hyper link of strokes
  //   let strokesAnchor = await createAnchor('strokes', allAnchor.strokes);
  //   document.getElementById("strokesField").appendChild(strokesAnchor);
  // }

  // function createAnchor(type, rows) {
  //   return new Promise((resolve, reject) => {
  //     let linkWrap = document.createElement('div')
  //     linkWrap.className = 'link-field';
  //     rows.forEach(res => {
  //       let anchor = document.createElement('a');
  //       let alphabet = res;
  //       let anchorText = document.createTextNode(alphabet);
  //       anchor.setAttribute('href', `javascript:void(0);`);
  //       if(type === 'zhuyin') {
  //         anchor.addEventListener('click', function(){ searchZhuYin(`${alphabet}`, anchor); }, false);
  //       } else if (type === 'english') {
  //         anchor.addEventListener('click', function(){ searchAtoZ(`${alphabet}`, anchor); }, false);
  //       } else if (type === 'strokes') {
  //         anchor.addEventListener('click', function(){ searchStrokes(`${alphabet}`, anchor); }, false);
  //       }
  //       anchor.appendChild(anchorText);
  //       linkWrap.appendChild(anchor);
  //     })
  //     resolve(linkWrap);
  //   })
  // }

  document.addEventListener("DOMContentLoaded", function(event) {
    // Init list
    var options = {
      valueNames: ['numbering', 'resourceName', 'resourceType', 'startDate', 'expireDate', 'faculty', 'subject', 'category', 'type', 'publisher', 'language', 'zhuyin', 'strokes', 'englishAlphabet'],
      page: 20,
      pagination: {
        innerWindow: 1,
        outerWindow: 1
      }
      // indexAsync: true
    };
    contactList = new List('databaseList', options);

    createAlphabetAnchor();
  });
</script>
