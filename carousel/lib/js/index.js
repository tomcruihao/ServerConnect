  var connectToBackendUrl = "http://gss.ebscohost.com/chchang/ServerConnect/carousel/index.php";

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
      xhttp.open("GET", connectToBackendUrl, true);
      xhttp.send();
    })
  }
  // async function getRandomBookList() {
  //   let listAry = []
  //   let recommandBookLength = recommandBookList.length;
  //   while(listAry.length < randomQuantity) {
  //     let randomValue = Math.floor(Math.random()*recommandBookLength);
  //     if(!listAry.includes(randomValue)) {
  //       listAry.push(randomValue);
  //     }
  //   }
  //   return listAry;
  // }
  async function genCarousel() {
    $(".regular").slick({
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
    });
  }
  $(document).on('ready', async function() {
    $("#ebook").append(await makeEbookField());
    const carousel = await genCarousel();
  });