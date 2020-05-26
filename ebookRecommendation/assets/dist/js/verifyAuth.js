function verifyToken () {
  if("user" in localStorage) {
    let userEncode = localStorage.getItem('user');
    let user = JSON.parse(userEncode);
    let expiredDatetime = Date.parse(user.expiredTime);

    let now = new Date();
    if(now > expiredDatetime) {
      directToIndex();
    }
  } else {
    directToIndex();
  }
}

function directToIndex() {
  window.location.replace("https://gss.ebscohost.com/chchang/ServerConnect/ebookRecommendation/admin/index.html");
}

verifyToken();
