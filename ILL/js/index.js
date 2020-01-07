let paramTable = [
  {"param": "topic", "domID": "title"},
  {"param": "jtl", "domID": "magtitle"},
  {"param": "mayyear", "domID": "publishdate"},
  {"param": "volume", "domID": "volnum"},
  {"param": "pagination", "domID": "pagenum"},
  {"param": "issn", "domID": "issn"},
  {"param": "doi", "domID": "doi"}
]
document.addEventListener("DOMContentLoaded", function(event) { 
  let url_string = window.location.href;
  let url = new URL(url_string);
  
  for(count in paramTable) {
    let paramVal = url.searchParams.get(paramTable[count].param);
    console.log(paramVal);
    if(paramVal !== null) {
      console.log('exist');
      document.getElementById(paramTable[count].domID).value = paramVal;
    }
  }
});
$("#illForm").submit(function(e) {
  let form = $(this);
  let url = form.attr('action');
  console.log(form);

  $.ajax({
    type: "POST",
    url: 'send.php',
    data: form.serialize(), // serializes the form's elements.
    success: function(data)
    {
       alert(data); // show response from the php script.
    }
  });

  e.preventDefault(); // avoid to execute the actual submit of the form.
});