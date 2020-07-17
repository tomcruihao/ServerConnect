
const verifyKeywords = [
  {
    "title": "Credits:",
    "replaceTo": "製作群註:"
  },
  {
    "title": "完成者註記:",
    "replaceTo": "演出者註:"
  }
];

document.addEventListener("DOMContentLoaded", function(event) { 
  document.querySelectorAll('[data-auto="citation_field_label"]').forEach((elements) => {
    let table_head = elements.innerText.trim();
    replaceWording = getReplaceWording(table_head);

    if(replaceWording) {
      elements.innerText = replaceWording;
    }
  });
});

function getReplaceWording(table_head) {
  let result = false;
  verifyKeywords.forEach((elements) => {
    if(elements.title.indexOf(table_head) !== -1) {
      result = elements.replaceTo;
    }
  });
  return result;
}



// const verifyKeywords = ['有無:'];
// document.querySelectorAll('[data-auto="citation_field_label"]').forEach((elements) => {
//   let title = elements.innerText.trim();
//   let compareResult = verifyKeywords.indexOf(title);
//   let elementValue = '';
//   if(compareResult !== -1) {
//     valueElement = elements.nextSibling;
//     let valueElement_value = valueElement.innerText.trim();
//     valueElement.innerHTML = `<a href="${valueElement_value}" target="_blank">${valueElement_value}</a>`;
//   }
// });
