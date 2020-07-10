<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CALIS ILL</title>
</head>

<form action='http://lib.cnlsp.cn/transfer/gateway/opacloginpage.aspx' method='post' name='frm'>
<?php
foreach ($_GET as $a => $b) {
  echo "<input type='hidden' name='".htmlentities($a, ENT_QUOTES)."' value='".htmlentities($b, ENT_QUOTES)."'>";
}

$univInfo = array (
  // Tianjing Agriculture
  "s5250207" => array("libCode" => "212057"),
  // 天津高等教育文献信息中心
  "s1559136" => array("libCode" => "130200"),
  // 天津师范大学
  "s9895007" => array("libCode" => "212091"),
  // 天津医科大学
  "s8097121" => array("libCode" => "212061"),
  // 天津中医药大学
  "s9003824" => array("libCode" => "212070"),
  // 天津科技大学
  "s4859959" => array("libCode" => "212030"),
  // 天津商业大学
  "s2367855" => array("libCode" => "212130"),
  // 天津职业技术师范大学
  "s5882082" => array("libCode" => "212100"),
  // 天津美术学院
  "s8018086" => array("libCode" => "212170"),
  // 天津工业大学
  "s1349293" => array("libCode" => "212040"),
  // 天津大学
  "s8373064" => array("libCode" => "212020"),
  // 天津财经大学
  "s2379418" => array("libCode" => "212140"),
  // 天津理工大学
  "s9851180" => array("libCode" => "212050"),
  // 天津外国语大学
  "s6237855" => array("libCode" => "212120"),
  // 中国民航大学
  "s3895104" => array("libCode" => "212045"),
  // 天津城建大学
  "s5447684" => array("libCode" => "212054")
);

$uid = isset($_GET['uid']) ? $_GET['uid'] : '';
echo "<input type='hidden' name='tenantcode' value='".$univInfo[$uid]["libCode"]."'>";
?>
</form>

<script language="JavaScript">
document.frm.submit();
</script>



