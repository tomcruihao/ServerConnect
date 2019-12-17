let paramTable = [
  {"param": "topic", "domID": "title"},
  {"param": "jtl", "domID": "magtitle"},
  {"param": "mayyear", "domID": "publishdate"},
  {"param": "volnum", "domID": "volume"},
  {"param": "pagenum", "domID": "pagination"},
  {"param": "issn", "domID": "issn"},
  {"param": "doi", "domID": "doi"}
]
document.addEventListener("DOMContentLoaded", function(event) { 
  let url_string = window.location.href;
  let url = new URL(url_string);
  
  for(count in paramTable) {
    let title = url.searchParams.get(paramTable[count].param);
    console.log(title);
    if(!isEmpty(title)) {
      console.log('exist');
      document.getElementById(paramTable[count].domID);
    }
  }
});
