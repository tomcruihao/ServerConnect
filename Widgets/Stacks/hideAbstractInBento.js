function removeHyperlink(element) {
  try {
    let subjectName = element.querySelector('.bnt-ttl').innerText;

    // remove the hyperlink of the subject
    let element_subject = element.querySelector('.bnt-ttl > h2');
    element_subject.innerHTML = subjectName;

    // remove author
    element.querySelectorAll('.authors').forEach( author =>  {
      let authorText = author.innerText.replace(/\(AUTHOR\)/g,'');

      author.innerHTML = `<span class="lbl">${authorText}</span>`;
    });
    

    if(subjectName.indexOf('Research Starters') === -1) {
      element.querySelectorAll('.item-block-title > a').forEach( anchor =>  {
        let anchorChilds = anchor.childNodes;
        
        let element_h5 = anchor.parentNode;
        element_h5.innerHTML = '';

        anchorChilds.forEach( node => {
          let cln_anchorChild = node.cloneNode(true);
          element_h5.appendChild(cln_anchorChild);
        });

      });
    }
  } catch (err) {
    console.log(err)
  }
}

function replaceIcon(element) {
  try {
    let subjectName = element.querySelector('.bnt-ttl').innerText.toUpperCase();

    if(subjectName.indexOf('LIBRARY CATALOG') !== -1) {
      element.querySelectorAll('.mdi-tablet-android').forEach( icon =>  {
        icon.setAttribute('class', 'pubtype-icon pt-ebook');
      });
      element.querySelectorAll('.mdi-book').forEach( icon =>  {
        icon.setAttribute('class', 'pubtype-icon pt-book');
      });
    } else if(subjectName.indexOf('EBOOKS') !== -1) {
      element.querySelectorAll('.mdi-tablet-android').forEach( icon =>  {
        icon.setAttribute('class', 'pubtype-icon pt-ebook');
      });
    } else if(subjectName.indexOf('JOURNALS & MAGAZINES') !== -1) {
      element.querySelectorAll('.mdi-book').forEach( icon =>  {
        icon.setAttribute('class', 'pubtype-icon pt-academicJournal');
      });

      element.querySelectorAll('.mdi-file-chart').forEach( icon =>  {
        icon.setAttribute('class', 'pubtype-icon pt-serialPeriodical');
      });
    } else if(subjectName.indexOf('NEWS') !== -1) {
      element.querySelectorAll('.mdi-newspaper').forEach( icon =>  {
        icon.setAttribute('class', 'pubtype-icon pt-newspaperArticle');
      });

      element.querySelectorAll('.mdi-file-chart').forEach( icon =>  {
        icon.setAttribute('class', 'pubtype-icon pt-material');
      });
    }
  } catch (err) {
    console.log(err)
  }
}

function replaceSeemoreAnchor(element) {
  try {
    let query = document.getElementById('searchBox').value.replace(/\s/g, '+');
    let basicUrl = 'http://search.ebscohost.com/login.aspx?direct=true&authtype=ip,guest&site=eds-live&profile=eds&groupid=main&custid=s3448411';
    let subjectName = element.querySelector('.bnt-ttl').innerText.toUpperCase();
    let seeMoreAnchor = element.querySelector('.bnt-see-more');
    console.log(subjectName);
    console.log(seeMoreAnchor);

    let pt = '';

    if(subjectName.indexOf('LIBRARY CATALOG') !== -1) {
      pt = '&cli0=FC&clv0=Y';
      seeMoreAnchor.setAttribute('style', 'display: block;');
    } else if(subjectName.indexOf('EBOOKS') !== -1) {
      pt = '+AND+(PT ebook)';
      seeMoreAnchor.setAttribute('style', 'display: block;');
    } else if(subjectName.indexOf('JOURNALS & MAGAZINES') !== -1) {
      pt = '+AND+(PT academic journal OR PT periodical)';
      seeMoreAnchor.setAttribute('style', 'display: block;');
    } else if(subjectName.indexOf('NEWS') !== -1) {
      pt = '+AND+(PT news)';
      seeMoreAnchor.setAttribute('style', 'display: block;');
    }

    seeMoreAnchor.setAttribute('href', `${basicUrl}&bquery=${query}${pt}`);
    seeMoreAnchor.innerHTML = "See more results";
  } catch (err) {
    console.log(err)
  }
}

function hideAbstract(element) {
  try {
    element.querySelectorAll('.bnt-result-item').forEach( bentoResult =>  {
      let summarys = bentoResult.querySelectorAll('.summary');
      summarys.forEach( summary =>  {
        summary.setAttribute('style', 'display: none;');
      })
    });
  } catch (err) {
    console.log(err)
  }
}

function loopToCheckExist(){
  try {
    document.querySelectorAll('.p-item-bento_box').forEach( element =>  {
      if(element !== null) {
        hideAbstract(element);
        replaceSeemoreAnchor(element);
        replaceIcon(element);
        removeHyperlink(element);
      } else {
        console.log('...');
      }
    });
  } catch (err) {
    console.log(err)
  }
}

function loadingLibrary() {
  let head = document.getElementsByTagName('HEAD')[0];

  let link_initCss = document.createElement('link');
  link_initCss.rel = 'stylesheet';  
  link_initCss.type = 'text/css'; 
  link_initCss.href = 'https://gss.ebscohost.com/chchang/resource/css/s3448411/bento.css?v=2.0';

  head.appendChild(link_initCss);
}

loadingLibrary();

var checkAllBento = setInterval(loopToCheckExist, 1000);
setTimeout(function(){ clearInterval(checkAllBento); }, 10000);

