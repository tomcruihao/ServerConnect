function verifyToken () {
  if("user" in localStorage) {
    window.location.replace("https://gss.ebscohost.com/chchang/ServerConnect/databaseList/admin/");
  } else {
    directToIndex();
  }
}

function directToIndex() {
  window.location.replace("https://gss.ebscohost.com/chchang/ServerConnect/databaseList/admin/");
}

verifyToken();
