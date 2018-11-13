(function( $ ) {
  'use strict';
  // Tags input
  var placeholder_tags = _gagsplaceholder.placeholder_tags;
  $('#gag-tag-image, #gag-tag-video').tagsInput({
     'defaultText':placeholder_tags
  });

  $("#gag_image_post_category, #gag_video_post_category").prop("required", true);

  $( window ).load(function() {
    $('.gifplayer img').gifplayer();
  });

  // show loader after submit gags image
  $('form#submit-image-gags').submit(function(){
    $('form#submit-image-gags .button ').hide();
    $('form#submit-image-gags .loading').show();
  });

  // show loader after submit gags video
  $('form#submit-video-gags').submit(function(){
    $('form#submit-video-gags .button ').hide();
    $('form#submit-video-gags .loading').show();
  });
})( jQuery );