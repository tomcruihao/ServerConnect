// This script makes the position of MeSH widget to be the first one
var widgetTitles = document.querySelectorAll('div[class*="related-info-area"]>h3>a>span');
var meshPosition = 0;
for(index in widgetTitles) {
  if(widgetTitles[index].innerText === 'Mesh') {
    meshPosition = index;
    break;
  }
}
var widgetList = document.querySelectorAll('div[class*="related-info-area"]');
var tempNode = [];
tempNode.push(widgetList[meshPosition].cloneNode(true));
for(var listIndex = 0; listIndex < widgetList.length; listIndex++) {
  if(listIndex !== parseInt(meshPosition, 10)) {
    tempNode.push(widgetList[listIndex].cloneNode(true));
  }
}

for(var listIndex = 0; listIndex < widgetList.length; listIndex++) {
  widgetList[listIndex].innerHTML = tempNode[listIndex].innerHTML;
}