<style>
	.comments-area {
		width: 100%;
		min-height: 300px;
		margin-top: 30px;
	}
	.title-comment {
		display: inline-block;
		color: #444;
		font-size: 28px;
		border-bottom: 3px solid #f39c12;
		margin-bottom: 20px;
	}
	.list-comment {
		padding-left: 20px;
	}
	.list-comment p {
		margin: 15px;
	}
	
	.comentar-user {
		margin-top: 25px;
		font-size: 19px;
		color: #a7a7a7;
	}
	.comentar-user .name {
		color: #f39c12;
	}
	.comentar-user .date {
		
		font-size: 17px;
	}
 	.comentar-wrapper {
		
		width: 65%;
		
	}
	.write-comment {
		width: 68%;
		min-height: 180px;
		margin-left: 20px;
		
	}
	.write-comment textarea {
		width: 92%;
		margin-top: 10px;
		height: 100px;
	}
	.button-comment {
		width: 100px;
		
		margin-bottom: 10px;
	}
	@media screen and (max-width: 1000px) {
		.comentar-wrapper {
			width: 100%;
		}
		.write-comment {
			width: 100%;
			margin-left: 2px;
			margin-right: 2px;
		}
		.write-comment textarea {
			width: 100%;
			margin-top: 10px;
			height: 150px;
		}
	}
</style>

<div class = "comments-area">
	<div class = "title-comment">
		Коментарі
	</div>
	
	
	<div class = "list-comment">
	
	<?
		$listComment = $comment->getAllComment ();

		if ( !empty($listComment) ):
		foreach ( $listComment as $value ):
	?>
		<div class = "comentar">
			<div class = "comentar-user">
				<span class = "name">
					<?= $value['name'] ?>
				</span>
				|
				<span class = "date">
					 <?= date("Y/m/d H:i",$value['date']) ?>
				</span>
			</div>
			<div class = "comentar-wrapper">
				<p><?= $value['text'] ?></p>
			</div>
		</div>
	<?php
		endforeach;
		else: 
	?>
		<div class = "comment-mssg">
			Коментарів немає
		</div>
	<?
		endif; 
	?>
	</div>
	
	<?php
		if ( isset($_SESSION['user']) ): 
	?>
		<div class = "write-comment">
			<textarea class = "input-element"></textarea>
			<div class = "button button-comment">
				Відправити
			</div>
		</div>
	<?php
		else:
	?>
		Щоб коментувати <a href = "/user/index">увійдіть на сайт</a>
	<?php
		endif;
	?>

</div>

<script type='text/javascript'>
	$(document).ready( function () {

		function send_comment (postId, userId, textComment) {
			$.ajax({
				type: 'POST',
				data: ({postId: postId, userId: userId, text: textComment}),
				url: '\\news\\comment',
                dataType: 'html',
                success: function (data) {
                    $('.list-comment').append(data);
                    $('.write-comment > .input-element').val('');
                }
			});
		}

		$('.button,.button-comment').click(function () {
			var postId = '<?= $comment->postId ?>';
			var userId = '<?= $comment->userId ?>';
			var text = $('.write-comment > .input-element').val();
			send_comment(postId, userId, text);
			$('.comment-mssg').remove();
		});
	});
</script>
