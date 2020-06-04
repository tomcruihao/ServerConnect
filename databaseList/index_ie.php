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
    <title>資料庫</title>
    <link rel="stylesheet" type="text/css" href="lib/css/index_ie.css"/>
    <script>
      // function isIE() {
      //   ua = navigator.userAgent;
      //   /* MSIE used to detect old browsers and Trident used to newer ones*/
      //   var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;
        
      //   return is_ie; 
      // }
      // if(!isIE()) {
      //   window.location.replace("index.php");
      // }
    </script>
  </head>
<body>
  <section>
    <h1>電子資料庫</h1>
    <div class="browser-notification">
      我們偵測到您使用 IE 瀏覽器！為了提供您最佳的瀏覽體驗，建議您改用 Windows 內建之 Edge 瀏覽器，或其他瀏覽器。
      ※ 提醒您：微軟已於2016年1月停止對舊版IE提供安全性更新， 詳情請見<a href="https://www.microsoft.com/zh-tw/WindowsForBusiness/End-of-IE-support" target="_blank">《微軟停止支援公告》</a>
      建議您立即升級改用Windows Edge 瀏覽器或選用其他瀏覽器：	
      <ul>
        <li>
          <a href="https://www.google.com/intl/zh-TW/chrome/" target="_blank">【點此下載 Google Chrome】</a>
        </li>
        <li>
          <a href="https://www.mozilla.org/zh-TW/firefox/new/" target="_blank">【點此下載 Firefox】</a>
        </li>
        <li>
          <a href="https://www.microsoft.com/zh-tw/edge" target="_blank">【點此下載Edge】</a>
        </li>
      </ul>
    </div>
  </section>

  <!-- <header id="header">
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
  </header> -->
  <section>
    <div>
      <div class="search-wrap">
        <div class="search-frame">
          <input type="text" class="search" placeholder="搜尋資源" id="searchBoxArea" onkeyup="searchKeyword()"/>
        </div>
      </div>
      <!-- <div id="filterField">
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
          </div>
        </div>
      </div> -->
      <div class="content-field" id="databaseList">
        <article>
          <ol class="list" id="resourceList">
          </ol>
          <ul class="pagination"></ul>
        </article>
        <!-- <aside id="aside" v-bind:class="{ show: mobile_frame }">
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
            <div class="bulletin-board-frame">
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
        </aside> -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-i18n/8.15.3/vue-i18n.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

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

 

  ga('create', GA_ID, 'auto');
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

    let index_numbering = 1;
    ary_dataList['local'].forEach(function (res, index) {
      res['numbering'] = index_numbering;
      index_numbering++;
      contactList.add(res);
    })
  }

  function resetNumbering() {
    let count = 1;
    contactList.items.forEach(function (item) {
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
  }

  let listTitles = [];
  listTitles['local'] = {
    "resourceName": '資源名稱',
    "resourceUrlTitle": '連結',
    "resourceUrlDisplayName": '點我連結',
    "isProxy": '代理',
    "resourceType": '資源類型',
    "startDate": '起訂日期',
    "expireDate": '迄訂日期',
    "faculty": '適用學院',
    "department": '適用科系',
    "subject": '主題',
    "category": '分類',
    "type": '類型',
    "publisher": '出版商',
    "language": '語言',
    "resourceDescribe": '資源簡述',
    "relevanceUrlDescribe": '相關連結',
    "moreDetail": '更多...'
  }


  function genDatalistStructure() {
    let ul_Dom = document.getElementById("resourceList");
    
    ul_Dom.innerHTML = '';

    let ary_lang = 'local';

    // create li and append to ul
    ary_dataList['local'].forEach(function (res, index) {
      let li_dom = document.createElement('li');

      let newLabel = document.createElement('label');
      newLabel.setAttribute("for", 'checkbox_' + index);
      newLabel.innerHTML = '<div class="numbering">'+(index + 1)+'</div>\
                            <div class="row">\
                              <div class="title">'+listTitles['local'].resourceName+'</div>\
                              <div class="resourceName">'+res.resourceName+'</div>\
                            </div>\
                            <div class="row">\
                              <div class="title">'+listTitles['local'].resourceType+'</div>\
                              <div class="resourceType">'+res.resourceType+'</div>\
                            </div>\
                            <div class="row">\
                              <div class="title">'+listTitles['local'].subject+'</div>\
                              <div class="subject">'+res.subject+'</div>\
                            </div>\
                            <div class="row">\
                              <div class="title">'+listTitles['local'].resourceUrlTitle+'</div>\
                              <div class="resourceUrl">\
                                <a href="javascript:directTo(\''+res.uuid+'\', \''+res.resourceUrl+'\')"><img src="img/icon/link.svg" alt="link" title="link"/>'+listTitles['local'].resourceUrlDisplayName+'</a>\
                              </div>\
                            </div>';

      let newCheckBox = document.createElement('input');
      newCheckBox.type = 'checkbox';
      newCheckBox.className = 'collapse-checkbox';
      newCheckBox.id = 'checkbox_' + index;

      let box_div_dom = document.createElement('div');
      box_div_dom.className = 'box';
      box_div_dom.innerHTML = '<div class="row">\
                                <div class="title">'+listTitles['local'].startDate+'</div>\
                                <div class="startDate">'+res.startDate+'</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">'+listTitles['local'].expireDate+'</div>\
                                <div class="expireDate">'+res.expireDate+'</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">'+listTitles['local'].faculty+'</div>\
                                <div class="faculty">'+res.faculty+'</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">'+listTitles['local'].department+'</div class="title">\
                                <div class="type">'+res.department+'</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">'+listTitles['local'].category+'</div>\
                                <div class="category">'+res.category+'</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">'+listTitles['local'].publisher+'</div class="title">\
                                <div class="publisher">'+res.publish+'</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">'+listTitles['local'].language+'</div class="title">\
                                <div class="language">'+res.language+'</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">'+listTitles['local'].resourceDescribe+'</div class="title">\
                                <div class="resourceDescribe">'+res.resourceDescribe+'</div>\
                              </div>\
                              <div class="row">\
                                <div class="title">'+listTitles['local'].relevanceUrl+'</div class="title">\
                                <div class="relevanceUrlDescribe"><a href="'+res.relevanceUrlDescribe+'" target="_blank">'+res.relevanceUrlDescribe+'</a></div>\
                              </div>\
                              <div class="row hide">\
                                <div class="title">注音</div class="title">\
                                <div class="zhuyin">'+res.zhuyin+'</div>\
                              </div>\
                              <div class="row hide">\
                                <div class="title">筆劃</div class="title">\
                                <div class="strokes">'+res.strokes+'</div>\
                              </div>\
                              <div class="row hide">\
                                <div class="title">英文</div class="title">\
                                <div class="englishAlphabet">'+res.englishAlphabet+'</div>\
                              </div>';
      let moreLabel = document.createElement('label');
      moreLabel.setAttribute("for", 'checkbox_' + index);
      moreLabel.className = 'more-detail';
      moreLabel.innerHTML = '<div class="more"><img src="img/icon/expand_more.svg" alt="expand" title="expand"/></div><div class="less"><img src="img/icon/expand_less.svg" alt="less" title="less"/></div>';

      li_dom.appendChild(newLabel);
      li_dom.appendChild(newCheckBox);
      li_dom.appendChild(box_div_dom);
      li_dom.appendChild(moreLabel);
      ul_Dom.appendChild(li_dom);
    });
    // if(local){
    //   window.setTimeout(( function () {
    //     // contactList.update();
    //     contactList.reIndex();
    //   } ), 500);
    // }
  }
  genDatalistStructure();

  function directTo(id, url) {
    window.open(url, '_blank');
    $.ajax({
      url: apiPath+'/processLogClick.php',
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
      }
    });
  }
  function checkSessionExist() {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: apiPath+'/verifyUserSession.php',
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

  function initAndAddClickedClass(anchor) {
    document.querySelectorAll('.link-field > a').forEach(function (res) {
      res.classList.remove("clicked");

      if (anchor !== undefined) {
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
  function searchKeyword() {
    searchBy(document.getElementById("searchBoxArea").value);
  }
  function searchBy(term, field) {
    if(field !== undefined) {
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
      valueNames: ['numbering', 'resourceName', 'resourceType', 'startDate', 'expireDate', 'faculty', 'subject', 'category', 'type', 'publisher', 'language', 'resourceDescribe', 'zhuyin', 'strokes', 'englishAlphabet'],
      page: 20,
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
