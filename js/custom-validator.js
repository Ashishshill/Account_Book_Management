(function ($) {
  $.fn.inputFilter = function (inputFilter) {
    return this.on(
      "input keydown keyup mousedown mouseup select contextmenu drop",
      function () {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        }
      }
    );
  };
})(jQuery);



$(document).ready(function () {

  function now() {
      var d = new Date();
      var month = d.getMonth() + 1;
      var day = d.getDate();
      var output =
        d.getFullYear() +
        "/" +
        (month < 10 ? "0" : "") +
        month +
        "/" +
        (day < 10 ? "0" : "") +
        day;
      return output;
    }

  function currentYear(){
    var first_date_year = new Date(new Date().getFullYear(), 0, 1);
    return first_date_year
  }

  function lastDateYear(){
    var last_date_year = new Date(new Date().getFullYear(), 11, 31);
    return last_date_year
  }

  $("#date").datetimepicker({
    format: "Y-m-d",
    maxDate: now(), // Needs to be changed "//"
    validateOnBlur: true,
    timepicker: false,
  });
});