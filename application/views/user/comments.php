<?php
?>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="col-lg-6 offset-lg-3" style="margin-top:60px;">
            <div class="card">
                <div class="card-body">
                    <form id="frm_application" name="frm_application" action="<?= $base_url.'user/comment/uc' ?>" method="POST">
                        <h4 class="card-title"><small>Write down your comment on this application:</small></h4>
                        <div class="form-group">
                            <textarea rows="3" class="form-control" name="comment" id="comment" required></textarea>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-block btn-primary" type="submit" id="btn_comment" value="Submit your comment"/>
                        </div>
                        <hr>
                    </form>

                    <h4 class="card-title"><small>All Comments For this Application:</small></h4>
                    <div class="profiletimeline" id="cnt_comments">
                    </div>
                    <div style="display: none">
                        <div id="cnt_comment">
                            <div class="sl-item">
                                <div class="sl-left"> <img src="" alt="user" class="img-circle commenter_photo"> </div>
                                <div class="sl-right">
                                    <div><a href="javascript:void(0)" class="link commenter"></a> <span class="sl-date comment_on"></span>
                                        <blockquote class="m-t-10 comment">
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div> 
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
		$(document).ready(function() {
			show_comments(<?php echo json_encode($comments) ?>);
		});

		function show_comments(comments) {
			$('#cnt_comments').html('');
			if(comments.length == 0) {
				$('#cnt_comments').html('<small>No comments available.</small>');
			} else {
				for(var i = 0 ; i < comments.length ; i ++) {
					var comment = comments[i];
					var $cnt_comment = $('#cnt_comment').clone();
					$cnt_comment.attr('id' , 'comment_' + comment.commentId);
					$cnt_comment.appendTo($('#cnt_comments'));

					$('.commenter' , $cnt_comment).html(comment.commenter.name);
					$('.commenter_photo' , $cnt_comment).attr('src' , comment.commenter.photo_id ? get_render_url(comment.commenter.photo_id) : g.base_url + 'assets/panel/assets/images/users/nophoto.png');
					$('.comment' , $cnt_comment).html(comment.comment_html);
					$('.comment_on' , $cnt_comment).html(timeAgo(comment.created_on) + ' ago');
				}
			}
		}
</script>