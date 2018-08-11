<?php $user = $this->user_session->get_user(); ?>
<div class="row green">
	<div class="col-sm-12">
		<h3 class="text-center">Hello <?php echo $user['name']; ?> this is your quizz road map</h3>

		<?php 
			$questions = 
			[
				'Are you Saudi?',
				'Do you have less than 4 years of working experience?',
				'Are you between the ages of 22 to 28 years old?',
				'Do you carry a university degree (Bachelor or Master)? Or about to graduate (less than a semester left)?'
			];
		?>
		
		<div class="block-center-outer">
			<div class="block-center">
				<ul class="list-inline list-unstyled">
					<?php for($i = 0 ; $i < count($questions) ; $i ++) { ?>
					<li><a href="#" class="btn btn-circle whitecolor slide_to slide_to_<?php echo $i; ?>" data-slide="<?php echo $i; ?>">Q<?php echo $i + 1; ?></a></li>
					<?php } ?>
				</ul>		
			</div>
		</div>

		<div class="m-b-40"></div>

		<div class="owl-carousel">
			<?php for($i = 0 ; $i < count($questions) ; $i ++) { $question = $questions[$i]; ?>
			<div class="item">
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-12">
						
						<form id="frm_quiz_<?php echo $i ?>" name="frm_quiz_<?php echo $i ?>">
							<h4 class="text-center">Q<?php echo $i + 1; ?> : <?php echo $question; ?></h4>
							
							<div class="block-center-outer">
								<div class="block-center">
									<div class="message" id="message_<?php echo $i + 1; ?>"></div>
									<div class="radio">
										<label>
											<input type="radio" value="Y" class="answer answer_yes" name="answer_<?php echo $i + 1; ?>"> Yes
										</label>
									</div>

									<div class="radio">
										<label>
											<input type="radio" value="N" class="answer answer_no" name="answer_<?php echo $i + 1; ?>"> No
										</label>
									</div>

									<div class="form-group">
										<input type="button" class="btn btn-pink next <?php echo $i == count($questions) - 1 ? 'last' : '' ?>" value="<?php echo $i == count($questions) - 1 ? 'Submit' : 'Next' ?>">
									</div>
								</div>	
							</div>		
							
						</form>

					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	var owl;		
	$(document).ready(function() {
		owl = $('.owl-carousel').owlCarousel(
		{
			autoplay: false,
		    loop:false,
		    dots:false,
		    margin:10,
		    nav:false,
		    items : 1,
		});

		$('.slide_to').click(function(event) 
		{
			return false;
		});

		$('.next').click(function(event) 
		{
			var $item = $(this).closest('.item');

			var value = $('.answer:checked' , $item).val();	
			console.log(value);

			if(!value)
			{
				var $message = $item.find('.message');
				show_error_message($message.attr('id') , 'Please select atleast one answer');
				return false;
			}

			if($(this).hasClass('last'))
			{
				navigate('user/success');	
				return false;
			}

			if(value == 'Y')
			{
				owl.trigger('next.owl.carousel');	
			}
			else 
			{
				navigate('user/failed');
			}

			
			return false;
		});

		$('.slide_to').removeClass('btn-pink').addClass('btn-white');
		$('.slide_to_0').removeClass('btn-white').addClass('btn-pink');

		owl.on('changed.owl.carousel', function(event) 
		{
    		var index = event.item.index;
    		$('.slide_to').removeClass('btn-pink').addClass('btn-white');
			$('.slide_to_' + index).removeClass('btn-white').addClass('btn-pink');
		});
	});	

</script>