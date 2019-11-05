<?php
  header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json; charset=utf-8');
  header( 'Content-Type:text/html;charset=utf-8 ');


  $randomBookQuantity = 20;
  $apiConnection = "https://eit.ebscohost.com/Services/SearchService.asmx/Search?prof=tylee.main.eit&&pwd=ebs3705&db=edsebk";

  // Get the contents of the JSON file 
  $strJsonFileContents = file_get_contents("./booklist.json");

  // Convert to array 
  $totalBooklist = json_decode($strJsonFileContents, true);

  $randomBooklist = getRandomBookList($totalBooklist, $randomBookQuantity);

  $bookInfoList = getBookInfoFromServer($apiConnection, $randomBooklist);

  generateHTML($bookInfoList);

  function generateHTML($bookList) {
    foreach($bookList as $key => $value) {
      echo '<div class="ebook-wrap"><a href="'.$value['directionUrl'].'" target="_blank"><div class="image-frame"><img src="'.$value['imgUrl'].'" title="'.$value['title'].'"></div><h2>'.$value['title'].'</h2></a></div>';
    }
    // onerror="this.src=\''.$value['onErrorUrlImg'].'\'" 
  }

  function getBookInfoFromServer($apiUrl, $booklist) {
    $result = array();

    // generate query
    $queryContent = 'IB+';
    foreach($booklist as $key => $value) {
      if($key) {
        $queryContent = $queryContent.'+or+'.$value['isbn'];
      } else {
        $queryContent = $queryContent.$value['isbn'];
      }
    }

    // get value from API
    $apiUrl = $apiUrl."&query=".$queryContent;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $xml = curl_exec($ch);
    $parseXml = simplexml_load_string($xml);
    curl_close($ch);

    foreach($parseXml->SearchResults->records->children() as $rec) {
      // get url and parse
      $parseUrlParam = parse_url($rec->plink);
      parse_str($parseUrlParam['query'], $query);
      $parts = parse_url($url);
      $AN = $query['AN'];
      $imgUrl = 'http://rps2images.ebscohost.com/rpsweb/othumb?id=NL$'.$AN.'$PDF&s=l';
      $directionUrl = 'http://search.ebscohost.com/login.aspx?direct=true&db=nlebk&AN='.$AN.'&site=ehost-live&custid=s1213459&authtype=ip,uid&groupid=main&profileid=ehost&scope=site';
      $onErrorImgUrl = 'http://rps2images.ebscohost.com/rpsweb/othumb?id=NL$'.$AN.'$EPUB&s=l';
      $title = $rec->header->controlInfo->bkinfo->btl;
      $tempItem = array('title' => strval($title), 'imgUrl' => strval($imgUrl), 'directionUrl' => strval($directionUrl), 'onErrorUrlImg' => strval($onErrorImgUrl));
      array_push($result, $tempItem);
    }

    return $result;
  }

  function getRandomBookList($booklist, $quantity) {
    $elementCount = count($booklist);
    $result = array();
    $randomNumAry = array();

    while(count($randomNumAry) <= $quantity) {
      array_push($randomNumAry, mt_rand(0, $elementCount - 1));
      $randomNumAry = array_unique($randomNumAry);
    }

    foreach($randomNumAry as $value){
      array_push($result, $booklist[$value]);
    }
    return $result;
  }
?>
<style type="text/css">
  html, body {
    margin: 0;
    padding: 0;
  }

  * {
    box-sizing: border-box;
  }

  .slider {
    width: 90%;
    margin: 100px auto;
  }

  .slick-slide {
    margin: 0px 20px;
  }

  .slick-slide img {
    width: 100%;
  }

  .slick-prev:before,
  .slick-next:before {
    color: black;
  }
  a {
    outline: none;
    text-decoration: none;
  }
  .ebook-wrap img {
    width: auto;
    height: 100%;
  }
  .ebook-wrap {
    position: relative;
  }
  .ebook-wrap h2 {
    width: 100%;
    margin: 0;
    padding: 3px;
    text-align: center;
    font-size: 16px;
    color: #ffffff;
    background-color: rgba(0, 0, 0, 0.7);
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    position: absolute;
    bottom: 0px;
    left: 0px;
    opacity: 0;
  }
  .image-frame {
    height: 200px;
    /*box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.7);*/
    display: flex;
    justify-content: center;
  }
  .image-frame:hover + h2 {
    opacity: 1;
    transition: opacity 0.3s ease-in-out;
  }

  /* when screen pixel less than 640px */
  @media screen and (max-width: 639px) {
    .image-frame {
      height: 300px;
    }
  }
</style>