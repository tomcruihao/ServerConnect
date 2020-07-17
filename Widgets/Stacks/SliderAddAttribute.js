document.querySelectorAll('.img-wrapper a').forEach(res => {
  console.log(res);
  res.setAttribute("target", "_blank");
});