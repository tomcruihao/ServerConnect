// add word info in array
let resourceTable = [];
resourceTable['China Online Journals'] = '万方期刊文章数据库';
resourceTable['China Science & Technology Journal Database'] = '维普期刊文章数据库';
resourceTable['Dissertations of China'] = '万方学位论文数据库';
resourceTable['Academic Conferences in China'] = '万方会议论文数据库';

document.querySelectorAll('#multiSelectDbFilterContent > ul > li').forEach( list => {
  let liName = list.querySelector('label').innerText.trim();
  if(resourceTable[liName]) {
    list.querySelector('label').innerHTML = resourceTable[liName];
  }
});

// change the wording of resource table
function loopToCheck(){
  let content = '';
  try {
    content = document.getElementById('modal').innerText;

    if(content !== '') {
      let list = document.querySelectorAll('.modal-content > .limiter-table > tbody > tr').forEach( list => {
        let tds = list.querySelectorAll('td');
        if(resourceTable[tds[1].innerText.trim()]) {
          // console.log(resourceTable[tds[1].innerText.trim()]);
          tds[1].querySelector('label').innerHTML = resourceTable[tds[1].innerText.trim()];
        }
      });
    }
  } catch (err) {
    console.log(err)
  }
} setInterval(loopToCheck, 1000);
