  var connectToBackendUrl = "http://gss.ebscohost.com/chchang/ServerConnect/carouselQuery/index.php";
  var queryParam = document.currentScript.getAttribute('query');

  const carouselParam = {
    dots: true,
    infinite: true, 
    slidesToShow: 5,
    slidesToScroll: 5,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 640,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      }
    ]
  };

  let makeEbookField = () => {
    return new Promise((resolve, reject) => {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          let result = '';
          let apiValue = JSON.parse(this.response);
          for(let count in apiValue) {
            result = result + `<div class="ebook-wrap"><a href="${apiValue[count].directionUrl}" target="_blank"><div class="image-frame"><img src="${apiValue[count].imgUrl}" onerror="this.src='${apiValue[count].onErrorUrlImg}'" title="${apiValue[count].title}"></div><h2>${apiValue[count].title}</h2></a></div>`;
          }
          resolve(result);
        }
      };

      let urlWithParam = connectToBackendUrl;
      if(queryParam) {
        urlWithParam = `${connectToBackendUrl}?uquery=${queryParam}`;
      }
      xhttp.open("GET", urlWithParam, true);
      xhttp.send();
    })
  }
  async function genCarousel() {
    $(".regular").slick(carouselParam);
  }
  async function initial() {
    return new Promise((resolve, reject) => {
      var head = document.getElementsByTagName('HEAD')[0];  

      // Create new link Element 
      let link_slick = document.createElement('link');
      link_slick.rel = 'stylesheet';  
      link_slick.type = 'text/css'; 
      link_slick.href = 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css';

      let link_slickTheme = document.createElement('link');
      link_slickTheme.rel = 'stylesheet';  
      link_slickTheme.type = 'text/css'; 
      link_slickTheme.href = 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css';

      let link_indexCss = document.createElement('link');
      link_indexCss.rel = 'stylesheet';  
      link_indexCss.type = 'text/css'; 
      link_indexCss.href = 'http://gss.ebscohost.com/chchang/ServerConnect/carousel/lib/css/index.css';

      let script = document.createElement("script");
      script.src = 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js';

      // Append link element to HTML head 
      head.appendChild(link_slick);
      head.appendChild(link_slickTheme);
      head.appendChild(link_indexCss);
      head.appendChild(script);

      resolve();
    })
  }
  $(document).on('ready', async function() {
    console.log(queryParam);

    // init js and css
    const init = await initial();
    $("#ebook").append(await makeEbookField());
    const carousel = await genCarousel();
  });