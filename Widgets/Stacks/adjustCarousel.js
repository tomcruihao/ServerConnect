var trackCall = setInterval(function() {  
  if (window.jQuery) {
    clearInterval(trackCall);
    try{
      setTimeout(function(){
        jQuery(function($) {
        // slick(option name, value, reFresh);
          $('#slider-31556').slick("slickSetOption", "swipeToSlide", true, false);
          $('#slider-31556').slick("slickSetOption", "slidesToShow", 3, true);
        });
      }, 1000);
    }
    catch(e){
    }
  }
}, 500);