<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<title>eBook Preview</title>
  <script language='javascript'>
    function init(){
      var form = document.forms[0];
      form.target = "ebookframe"
      form.action = "redirectindex.php"
      form.submit();
    }
  </script>
<!--
<script type="text/javascript" src="script.js"></script>
-->
</head>     
<body onload="init();">
  <a href="http://archive.nstl.gov.cn/Archives/search.do?action=quickSearch&searchText=10.1007/s002360050037&dbname=All&searchType=fuzzy&field1=DOI" target="_blank">
    Test
  </a>
  <div id="ViewTimer"></div>
  <div id="iframe">
    <form id="send" method="post">
    </form>
    <iframe name = "ebookframe" width="100%" height="95%"/>
  </div>
</body>   
</html>
