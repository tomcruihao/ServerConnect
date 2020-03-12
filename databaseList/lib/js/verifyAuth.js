function verifyToken () {
  if("user" in localStorage) {
    let userEncode = localStorage.getItem('user');
    let user = JSON.parse(userEncode);
    let expiredDatetime = Date.parse(user.expiredTime);

    let today = new Date();
    if(today > expiredDatetime) {
      console.log('expired');
      // directToIndex();
    } else {
      console.log('not expired');
    }

  } else {
    directToIndex();
  }
}

function directToIndex() {
  window.location.replace("https://gss.ebscohost.com/chchang/ServerConnect/databaseList/admin/");
}

verifyToken();
