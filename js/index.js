$(document).ready(function() {
  $(".menu-header").click(function() {
    $(".menu-pannel-wrp").addClass("active");
  });
  $(".close-btn span").click(function() {
    $(".menu-pannel-wrp").removeClass("active");
  });

  $(".updt-mdl-map").click(function() {
    $('input[name="updt-id"]').val($(this).attr("updt-id"));
    $('input[name="updt-name"]').val($(this).attr("updt-name"));
    $('input[name="updt-salt"]').val($(this).attr("updt-salt"));
    $('input[name="updt-api1"]').val($(this).attr("updt-api1"));
    $('input[name="updt-api2"]').val($(this).attr("updt-api2"));
  });

  $(".del-mdl-map").click(function() {
    $('input[name="del-id"]').val($(this).attr("del-id"));
    $("#del-usr-name").text($(this).attr("del-name"));
  });
});
