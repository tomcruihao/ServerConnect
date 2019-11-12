<?php
  $url = '';
  $message = '';
  $disabled = false;
  // get parameter from URL
  if(isset($_GET["DOI"])) {
    $DOI = $_GET['DOI'];
    $url = "http://archive.nstl.gov.cn/Archives/search.do?action=quickSearch&searchText=".$DOI."&dbname=All&searchType=fuzzy&field1=DOI";
    $message = "请点击下方的按钮访问国家科技图书文献中心";
  } elseif(isset($_GET["Title"])) {
    $title = $_GET['Title'];
    $url = "http://archive.nstl.gov.cn/Archives/search.do?action=quickSearch&searchText=".$title."&dbname=All&searchType=fuzzy&field1=Title";
    $message = "请点击下方的按钮访问国家科技图书文献中心";
  } else {
    $message = "抱歉, 这篇期刊/电子书资讯有误, 请<a href='mailto:ChinaSupport@ebsco.com'>点击</a>此处与客服人员联系, 谢谢";
    $disabled = true;
  }
?>
<div>
  <h2><?php echo $message ?></h2>
  <button onclick="exe()" disabled="<?php echo $disabled ?>">
    访问国家科技图书文献中心
  </button>
</div>
<style type="text/css">
  button {
    padding: 10px;
    font-size: 16px;
  }
</style>
<script type="text/javascript">
  var checkingExpiredMin = 10;
  
  async function exe() {
    const timeExpired = await checkExpiration();

    if(timeExpired) {
      const open = await openHome();
      openRealUrl();
    } else {
      openRealUrl();
    }
  }
  function checkExpiration() {
    return new Promise((resolve, reject) => {
      let dateObj = new Date();
      let now = dateObj.getTime();

      if(localStorage.getItem("NSTL") === null) {
        // if the recording not exist, create an item and save it in localstorage
        let nstlInfo = {'updateTime': now};
        localStorage.setItem('NSTL', JSON.stringify(nstlInfo));
        resolve(true);
      } else {
        const getTimeObj = JSON.parse(localStorage.getItem('NSTL'));
        const latestTime = getTimeObj.updateTime;
        const elapsedMin = parseInt(now - latestTime) / 1000 / 60;

        if(elapsedMin > checkingExpiredMin) {
          // update timestamp
          let nstlInfo = {'updateTime': now};
          localStorage.setItem('NSTL', JSON.stringify(nstlInfo));
          resolve(true);
        } else {
          resolve(false);
        }
      }
    })
    // const NSTL = (localStorage.getItem('NSTL')) ? JSON.parse(localStorage.getItem('NSTL')): {'NSTL': {'time': '', 'openHome': true}};
  }
  function openHome() {
    return new Promise((resolve, reject) => {
      let wnd = window.open("http://archive.nstl.gov.cn/Archives/");
      setTimeout(function() {
        wnd.close();
        resolve();
      }, 1500);
    })
  }
  function openRealUrl() {
    window.location.href = <?php echo "'".$url."'" ?>;
  }
  // exe();
</script>