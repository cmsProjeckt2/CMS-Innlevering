(function($) {

 'use strict';

   // Add margin top
  function adminBar() {    
    var adminbar = $('#wpadminbar').outerHeight();
    $('#masthead').css('margin-top', adminbar); 
  }
  $(window).bind('load', adminBar);

 $(".site-navigation ul li.menu-item-has-children").hover(function() {
  $(this).children(".sub-menu").stop().slideToggle();
 })

 $("#masthead .user-logged-in-menu").click(function() {
  $(this).children("ul#menu-account-menu").toggleClass("dropdowned");
 })

 $(".search-trigger").click(function() {
  $(this).siblings(".search-widget").toggleClass("active");
  $("body").toggleClass("search-open");
 });


 // Add padding top
 function topPadding() {
  var menu = $('#masthead'),
   set_header_height = $('#masthead').height();

  $('body').css('padding-top', set_header_height);
  $('.post-lists article img').each(function() {
    var theaelement = $(this).parent('a'),
    theHref = theaelement.attr('href'),
    theTitle = theaelement.attr('title'),
    theAlt = theaelement.attr('alt'),
    theImg = $(this),
    imgHeight = theImg.outerHeight(),
    imgWidth = theImg.outerWidth(),
    centerdTop = (imgHeight-400)/2;

    if(imgHeight > imgWidth ) {
      $(this).css('margin-top', '-'+centerdTop+'px');
      $(this).parents('.thumbnail').addClass('large');
      $(this).parents('.thumbnail').append('<a class="view-full-post" href="'+theHref+'" title="'+theTitle+'" alt="'+theAlt+'">View Full Post</a>')
    }
 })
 }

 $(window).bind('load', topPadding);
 $(window).bind('resize', topPadding);

 var mainMarginTop = $("#masthead").outerHeight(),
  winHeight = $(window).outerHeight(),
  theTopOff = $("#top-header").outerHeight();
 $(window).scroll(function() {
  if ($(this).scrollTop() > mainMarginTop) {
   $('#masthead').css("top", -theTopOff);
  } else {
   $('#masthead').css("top", "0px");
  }
 });

 $(window).scroll(function() {
  if ($(this).scrollTop() > winHeight) {
   $('#backtotop').addClass("visible");
  } else {
   $('#backtotop').removeClass("visible");
  }
 });

 var footerHeight = $("#colofon").outerHeight();

 $("#backtotop").css("bottom", footerHeight);
 $(window).scroll(function() {
  if ($(window).scrollTop() + $(window).height() > $(document).height() - footerHeight / 2) {
   $("#backtotop").addClass("bottom");
  } else {
   $("#backtotop").removeClass("bottom");
  }
 });

 $('p.form-submit input').addClass('button regular-btn');

 $(".menu-trigger").click(function() {
  $('body').addClass("menu-open").animate({
   right: 280
  });

  $("#sidebar").animate({
   right: 0
  });

  $("#masthead").addClass("menu-open");

  $(".close-menu").fadeIn();
  $(this).find("i").animate({
   opacity: 0
  })
 });

 $(".input-wrapper select").before('<div class="dropdown-select"><i class="fa fa-angle-down"></i></div>');

 $(".close-menu").click(function() {
  $('body').removeClass("menu-open").animate({
   right: 0
  });

  $("#sidebar").animate({
   right: -300
  });

  $("#masthead").removeClass("menu-open");

  $(this).fadeOut();
  $(".menu-trigger i").animate({
   opacity: 1
  })
 });

 $('body.page-template-template-full-width .gags-loaded, body.page-template-template-blog .gags-loaded').remove();

 $("#backtotop").click(function(e) {
  $("html, body").animate({
   scrollTop: 0
  }, 600);

  e.preventDefault()
 });

 var jRes = jRespond([{
  label: 'small',
  enter: 0,
  exit: 1024
 }, {
  label: 'large',
  enter: 860,
  exit: 1024
 }]);

 jRes.addFunc({
  breakpoint: 'small',
  enter: function() {
   if (!$('#sidebar').length) {
    $("#main .container").append('<div id="sidebar"></div>')
   }

   $("#sidebar").prepend('<div id="mobile-menu" class="site-navigation"></div>').addClass("mobile-menu");
   $("#menu-main-menu").clone().prependTo("#mobile-menu");
   $(".visitor-menu").clone().prependTo("#sidebar").addClass("clearfix");
   $("#mobile-menu ul#menu-main-menu li.menu-item-has-children").append('<div class="mobile-child-menu"><i class="fa fa-chevron-down"></i></div>');
   $(".mobile-child-menu").click(function() {
    $(".sub-menu").removeClass("dropped-down");
    $(this).parent().find(".sub-menu").slideToggle();
   });

  },
  exit: function() {
   $("#mobile-menu, #sidebar .visitor-menu, .small-container #sidebar").remove();
   $('body').removeClass("menu-open").animate({
    right: 0
   });

   $("#sidebar").animate({
    right: -300
   });

   $("#masthead").removeClass("menu-open");
   $(".close-menu").fadeOut();
   $(".menu-trigger i").animate({
    opacity: 1
   });
  }
 });

 // FluidVids
 (function(window, document, undefined) {

  var iframes = document.getElementsByTagName('iframe');
  for (var i = 0; i < iframes.length; i++) {
   var iframe = iframes[i],
    players = /www.youtube.com|player.vimeo.com/;

   if (iframe.src.search(players) > 0) {
    var videoRatio = (iframe.height / iframe.width) * 100;

    iframe.style.position = 'absolute';
    iframe.style.top = '0';
    iframe.style.left = '0';
    iframe.width = '100%';
    iframe.height = '100%';

    var wrap = document.createElement('div');
    wrap.className = 'fluid-vids';
    wrap.style.width = '100%';
    wrap.style.position = 'relative';
    wrap.style.paddingTop = videoRatio + '%';

    var iframeParent = iframe.parentNode;
    iframeParent.insertBefore(wrap, iframe);
    wrap.appendChild(iframe);
   }
  }
 })(window, document);

})(jQuery);