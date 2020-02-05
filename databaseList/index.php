<!DOCTYPE xtml PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<?php
  $getJsonData = file_get_contents('eResourceList.json');
  $decodeJsonData = json_decode($getJsonData, true);
?>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>資料庫</title>
  <link rel="stylesheet" type="text/css" href="lib/style.css"/>
</head>
<body onload="init();">
  <header>
    <div>
      <h1>資料庫列表</h1>
    </div>
    <div class="top-right">
      <a href="javascript:addNew();">新增</a>
    </div>
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
      <div class="content-field">
        <article>
          <div class="burger-button-wrap">
            <button class="burger-button" onclick="fieldToggle('fieldDisplay')">
              <img src="img/list.svg"/>
            </button>
          </div>
          <div class="databaseList-wrap">
            <table class="databaseList-table">
              <thead>
                <tr>
                  <th class="sort resourceName" data-sort="resourceName">資源名稱</th>
                  <th class="sort subject" data-sort="subject">主題</th>
                  <th class="sort resourceType" data-sort="resourceType">資源類型</th>
                  <th class="sort faculty" data-sort="faculty">適用學院</th>
                  <th class="sort publisher" data-sort="publisher">出版商/代理商</th>
                  <th class="sort lang" data-sort="lang">語文</th>
                  <th>詳細資訊</th>
                </tr>
              </thead>
              <tbody class="list" id="databaseList">
  <?php
    foreach ($decodeJsonData['rows'] as $row) {
      // the data-label is for RWD title
      echo '<tr>
              <td class="resourceName">
                <div class="resourceName-title">'.$row['resourceName'].'</div>
                <button class="direction" onclick="directTo('.$row['id'].', \''.$row['url'].'\')">
                  <img src="img/direction.svg" alt="點我開啟" title="點我開啟"/>
                </button>
              </td>
              <td class="subject" data-label="主題">'.$row['type'].'</td>
              <td class="resourceType" data-label="資源類型">'.$row['resourceType'].'</td>
              <td class="faculty" data-label="適用學院">'.$row['faculty'].'</td>
              <td class="publisher" data-label="出版商/代理商">'.$row['publisher'].'</td>
              <td class="lang" data-label="語文">'.$row['language'].'</td>
              <td>
                <a href="javascript:displayDetail('.$row['id'].');">點我查看</a>
              </td>
            </tr>';
    }
  ?>
              </tbody>
            </table>
          </div>
        </article>
        <aside>
          <div class="bulletin-board-frame" id="latestNews">
            <h3>{{bulletinTitle}}</h3>
            <ul>
              <li v-for="(latestNews, index) in latestNewsList.slice(0, displayNumber)" class="latest-news">
                <a class="latest-title" href="#" :click="showContent(latestNews)">{{latestNews.title}}</a>
                <div class="datetime">{{latestNews.publishDate}}</div>
              </li>
              <li class="more" v-if="latestNewsList.length > displayNumber">
                <a href="#">更多...</a>
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
  <div class="mask" id="fieldDisplay">
    <div class="dialogue-frame">
      <div class="dialogue-content">
        <label>
          <input type="checkbox" name="tags" value="resourceName" checked disabled> 資源名稱
        </label>
        <label>
          <input type="checkbox" name="tags" value="subject" checked> 主題
        </label>
        <label>
          <input type="checkbox" name="tags" value="resourceType"> 資源類型
        </label>
        <label>
          <input type="checkbox" name="tags" value="faculty"> 適用學院
        </label>
        <label>
          <input type="checkbox" name="tags" value="publisher"> 出版商/代理商
        </label>
        <label>
          <input type="checkbox" name="tags" value="lang"> 語文
        </label>
      </div>
      <div class="btn-frame">
        <button onclick="showField()">確認</button>
      </div>
    </div>
  </div>
  <div class="mask" id="detailInfo">
    <div class="dialogue-frame">
      <div class="dialogue-content">
        <div class="row">
          <div class="title">資源名稱</div>
          <div class="content" id="detail_resourceName"></div>
        </div>
        <div class="row">
          <div class="title">試用/免費註記</div>
          <div class="content" id="detail_resourceType"></div>
        </div>
        <div class="row">
          <div class="title">起訂日期</div>
          <div class="content" id="detail_startDate"></div>
        </div>
        <div class="row">
          <div class="title">迄訂日期</div>
          <div class="content" id="detail_expireDate"></div>
        </div>
        <div class="row">
          <div class="title">適用學院</div>
          <div class="content" id="detail_faculty"></div>
        </div>
        <div class="row">
          <div class="title">主題</div>
          <div class="content" id="detail_subject"></div>
        </div>
        <div class="row">
          <div class="title">分類</div>
          <div class="content" id="detail_category"></div>
        </div>
        <div class="row">
          <div class="title">類型</div>
          <div class="content" id="detail_type"></div>
        </div>
        <div class="row">
          <div class="title">資料庫代理商/出版商</div>
          <div class="content" id="detail_publisher"></div>
        </div>
        <div class="row">
          <div class="title">語言</div>
          <div class="content" id="detail_language"></div>
        </div>
        <div class="row">
          <div class="title">資源簡述(摘要)</div>
          <div class="content" id="detail_resourceDescribe"></div>
        </div>
        <div class="row">
          <div class="title">相關URL</div>
          <div class="content" id="detail_relevanceUrlDescribe"></div>
        </div>
      </div>
      <div class="btn-frame">
        <button onclick="fieldToggle('detailInfo')">關閉</button>
      </div>
    </div>
  </div>
  <div class="mask" id="dialogue" v-if="show">
    <div class="dialogue-message-frame">
      <div class="dialogue-head">
        <img src="img/closeWhite.svg"/ class="close" @click="closeDialogue">
      </div>
      <div class="dialogue-body">
        {{dialogueMessage.title}}
        {{dialogueMessage.content}}
        <div class="btn-frame">
          <button @click="closeDialogue">確定</button>
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

  var dialogue = new Vue({
    el:'#dialogue',
    data: {
      show: false,
      type: '',
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
          console.log(self.latestNewsList);
        }
      });
    },
    methods:{
      closeDialogue: function() {
        this.show = false;
      },
      showContent: function(latestNews) {
        console.log(latestNews);
        // dialogue.setDialogue(dialogueType);
      }
    }
  });

  function directTo(id, url) {
    window.open(url, '_blank');
    
  }
  function showDetail(info) {
    // show the dialogue
    
    if(info.url !== '') {
      document.getElementById("detail_resourceName").innerHTML = `<a href="${info.url}" target="_blank">${info.resourceName}</a>`;
    } else {
      document.getElementById("detail_resourceName").innerHTML = info.resourceName;
    }
    
    document.getElementById("detail_resourceType").innerHTML = info.resourceType;
    document.getElementById("detail_startDate").innerHTML = info.startDate;
    document.getElementById("detail_expireDate").innerHTML = info.expireDate;
    document.getElementById("detail_faculty").innerHTML = info.faculty;
    document.getElementById("detail_subject").innerHTML = info.subject;
    document.getElementById("detail_category").innerHTML = info.category;
    document.getElementById("detail_type").innerHTML = info.type;
    document.getElementById("detail_publisher").innerHTML = info.publisher;
    document.getElementById("detail_language").innerHTML = info.language;
    document.getElementById("detail_resourceDescribe").innerHTML = info.resourceDescribe;

    if(info.relevanceUrlDescribe !== '') {
      document.getElementById("detail_relevanceUrlDescribe").innerHTML = `<a href="${info.relevanceUrl !== '' ? info.relevanceUrl : 'javascript:errorMsg(1);'}" target="_blank">${info.relevanceUrlDescribe}</a>`;
    }

    fieldToggle('detailInfo');
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

    // get unchecked list and hide columns
    let uncheckList = getUnCheckedlist();
    for(let index in uncheckList) {
      hideColumn(uncheckList[index]);
    }
  }
  function showField() {
    // init all columns
    document.querySelectorAll('td, th').forEach(res => {
      res.removeAttribute("style");
    });

    // get unchecked list and hide columns
    let uncheckList = getUnCheckedlist();
    for(let index in uncheckList) {
      hideColumn(uncheckList[index]);
    }

    // close the dialogue
    fieldToggle('fieldDisplay');
  }
  function fieldToggle(DOM_id) {
    let element = document.getElementById(DOM_id);
    element.classList.toggle("show");
  }
  function getUnCheckedlist() {
    // get checked list
    let result = [];
    let checkList = document.getElementById("fieldDisplay");
    checkList.querySelectorAll('input[type=checkbox]').forEach(res => {
      // if not checked, hide the column
      if(!res.checked) {
        result.push(res.value);
      }
    })
    return result;
  }
  function hideColumn(colName) {
    let tempClassname = `.${colName}`;
    document.querySelectorAll(tempClassname).forEach(column => {
      column.setAttribute('style', 'display: none;');
    })
  }
  function searchAtoZ(upperCharacter) {
    let lowCharater = upperCharacter.toLowerCase();
    // contactList.search(param);
    contactList.filter(function(item) {
      // the item includes html tag to impact the result
      var regex = /(<([^>]+)>)/ig;
      removeTagResult = item.values().resourceName.replace(regex, "").trim();
      console.log(removeTagResult);
      if (removeTagResult.charAt(0) === upperCharacter || removeTagResult.charAt(0) === lowCharater) {
        return true;
      } else {
        return false;
      }
    });
  }
  function searchBy(term, field) {
    contactList.search(term, [field]);
  }
  function displayDetail(id) {
    let dataListRow = dataList.rows;
    for(index in dataListRow) {
      if(dataListRow[index].id === id) {
        showDetail(dataListRow[index]);
        break;
      }
    }
  }
  function searchAll() {
    // remove all conditions
    contactList.filter();
  }
  function createEnglishAnchor() {
    return new Promise((resolve, reject) => {
      let linkWrap = document.createElement('div')
      linkWrap.className = 'link-field';

      let totalAnchor = document.createElement('a');
      let totalAnchorText = document.createTextNode('全部');
      totalAnchor.setAttribute('href', '#');
      totalAnchor.className = 'clicked';
      totalAnchor.addEventListener('click', searchAll, false);
      totalAnchor.appendChild(totalAnchorText);
      linkWrap.appendChild(totalAnchor);

      // for char A to Z
      for(let loop = 0; loop < 26; loop++) {
        let anchor = document.createElement('a');
        let alphabet = String.fromCharCode(65 + loop);
        let anchorText = document.createTextNode(alphabet);
        anchor.setAttribute('href', `#`);
        anchor.addEventListener('click', function(){ searchAtoZ(`${alphabet}`); }, false);
        anchor.appendChild(anchorText);
        linkWrap.appendChild(anchor);
      }

      resolve(linkWrap)
    })
  }

  // Init list
  var options = {
    valueNames: [ 'resourceName', 'subject', 'resourceType', 'faculty', 'publisher', 'lang' ],
    page: 500
  };
  var contactList = new List('databaseList', options);
</script>
