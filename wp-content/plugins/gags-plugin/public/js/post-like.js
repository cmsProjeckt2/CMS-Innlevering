jQuery(document).ready(function() {
	jQuery('a.liked').on('click',function(event){
		event.preventDefault();
	});
	jQuery('body').on('click','.jm-post-like',function(event){
		event.preventDefault();
		heart = jQuery(this);
		post_id = heart.data("post_id");
		jQuery.ajax({
			type: "post",
			url: ajax_var.url,
			data: "action=jm-post-like&nonce="+ajax_var.nonce+"&jm_post_like=&post_id="+post_id,
			success: function(count){
				if( count.indexOf( "already" ) !== -1 )
				{
					var lecount = count.replace("already","");
					if (lecount === "0")
					{
						lecount = "0";
					}
					heart.removeClass("liked");
					heart.html("<i id='icon-like' class='fa fa-thumbs-up'></i><span class='like-count'>"+lecount+"</span><span class='like-text'> Likes</span>");
				}
				else
				{
					var alreadyVoted = heart.data("text");
					heart.prop('title', alreadyVoted);
					heart.addClass("liked");
					heart.removeClass("jm-post-like");
					jQuery('a.liked').on('click',function(event){
						event.preventDefault();
					});
					heart.html("<i id='icon-like' class='fa fa-thumbs-up'></i><span class='like-count'>"+count+"</span><span class='like-text'> Likes</span>");
				}
			}
		});
	});
});
