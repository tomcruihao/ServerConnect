  // this acronym is for table name, if want to know please check html table class
  const univAcronymAry = ['nuc'];
  const anchorKeyword = 'Retrieve Catalogue Item';
  const sid = 's1213459';
  const backendUrl_OPAC = 'https://gss.ebscohost.com/chchang/ServerConnect/huiwen/opac.php';
  const backendUrl_RTAC = 'https://gss.ebscohost.com/chchang/ServerConnect/huiwen/rtac.php';
  const orderList = ['可借','阅览'];

  async function processResultPage() {
    document.querySelectorAll("em[data-hoverpreviewjson]").forEach(async res => {
      let jsonValue = res.getAttribute("data-hoverpreviewjson");
      let convert = JSON.parse(jsonValue);
      let univAcronym = await getUnivAcronym(univAcronymAry, convert.term);

      if(univAcronym) {
        // get marc number

        let abstractTemp, marc;

        try{
          abstractTemp = ep.clientData.currentRecord.Term.split(".");
          marc = abstractTemp[1];
        } catch(e){
          abstractTemp = convert.term.split(".");
          marc = abstractTemp[1];
        }

        // get anchor node
        let parent = res.parentNode;
        let anchor = parent.querySelector(`a[title^="${anchorKeyword}"]`);
        
        const opacUrl = await getOPAC_Url(marc);

        // replace the link of Anchor
        if (anchor) {
          anchor.setAttribute('href', opacUrl);
        }

        let checkExist = setInterval(async function() {
          if (($(`.rtac_holdings_${univAcronym}_${marc}`).length || $(`.rtac_holdings_${univAcronym}c_${marc}`).length) && opacUrl) {
            clearInterval(checkExist);

            let tableFrameDOM, tableBodyDOM, tableDOM, tableSize;

            if (document.querySelector(`.rtac_holdings_${univAcronym}_${marc}`) !== null) {
              // get DOM and add spinner
              tableFrameDOM = document.querySelector(`.rtac_holdings_${univAcronym}_${marc}`);
              tableBodyDOM = document.querySelector(`.rtac_holdings_${univAcronym}_${marc}>table>tbody`);
              tableBodyDOM.innerHTML = '<tr><td><img src="https://gss.ebscohost.com/chchang/resource/imgs/Spinner.svg" style="width: 50px; height: 50px;"></td></tr>';

              tableDOM = document.querySelector(`.rtac_holdings_${univAcronym}_${marc}>table`);
            } else if (document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}`) !== null) {
              tableFrameDOM = document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}`);
              tableBodyDOM = document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}>table>tbody`);
              tableBodyDOM.innerHTML = '<tr><td><img src="https://gss.ebscohost.com/chchang/resource/imgs/Spinner.svg" style="width: 50px; height: 50px;"></td></tr>';
              
              tableDOM = document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}>table`);
            }
            let RTAC_Info = await getRTAC_Info(opacUrl);
            replaceRTAC_TableValue(marc, univAcronym, RTAC_Info);

            // get table size and toggle needing checking
            tableSize = tableDOM.clientHeight;
            if(tableSize > 150) {
              let button = document.createElement('button');
              button.innerHTML = '显示更多';
              button.onclick = function(){
                if(this.innerText === "显示更多") {
                  this.innerText = "收起";
                } else {
                  this.innerText = "显示更多";
                }

                tableFrameDOM.classList.toggle("toggle");
                // alert('here be dragons');
                return false;
              };
              let btnFrame = document.createElement('div');
              btnFrame.className = 'opac-button-frame';
              btnFrame.appendChild(button);

              tableFrameDOM.parentNode.appendChild(btnFrame);
            }
          }
        }, 1000);
      }
    });
  }
  async function processDetailPage() {
    try {
      let abstractTemp = ep.clientData.currentRecord.Term.split(".");
      let marc = abstractTemp[1];
      let anchor = document.querySelector(`a[title^="${anchorKeyword}"]`);
      let univAcronym = await getUnivAcronym(univAcronymAry, abstractTemp);

      const opacUrl = await getOPAC_Url(marc);

      // replace the link of Anchor
      if (anchor) {
        anchor.setAttribute('href', opacUrl);
      }

      let checkExist = setInterval(async function() {
        if ((document.querySelector(`.rtac_holdings_${univAcronym}_${marc}`) !== null || document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}`) !== null) && opacUrl) {
          clearInterval(checkExist);
          let tableFrameDOM, tableBodyDOM, tableDOM, tableSize;

          if (document.querySelector(`.rtac_holdings_${univAcronym}_${marc}`) !== null) {
            // get DOM and add spinner
            tableFrameDOM = document.querySelector(`.rtac_holdings_${univAcronym}_${marc}`);
            tableBodyDOM = document.querySelector(`.rtac_holdings_${univAcronym}_${marc}>table>tbody`);
            tableBodyDOM.innerHTML = '<tr><td><img src="https://gss.ebscohost.com/chchang/resource/imgs/Spinner.svg" style="width: 50px; height: 50px;"></td></tr>';

            tableDOM = document.querySelector(`.rtac_holdings_${univAcronym}_${marc}>table`);
          } else if (document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}`) !== null) {
            tableFrameDOM = document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}`);
            tableBodyDOM = document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}>table>tbody`);
            tableBodyDOM.innerHTML = '<tr><td><img src="https://gss.ebscohost.com/chchang/resource/imgs/Spinner.svg" style="width: 50px; height: 50px;"></td></tr>';
            
            tableDOM = document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}>table`);
          }
          let RTAC_Info = await getRTAC_Info(opacUrl);
          replaceRTAC_TableValue(marc, univAcronym, RTAC_Info);

          // get table size and toggle needing checking
          tableSize = tableDOM.clientHeight;
          if(tableSize > 150) {
            let button = document.createElement('button');
            button.innerHTML = '显示更多';
            button.onclick = function(){
              if(this.innerText === "显示更多") {
                this.innerText = "收起";
              } else {
                this.innerText = "显示更多";
              }

              tableFrameDOM.classList.toggle("toggle");
              // alert('here be dragons');
              return false;
            };
            let btnFrame = document.createElement('div');
            btnFrame.className = 'opac-button-frame';
            btnFrame.appendChild(button);

            tableFrameDOM.parentNode.appendChild(btnFrame);
          }

          replaceRTAC_LeftHandSide_Table(RTAC_Info);
        }
      }, 1000);
    } catch(e){
      console.log(e);
    }
  }
  async function getUnivAcronym(acronymAry, term) {
    return new Promise(function(resolve, reject) {
      let result = null;
      for(index in acronymAry) {
        if(term.indexOf(acronymAry[index]) >= 0) {
          result = acronymAry[index];
          break;
        }
      }
      resolve(result);
    });
  }
  async function getOPAC_Url(marc) {
    return new Promise(function(resolve, reject) {
      let opacUrl;

      let xhr = new XMLHttpRequest();
      xhr.open('GET', `${backendUrl_OPAC}?marc=${marc}&sid=${sid}`);
      xhr.onload = function() {
        if (xhr.status === 200) {
          opacUrl = xhr.responseText;
          resolve(opacUrl);
        } else {
          let errorLog = `Request failed. Returned status of ${xhr.status}`;
          console.log(errorLog)
        }
      };
      xhr.send()
    });
  }
  async function getRTAC_Info(opacUrl) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        url: backendUrl_RTAC,
        type: 'GET',
        data: {
          oriurl: opacUrl
        },
        error: function(jqXHR, exception) {
          console.log(jqXHR);
          console.log(exception);
          reject();
        },
        success: function(res) {
          resolve(res);
        }
      });
    });
  }
  function replaceRTAC_LeftHandSide_Table(rtacInfo) {
    let tempTable = document.createElement("div");
    tempTable.innerHTML = rtacInfo;
    let tableContent = tempTable.querySelector('.whitetext');
    let container = document.querySelectorAll(`.rtac-panel>.rtac-panel-content>.circulation>p`);

    // location
    let localtion = tableContent.querySelector(`td:nth-of-type(4)`).innerHTML.replace(/<img .*?>/g,'');
    container[0].innerHTML = `<strong>地点:</strong>${localtion}`;

    let booknumber = tableContent.querySelector(`td:nth-of-type(1)`).innerHTML;
    container[1].innerHTML = `<strong>索书号:</strong>${booknumber}`;

    let status = tableContent.querySelector(`td:nth-of-type(5)`).innerHTML;
    container[2].innerHTML = `<strong>状态:</strong>${status}`;
  }
  function replaceRTAC_TableValue(marc, univAcronym, rtacInfo) {
    let getTableForAddClass
    let catTable

    // check Table Name and assigned
    if (document.querySelector(`.rtac_holdings_${univAcronym}_${marc}`) !== null) {
      getTableForAddClass = document.querySelector(`.rtac_holdings_${univAcronym}_${marc}`);
      catTable = document.querySelector(`.rtac_holdings_${univAcronym}_${marc}>table>tbody`);
    } else {
      getTableForAddClass = document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}`);
      catTable = document.querySelector(`.rtac_holdings_${univAcronym}c_${marc}>table>tbody`);
    }

    // create table
    let tempTable = document.createElement("div");
    tempTable.innerHTML = rtacInfo;
    let tableContent = tempTable.querySelectorAll('.whitetext');
    let result = '';

    // create temp list array
    let tempRowList = [];
    for(index in orderList) {
      tempRowList[orderList[index]] = [];
    }
    tempRowList['other'] = [];

    tableContent.forEach(function(elements) {
      let localtion = elements.querySelector(`td:nth-of-type(4)`).innerHTML.replace(/<img .*?>/g,'');
      let booknumber = elements.querySelector(`td:nth-of-type(1)`).innerHTML;
      let status = elements.querySelector(`td:nth-of-type(5)`).innerHTML;
      let statusText = elements.querySelector(`td:nth-of-type(5)`).innerText.trim();
      let content = `<tr><td data-label="地点">${localtion}</td><td data-label="索书号">${booknumber}</td><td data-label="状态">${status}</td></tr>`;
      result = result + content;

      if(orderList.indexOf(statusText) >= 0) {
        tempRowList[statusText].push(content);
      } else {
        tempRowList['other'].push(content);
      }
    });

    catTable.innerHTML = orderRowAndInsertInTable(tempRowList);

    getTableForAddClass.classList.add("lib-info");
    
  }
  function orderRowAndInsertInTable(ary) {
    let result = '';
    for(index in ary) {
      ary[index].forEach(element => {
        result = result + element;
      });
    }
    return result;
  }
  processResultPage();
  processDetailPage();
