document.addEventListener("DOMContentLoaded", function(event) {
  setTimeout(function() {
    let holdingsP = document.querySelectorAll('.rtac-panel-content > .circulation > p');
    holdingsP[2].innerHTML = holdingsP[2].innerHTML.replace(/&lt;/g,'<').replace(/&gt;/g,'>');
  }, 3000);
});