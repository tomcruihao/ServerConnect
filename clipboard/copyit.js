document.addEventListener("DOMContentLoaded", function(){
  addCopyToClipboardLink();
});

function addCopyToClipboardLink() {
  var locale = ep.locale;
  var langList = loadLocaleList(locale);
  document.querySelectorAll('.result-list-li').forEach(dom_li => {
    let divPoint = dom_li.querySelector('.result-list-record');
    let jsonValue = divPoint.getAttribute("data-amplitude").replaceAll(/\\/g, "\\").replace(/\//g, "");
    let json_Var = '';
    try {
      json_Var = JSON.parse(jsonValue);
    } catch (error) {
      console.log('Wrong JSON'+jsonValue);
      console.log(error);
    }

    // get parameter
    let title = '';
    let doi = '';
    let isbn = '';
    let issn = '';

    // get doi
    if(json_Var['doi']) {
      doi = json_Var['doi'];
    }

    // get isbn
    if(json_Var['bkinfo']['isbn'].length !== 0) {
      let counter = 0;
      let result = '';
      json_Var['bkinfo']['isbn'].forEach(tempIsbn => {
        if(counter > 0) {
          result = result + ',' + tempIsbn;
        } else {
          result = tempIsbn;
        }
      });
      isbn = result;
    }

    // get issn
    if(json_Var['jinfo']['issn'].length !== 0) {
      let counter = 0;
      let result = '';
      json_Var['jinfo']['issn'].forEach(tempIssn => {
        if(counter > 0) {
          result = result + ',' + tempIssn;
        } else {
          result = tempIssn;
        }
      });
      issn = result;
    }

    // get title
    if(json_Var['title']) {
      title = json_Var['title'];
    }

    // generate copy text
    let copyText = '';
    if(issn !== '') {
      copyText = `Title: ${title}\nDOI: ${doi} \nISSN: ${issn}`;
    } else {
      copyText = `Title: ${title}\nDOI: ${doi} \nISBN: ${isbn}`;
    }

    // generate span frame
    let span_wrap = document.createElement('span');
    span_wrap.setAttribute('class', 'custom-link');

    // generate link and insert in externalLinks
    let externalLinksField = dom_li.querySelector('.externalLinks');
  
    // if the custom link field doesn't exist
    if(!externalLinksField) {
      externalLinksField = document.createElement('div');
      externalLinksField.setAttribute('class', 'record-formats-wrapper externalLinks');

      dom_li.querySelector('.display-info').appendChild(externalLinksField);
    }


    // let button_link = document.createElement('button');
    let button_link = document.createElement('a');
    button_link.innerHTML = `<img class="icon-image" src="https://gss.ebscohost.com/chchang/ServerConnect/clipboard/copy.svg" alt="Copy to clipboard" border="0" style="height:18px;weight:18px;"> ${langList.button_linkText}`;
    button_link.value = copyText;
    button_link.setAttribute('alertText', langList.button_alertText);
    button_link.setAttribute('style', 'font-weight:bold; cursor:pointer;');
    button_link.onclick = function(){
      let el = document.createElement('textarea');
      el.value = this.value;
      document.body.appendChild(el);
      el.select();
      document.execCommand('copy');
      document.body.removeChild(el);
      alert(this.getAttribute('alertText'));
    };
    span_wrap.appendChild(button_link);
    externalLinksField.appendChild(span_wrap);
  });


  function loadLocaleList (langType) {
    let langList = [];
    langList['zh-cn'] = {
      button_linkText: '复制到剪贴板',
      button_alertText: '复制成功'
    }
    langList['zh-tw'] = {
      button_linkText: '複製到剪貼簿',
      button_alertText: '複製成功'
    }
    langList['en'] = {
      button_linkText: 'Copy to clipboard',
      button_alertText: 'Copied'
    }

    if(langType in langList) {
      return langList[langType];
    } else {
      return langList['en'];
    }
  }
}
