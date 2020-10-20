jQuery(function($){
 
	// load more button click event
	$('.load-more-comments').click( function(){
		var button = $(this);
 		$('.tct-comment-form').show();
		$.ajax({
			url : tctobj.ajax_url, // AJAX handler, declared before
			data : {
				'action': 'commentsloadmore', // wp_ajax_cloadmore
				'post_id': tctobj.post_id, // the current post
				'cpage' : cpage,
			},
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...'); // preloader here
			},
			success : function( data ){
				if( data ) {

					$('.comment-list').append( data );
					button.text('More comments');

					 // if the last page, remove the button
					if ( cpage == 1 ){
						button.remove();
					}
					cpage--;
				} else {
					button.remove();
				}
			}
		});
		
		return false;
	});

	$(document).on('click','span.comment-quote a',function(event){
		//Find the content
		event.preventDefault();
		var comment_content = $(this).closest('.cmts-cntn').find('p').html();
		$('textarea#comment').html('<blockquote>'+comment_content+'</blockquote>');
		$('textarea#comment').focus();
		
	});
	$(document).on('click','span.comment-reply a',function(event){
		event.preventDefault();
		//$('textarea#comment').val('');
		$('textarea#comment').focus();
	});
 	
});