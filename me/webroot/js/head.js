$(window).scroll(function () {
  if ($(document).scrollTop() < 1) {
    $('#header').removeClass('tiny');
    $('.sitetitle').removeClass('tiny');
    $('.siteslogan').removeClass('tiny');
    $('.sitelogo').removeClass('tiny');
    $('#header nav').removeClass('tiny');
    $('#main').removeClass('scrolled');
  } else {
    $('#header').addClass('tiny');
    $('.sitetitle').addClass('tiny');
    $('.siteslogan').addClass('tiny');
    $('.sitelogo').addClass('tiny');
    $('#header nav').addClass('tiny');
    $('#main').addClass('scrolled');
  }
});                                                                          