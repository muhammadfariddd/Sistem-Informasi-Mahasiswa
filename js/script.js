$(document).ready(function () {
  // hilangkan tombol cari
  $(".search-button").hide();

  // event ketika keyword ditulis
  $(".search-input").on("keyup", function () {
    // munculkan icon loading
    $(".loader").show();

    // $.get()
    $.get(
      "ajax/student.php?keyword=" + $(".search-input").val(),
      function (data) {
        $("#table-container").html(data);
        $(".loader").hide();
      }
    );
  });
});
