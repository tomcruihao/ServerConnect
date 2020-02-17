<!DOCTYPE xtml PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<?php
  $getJsonData = file_get_contents('data/eResourceList.json');
  $decodeJsonData = json_decode($getJsonData, true);
?>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>資料庫</title>
  <link rel="stylesheet" type="text/css" href="lib/index.css"/>
</head>
<body onload="init();">
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
    <div id="databaseList">
      <div class="search-wrap">
        <div class="search-frame">
          <input type="text" class="search" placeholder="搜尋資源" />
        </div>
      </div>
      <div class="atoz-wrap">
        <div class="atoz-title">A to Z:</div>
        <div id="atozField" class="atoz-field"></div>
      </div>
      <div class="atoz-wrap">
        <div class="atoz-title">注音:</div>
        <div id="zhuYinField" class="atoz-field"></div>
      </div>
      <div class="atoz-wrap">
        <div class="atoz-title">筆劃:</div>
        <div id="strokesField" class="atoz-field"></div>
      </div>
      <div class="sort-wrap">
        <div class="sort-title">排序:</div>
        <ol class="sort-field">
          <li class="sort" data-sort="resourceName">資源名稱</li>
          <li class="sort" data-sort="subject">主題</li>
          <li class="sort" data-sort="category">分類</li>
          <li class="sort" data-sort="type">類型</li>
        </ol>
      </div>
      <div class="content-field">
        <article>
          <ul class="list" id="resourceList">
          </ul>
          <ul class="pagination"></ul>
        </article>
        <aside>
          <div class="bulletin-board-frame" id="latestNews">
            <h3>{{bulletinTitle}}</h3>
            <ul>
              <li v-for="(latestNews, index) in latestNewsList.slice(0, displayNumber)" class="latest-news">
                <span class="latest-title" @click="showContent(latestNews)">{{latestNews.title}}</span>
                <div class="datetime">{{latestNews.publishDate}}</div>
              </li>
              <li class="more" v-if="latestNewsList.length > displayNumber">
                <a href="allLatestNews.html">更多...</a>
              </li>
            </ul>
          </div>
          <div class="bulletin-board-frame">
            <h3>主題</h3>
            <ul>
              <li>
                <a href="javascript:searchBy('全文資料庫','subject');">全文資料庫</a>
              </li>
              <li>
                <a href="javascript:searchBy('索摘資料庫','subject');">索摘資料庫</a>
              </li>
              <li>
                <a href="javascript:searchBy('博碩士論文','subject');">博碩士論文</a>
              </li>
              <li>
                <a href="javascript:searchBy('電子期刊','subject');">電子期刊</a>
              </li>
              <li>
                <a href="javascript:searchBy('電子書','subject');">電子書</a>
              </li>
            </ul>
          </div>
          <div class="bulletin-board-frame">
            <h3>適用學院</h3>
            <ul class="subject-list">
              <li>
                <a href="javascript:searchBy('文學院','faculty');">文學院</a>
              </li>
              <li>
                <a href="javascript:searchBy('藝術學院','faculty');">藝術學院</a>
              </li>
            </ul>
          </div>
        </aside>
      </div>
    </div>
  </section>
  <div class="mask-dia" id="dialogue" v-if="show" :class="{ show: show }">
    <div class="dialogue-message-frame">
      <div class="dialogue-head">
        <h4>{{dialogHead_title}}</h4>
        <img src="img/closeWhite.svg" class="close" @click="closeDialogue">
      </div>
      <div class="dialogue-body">
        <div class="row">
          <div class="title">標題</div>
          <div class="content">{{dialogueMessage.title}}</div>
        </div>
        <div class="row">
          <div class="title">相關URL</div>
          <div class="content" v-html="dialogueMessage.content"></div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<script type="text/javascript">
  var dataList = <?php echo $getJsonData; ?>;
  var contactList

  function genDatalistStructure() {
    let ul_Dom = document.getElementById("resourceList");

    // create li and append to ul
    dataList.rows.forEach((res, index) => {
      let li_dom = document.createElement('li');

      let newLabel = document.createElement('label');
      newLabel.setAttribute("for", 'checkbox_' + index);
      newLabel.innerHTML = `<div class="resourceName">${res.resourceName}</div>`;

      let newCheckBox = document.createElement('input');
      newCheckBox.type = 'checkbox';
      newCheckBox.className = 'collapse-checkbox';
      newCheckBox.id = 'checkbox_' + index;

      let box_div_dom = document.createElement('div');
      box_div_dom.className = 'box';
      box_div_dom.innerHTML = `<div class="row">\
                                <div class="title">連結</div>\
                                <div class="resourceUrl">\
                                  <a href="${res.resourceType}">點我連結</a>\
                                </div>\
                              </div>\
                              <div class="row">\
                                <div class="title">資源類型</div>\
                                <div class="resourceType">${res.resourceType}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">起訂日期</div>\
                                <div class="startDate">${res.startDate}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">迄訂日期</div>\
                                <div class="expireDate">${res.expireDate}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">適用學院</div>\
                                <div class="faculty">${res.faculty}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">主題</div>\
                                <div class="subject">${res.subject}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">分類</div>\
                                <div class="category">${res.category}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">類型</div class="title">\
                                <div class="type">${res.type}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">資料庫代理商/出版商</div class="title">\
                                <div class="publisher">${res.publisher}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">語言</div class="title">\
                                <div class="language">${res.language}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">資源簡述(摘要)</div class="title">\
                                <div class="resourceDescribe">${res.resourceDescribe}</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">相關URL</div class="title">\
                                <div class="relevanceUrlDescribe">${res.relevanceUrlDescribe}</div>\
                              </div>\
                              <div class="row hide">\
                                <div class="title">注音</div class="title">\
                                <div class="zhuyin">${res.zhuyin}</div>\
                              </div>\
                              <div class="row hide">\
                                <div class="title">筆劃</div class="title">\
                                <div class="strokes">${res.strokes}</div>\
                              </div>`;

      li_dom.appendChild(newLabel);
      li_dom.appendChild(newCheckBox);
      li_dom.appendChild(box_div_dom);
      ul_Dom.appendChild(li_dom);
    });
  }
  genDatalistStructure();

  var dialogue = new Vue({
    el:'#dialogue',
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
    methods:{
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
  var latestNews = new Vue({
    el:'#latestNews',
    data: {
      bulletinTitle: '',
      displayNumber: 0,
      latestNewsList: []
    },
    created: function() {
      let self = this;
      $.ajax({
        url: 'https://gss.ebscohost.com/chchang/ServerConnect/databaseList/features/getLatestNews.php',
        type: 'GET',
        error: function(jqXHR, exception) {
          //use url variable here
          console.log(jqXHR);
          console.log(exception);
        },
        success: function(res) {
          self.bulletinTitle = res.bulletinTitle;
          self.latestNewsList = res.newsList.slice().sort((a, b) => new Date(b.publishDate) - new Date(a.publishDate));
          self.displayNumber = res.displayNumber;
        }
      });
    },
    methods:{
      closeDialogue: function() {
        this.show = false;
      },
      showContent: function(latestNews) {
        let message = {
          'title': latestNews.title,
          'content': latestNews.content
        }
        dialogue.setDialogue('latestNews', message);
      }
    }
  });

  function directTo(id, url) {
    window.open(url, '_blank');
    $.ajax({
      url: 'https://gss.ebscohost.com/chchang/ServerConnect/databaseList/features/processLogClick.php',
      type: 'POST',
      error: function(jqXHR, exception) {
        //use url variable here
        console.log(jqXHR);
        console.log(exception);
      },
      success: function(res) {
        self.bulletinTitle = res.bulletinTitle;
        self.latestNewsList = res.newsList.slice().sort((a, b) => new Date(b.publishDate) - new Date(a.publishDate));
        self.displayNumber = res.displayNumber;
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
  async function init() {
    // create hyper link of a to z
    let englishAnchor = await createEnglishAnchor();
    document.getElementById("atozField").appendChild(englishAnchor);

    // create hyper link of ZhuYin
    let zhuYinAnchor = await createZhuYinAnchor();
    document.getElementById("zhuYinField").appendChild(zhuYinAnchor);

    // create hyper link of strokes
    let strokesAnchor = await createStrokesAnchor();
    document.getElementById("strokesField").appendChild(strokesAnchor);
  }

  function initAndAddClickedClass(anchor) {
    document.querySelectorAll('.link-field > a').forEach(res => {
      console.log(res);
      res.classList.remove("clicked");

      anchor.className = 'clicked';
    });
  }

  function searchAtoZ(upperCharacter, anchor) {
    initAndAddClickedClass(anchor);
  
    let lowCharater = upperCharacter.toLowerCase();
    // contactList.search(param);
    contactList.filter(function(item) {
      // the item includes html tag to impact the result
      var regex = /(<([^>]+)>)/ig;
      removeTagResult = item.values().resourceName.replace(regex, "").trim();

      if (removeTagResult.charAt(0) === upperCharacter || removeTagResult.charAt(0) === lowCharater) {
        return true;
      } else {
        return false;
      }
    });
  }
  function searchZhuYin(zhuYinChar, anchor) {
    initAndAddClickedClass(anchor);
  
    contactList.search(zhuYinChar, ['zhuyin']);
  }

  function searchStrokes(stroke, anchor) {
    initAndAddClickedClass(anchor);
    console.log(stroke);
    contactList.search(stroke, ['strokes']);
  }
  function searchBy(term, field) {
    contactList.search(term, [field]);
  }
  function searchAll(anchor) {
    initAndAddClickedClass(anchor);

    // remove all condition of search
    contactList.search();

    // remove all conditions of filter
    contactList.filter();
  }
  function createEnglishAnchor() {
    return new Promise((resolve, reject) => {
      let linkWrap = document.createElement('div')
      linkWrap.className = 'link-field';

      let totalAnchor = document.createElement('a');
      let totalAnchorText = document.createTextNode('全部');
      totalAnchor.setAttribute('href', 'javascript:void(0);');
      totalAnchor.className = 'clicked';
      totalAnchor.addEventListener('click', function(){ searchAll(totalAnchor); }, false);
      totalAnchor.appendChild(totalAnchorText);
      linkWrap.appendChild(totalAnchor);

      // for char A to Z
      for(let loop = 0; loop < 26; loop++) {
        let anchor = document.createElement('a');
        let alphabet = String.fromCharCode(65 + loop);
        let anchorText = document.createTextNode(alphabet);
        anchor.setAttribute('href', `javascript:void(0);`);
        anchor.addEventListener('click', function(){ searchAtoZ(`${alphabet}`, anchor); }, false);
        anchor.appendChild(anchorText);
        linkWrap.appendChild(anchor);
      }

      resolve(linkWrap)
    })
  }

  function createZhuYinAnchor() {
    return new Promise((resolve, reject) => {
      var allZhiYin = 'ㄅㄆㄇㄈㄉㄊㄋㄌㄍㄎㄏㄐㄑㄒㄓㄔㄕㄖㄗㄘㄙㄧㄨㄩㄚㄛㄜㄝㄞㄟㄠㄡㄢㄣㄤㄥㄦ'.split('');

      let linkWrap = document.createElement('div')
      linkWrap.className = 'link-field';

      allZhiYin.forEach(res => {
        let anchor = document.createElement('a');
        let alphabet = res;
        let anchorText = document.createTextNode(alphabet);
        anchor.setAttribute('href', `javascript:void(0);`);
        anchor.addEventListener('click', function(){ searchZhuYin(`${alphabet}`, anchor); }, false);
        anchor.appendChild(anchorText);
        linkWrap.appendChild(anchor);
      })

      resolve(linkWrap)
    })
  }

  function createStrokesAnchor() {
    return new Promise((resolve, reject) => {
      let linkWrap = document.createElement('div')
      linkWrap.className = 'link-field';

      for(let index = 1; index < 25; index++) {
        let anchor = document.createElement('a');
        let alphabet;
        if(index <= 9) {
          alphabet = `0${index}`;
        } else {
          alphabet = index;
        }
        let anchorText = document.createTextNode(alphabet);
        anchor.setAttribute('href', `javascript:void(0);`);
        anchor.addEventListener('click', function(){ searchStrokes(`${alphabet}`, anchor); }, false);
        anchor.appendChild(anchorText);
        linkWrap.appendChild(anchor);
      }

      resolve(linkWrap)
    })
  }

  document.addEventListener("DOMContentLoaded", function(event) {
    // Init list
    var options = {
      valueNames: [ 'resourceName', 'resourceType', 'startDate', 'expireDate', 'faculty', 'subject', 'category', 'type', 'publisher', 'language', 'zhuyin', 'strokes'],
      page: 20,
      pagination: {
        innerWindow: 1,
        outerWindow: 1
      }
    };
    contactList = new List('databaseList', options);
  });
</script>
