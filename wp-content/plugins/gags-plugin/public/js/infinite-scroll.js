(function( $ ) {
	'use strict';
		var currentPage = 1;
    	$('body.home #maincontent,body:not(.author,.page-template-template-full-width-php) #maincontent,body.tax-gag_category #maincontent,body.tax-gag_tag #maincontent').jscroll({
	    loadingHtml: '<div class="loader-post"><img src="' + _gagsplaceholder.path_plugin + 'images/loader.gif" alt="Loading" /> Loading...</div>',
	    padding: 20,
	    nextSelector: 'a.nextpostslink',
	    contentSelector: 'article.gag, .pagination',
	    callback: function() {
		      currentPage++;
		      var loadd = window.location.href;
		      var salt = '';
		      var findNumber = parseInt(loadd.substring(loadd.lastIndexOf("page/")+5, loadd.lastIndexOf("/")));
			  var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

			  if(hashes[0].indexOf(window.location.href) || hashes.length > 1) {
			  	salt = '?'+hashes;
			  } 

		      						history.pushState('', '',
	      						(loadd.indexOf('page/2/') > -1 ? salt != '' ? 
	       					loadd.indexOf('page/' + (currentPage - 1) + '/' + salt ) > -1 ? 
	       				loadd.replace('page/' + findNumber + '/'  + salt , 'page/' + (findNumber + 1 ) + '/' + salt) :
	       			loadd.replace('page/' + findNumber + '/'  + salt , 'page/' + currentPage + '/' + salt):
	       		loadd.replace('page/' + findNumber + '/'  + salt , 'page/' + currentPage + '/' + salt) : 
	       		loadd.indexOf('page/' + (currentPage - 1) + '/') > -1 ? 
	       			loadd.replace('page/' +  findNumber + '/' + salt, 'page/' + (findNumber + 1) + '/' + salt) : 
	       				loadd.indexOf('page/' + (currentPage - 1) + '/') != loadd.indexOf('page/' + findNumber + '/') ? 
	       					loadd.indexOf('page/' + (findNumber - 1) + '/') > -1 ? 
	       						loadd.replace('page/' +  findNumber + '/', 'page/' + currentPage + '/' + salt) : 
	       							loadd.indexOf('page/' + findNumber  + '/') == loadd.indexOf('page/' + currentPage  + '/') ? 
	       								loadd.replace('page/' +  findNumber + '/', 'page/' + currentPage + '/' + salt) : 
	       							loadd.replace('page/' +  findNumber + '/' + salt, 'page/' + (findNumber + 1) + '/' + salt) : 
	       						loadd.indexOf('page/' + (findNumber + 1 ) + '/') > -1 ?
	       					loadd.replace('page/' +  findNumber + '/', 'page/' + currentPage + '/' + salt) : 
	       				salt != '' && loadd.indexOf('page/2/') > -1  ? 
	       			loadd.replace('page/' + findNumber + '/'  + salt , 'page/' + currentPage + '/' + salt) : 
	       		'page/2/' + salt
		    ));

		if(!$('body.page-template-template-full-width-php #maincontent,body.author #maincontent .nextpostslink,body.single,body.page-template-page-blog,body.page-template-page-full-width').length > 0 ){
			if(!$('body.home #maincontent .nextpostslink,body:not(.author,.page-template-template-full-width-php) #maincontent .nextpostslink,body.error404,body.author,body.single,body.page-template-page-blog,body.tax-gag_category #maincontent .nextpostslink,body.tax-gag_tag #maincontent .nextpostslink').length > 0 ){
				$( "#maincontent div.gags-loaded" ).remove();
				$( "#maincontent" ).append('<div class="gags-loaded"><span>All Gags Have Been Loaded</span></div>');
		    }
		    $( ".pagination" ).remove();
		}

		}});

		if(!$('body.page-template-template-full-width-php #maincontent,body.author #maincontent .nextpostslink,body.single,body.page-template-page-blog,body.page-template-page-full-width').length > 0 ){
			if(!$('body.home #maincontent .nextpostslink,body:not(.author,.page-template-template-full-width-php) #maincontent .nextpostslink,body.error404,body.author,body.single,body.page-template-page-blog,body.tax-gag_category #maincontent .nextpostslink,body.tax-gag_tag #maincontent .nextpostslink').length > 0 ){
				$( "#maincontent div.gags-loaded" ).remove();
				$( "#maincontent" ).append('<div class="gags-loaded"><span>All Gags Have Been Loaded</span></div>');
		    }
		    $( ".pagination" ).remove();
		}
})(jQuery);