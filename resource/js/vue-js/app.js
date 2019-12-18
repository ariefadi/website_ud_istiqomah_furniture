function format_uang(number) {
  if (isNaN(number)) return "";
  number = parseInt(number);
  var str = new String(number);
  var result = "" ,len = str.length;
  for (var i=len-1;i>=0;i--) {
    if ((i+1)%3 == 0 && i+1!= len) result += ".";
    result += str.charAt(len-1-i);
  }
  return result;
}

function reverse_date(date){
  var exp_date = date.split("-");
  var rev = exp_date.reverse();
  return rev.join("-");
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $(".select").select2({
    allowClear: true
  });
  $(".select").select2({
    allowClear: true,
    minimumResultsForSearch: -1,
  });
  $(".select-with-search").select2({
    allowClear: true,
  });
})