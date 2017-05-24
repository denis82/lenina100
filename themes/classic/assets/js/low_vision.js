$(document).ready(function () {
  var isBlind = $.cookie("CecutientCookie");

  /*Включение стилей для слабовидящих*/
  $('#CecutientOn').click(function () {
    CecutientOn();
    //$.cookie("CecutientCookie", "on");
    $.removeCookie("fonts", null);
    $.removeCookie("style", null);
    $.removeCookie("image", null);
    return false;


  });


  var selectorsEdit = $('.wrapper, body,.menu-list,' +
    '.header .slogan, .header .adress, .header .adress .weekend,' +
    '.header .phone .phone-name,.header .phone .phone-top,' +
    '.slider-block .name,.block-name,.last-news .block-name,' +
    'h1,h2,h3,h4,h5,td,th,b,.footer,.main_menu li,.blackstyle .main_menu .submenu' +
    '.blackstyle .main_menu .submenu,.main_menu a.sub,.question i,' +
    '.phone-num,.small,div.sub-menu, .main div, .main a, .side-form textarea,.side-form input,h1, h2, h3, h4, h5, h6, span.red ');

  /*alert($.cookie("fonts")+'&'+$.cookie("CecutientCookie"));*/

  if (isBlind === "on") {
    CecutientOn();
    if ($.cookie("fonts") == "small") {
      SmallFonts();
    }
    if ($.cookie("fonts") == "medium") {
      MediumFonts();
    }
    if ($.cookie("fonts") == "big") {
      BigFonts();
    }
    if ($.cookie("image") == "on") {
      ImageOn();
    }
    if ($.cookie("image") == "off") {
      ImageOff();
    }
    if ($.cookie("style") == "white") {
      WhiteStyle();
    }
    if ($.cookie("style") == "black") {
      BlackStyle();
    }
    if ($.cookie("style") == "blue") {
      BlueStyle();
    }
    if ($.cookie("style") == "green") {
      GreenStyle();
    }
  }

  /*Включение выключение изображений*/
  $('#ImageOn').click(function () {
    ImageOn();
  });
  $('#ImageOff').click(function () {
    ImageOff();
  });
  /*Размер шрифта*/
  $('#SmallFonts').click(function () {
    SmallFonts();
  });
  $('#MediumFonts').click(function () {
    MediumFonts();
  });
  $('#BigFonts').click(function () {
    BigFonts();
  });
  /*Цветовая схема*/
  $('#WhiteStyle').click(function () {
    WhiteStyle();
  });
  $('#BlackStyle').click(function () {
    BlackStyle();
  });
  $('#BlueStyle').click(function () {
    BlueStyle();
  });
  $('#GreenStyle').click(function () {
    GreenStyle();
  });

  /*Функция обработчик включения стилей*/
  function CecutientOn() {
    $('#CecutientWrapper').addClass('vision');
    $('body').toggleClass('low-vision');
    $('#CecutientOn').toggle();


    $('.wrapper').removeClass('whitestyle, blackstyle, bluestyle, greenstyle');
    $.cookie("CecutientCookie", "on", {
      expires: 365,
      path: '/'
    });
    return false;
  }

  /*Функции изменения размера шрифта*/
  function SmallFonts() {
    if ($.cookie("CecutientCookie") == "on") {
      $('.wrapper, #CecutientWrapper, .main_menu a, ' +
        '.header .adress .adress-top,.header .adress .working-name,' +
        '.header .adress .working-time,.header .phone .phone-top,' +
        '.menu-list li .button, .last-news .block-name, p, li, b, ' +
        'table,td,th,.footer,.question .quest,.block-name,div.answer_link,a.button.red,.row .span3,.question,.main' +
        '.main div, .main a, .sidebar a, .sidebar b, sidebar p, .sidebar li, .sidebar td,' +
        '.sidebar th, .sidebar table, .sidebar span,input,label,.side-form button,.side-form label,' +
        'div.sub-menu div.sub-content div a.sub-link,div.take-go div.title,div.take-go div.text, td span')
      .removeClass("MediumFonts BigFonts").addClass("SmallFonts");
      $.cookie("fonts", "small", {
        expires: 365,
        path: '/'
      });
      return false;
    }
  }

  function MediumFonts() {
    if ($.cookie("CecutientCookie") == "on") {
      $('.wrapper, #CecutientWrapper, .main_menu a, ' +
        '.header .adress .adress-top,.header .adress .working-name,' +
        '.header .adress .working-time,.header .phone .phone-top,' +
        '.menu-list li .button, .last-news .block-name, p, li, b, ' +
        'table,td,th,.footer,.question .quest,.block-name,div.answer_link,a.button.red,.row .span3,.question, .small,.question, .main' +
        '.main div, .main a, .sidebar a, .sidebar b, sidebar p, .sidebar li, .sidebar td,' +
        '.sidebar th, .sidebar table, .sidebar span,input,label,.side-form button,.side-form label,' +
        'div.sub-menu div.sub-content div a.sub-link,div.take-go div.title,div.take-go div.text, td span')
      .removeClass("SmallFonts BigFonts").addClass("MediumFonts");
      $.cookie("fonts", "medium", {
        expires: 365,
        path: '/'
      });
      return false;
    }
  }

  function BigFonts() {
    if ($.cookie("CecutientCookie") == "on") {
      $('.wrapper, #CecutientWrapper, .main_menu a, ' +
        '.header .adress .adress-top,.header .adress .working-name,' +
        '.header .adress .working-time,.header .phone .phone-top,' +
        '.menu-list li .button, .last-news .block-name, p, li, b, ' +
        'table,td,th,.footer,.question .quest,.block-name,div.answer_link,a.button.red,.row .span3,.question, .small,.main' +
        '.main div, .main a, .sidebar a, .sidebar b, sidebar p, .sidebar li, .sidebar td,' +
        '.sidebar th, .sidebar table, .sidebar span,input,label,.side-form button,.side-form label,' +
        'div.sub-menu div.sub-content div a.sub-link,div.take-go div.title,div.take-go div.text, td span')
      .removeClass("SmallFonts MediumFonts").addClass("BigFonts");
      $.cookie("fonts", "big", {
        expires: 365,
        path: '/'
      });
      return false;
    }
  }

  /*Функции обработчик отображения изображений*/


  function ImageOn() {
    if ($.cookie("CecutientCookie") == "on") {
      $('img').css("display", "inline-block");
      $('#ImageOff').css("display", "inline-block");
      $('#ImageOn').css("display", "none");
      $.cookie("image", "on", {
        expires: 365,
        path: '/'
      });
      return false;
    }
  }

  function ImageOff() {
    if ($.cookie("CecutientCookie") == "on") {
      $('img').css("display", "none");
      $('#ImageOff').css("display", "none");
      $('#ImageOn, #CecutientBtn img').css("display", "inline-block");
      $('').css("display", "inline-block");
      $.cookie("image", "off", {
        expires: 365,
        path: '/'
      });
      return false;
    }
  }

  /*Функции изменения цветовой схема*/
  function WhiteStyle() {
    if ($.cookie("CecutientCookie") == "on") {
      selectorsEdit.removeClass("bluestyle blackstyle greenstyle").addClass("whitestyle").css({
        "background":"#fff",
        "color":""
      });
      $('#CecutientWrapper').removeClass("bluestyle blackstyle greenstyle").addClass("whitestyle");

      $('.container').css({"padding": "0px"});
      $('.wrapper, #footer, .container *').css({"background": "#fff", "color": "#000"});
      $('.wrapper, #CecutientTop, p, .wrapper a, .container').css("color", "#000");
      $('.TopMenu').css({"border": "1px solid #000", "marginTop": "10px"});
      $('.TopMenu li a').css({"background": "none", "paddingTop": "0px", "color": "#000"});
      $.cookie("style", "white", {
        expires: 365,
        path: '/'
      });
      return false;
    }
  }

  function BlackStyle() {
    if ($.cookie("CecutientCookie") == "on") {

      selectorsEdit.removeClass("bluestyle whitestyle greenstyle").addClass("blackstyle").css({
        "background": "#000",
        "color": "#fff"
      });

      $('#CecutientWrapper').removeClass("bluestyle whitestyle greenstyle").addClass("blackstyle");
      $('#container').css({"padding": "0px", "color": "#fff"});
      $('.wrapper, #footer, .container *').css({"background": "#000", "color": "#fff"});
      $('.wrapper, #CecutientTop, p, .wrapper a').css("color", "#fff");
      $('.TopMenu').css({"border": "1px solid #fff", "marginTop": "10px"});
      $('.TopMenu li a').css({"background": "none", "color": "#fff"});
      $.cookie("style", "black", {
        expires: 365,
        path: '/'
      });
      return false;
    }
  }

  function BlueStyle() {
    if ($.cookie("CecutientCookie") == "on") {
      selectorsEdit.removeClass("blackstyle whitestyle greenstyle").addClass("bluestyle").css({
        "background":"#9DD1FF",
        "color":"#063462"
      });
      $('#CecutientWrapper').removeClass("blackstyle whitestyle greenstyle").addClass("bluestyle");
      $('.container').css({"padding": "0px"});
      $('.wrapper, #footer, .container *').css({"background": "#9DD1FF", "color": "#063462"});
      $('.wrapper, #CecutientTop, p, .wrapper a, .container').css("color", "#063462");
      $('.TopMenu').css({"border": "1px solid #063462", "paddingBottom": "10px", "marginTop": "10px"});
      $('.TopMenu li a').css({"background": "none", "paddingTop": "0px", "color": "#063462"});
      $.cookie("style", "blue", {
        expires: 365,
        path: '/'
      });
      return false;
    }
  }

  function GreenStyle() {
    if ($.cookie("CecutientCookie") == "on") {
      selectorsEdit.removeClass("blackstyle whitestyle bluestyle").addClass("greenstyle").css({
        "background":"#3B2716",
        "color":"rgb(169, 228, 77)"
      });
      $('#CecutientWrapper').removeClass("blackstyle whitestyle bluestyle").addClass("greenstyle");
      $('.container').css({"padding": "0px"});
      $('.wrapper, #footer, .container *').css({"background": "#3B2716", "color": "#A9E44D"});
      $('.wrapper, #CecutientTop, p, .wrapper a, .container').css("color", "#A9E44D");
      $('.TopMenu').css({
        "border": "1px solid #A9E44D",
        "paddingTop": "10px",
        "paddingBottom": "10px",
        "marginTop": "10px"
      });
      $('.TopMenu li a').css({"background": "none", "paddingTop": "0px", "color": "#A9E44D"});
      $.cookie("style", "green", {
        expires: 365,
        path: '/'
      });
      return false;
    }
  }


  /*Отключение версии для слабовидящих*/
  $('#CecutientOff,#CecutientOff1').click(function () {
    $.cookie('CecutientCookie', null, {path: '/'});
    //$.cookie("CecutientCookie", "off");
    // $.removeCookie('CecutientCookie');
    $.removeCookie('style');
    $.removeCookie('image');
    $.removeCookie('fonts', null);
    window.location.reload();
    return false;
  });
});