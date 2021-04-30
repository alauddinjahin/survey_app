"use strict";
(function( $ ) {
	
	function scroll_to_class(element_class, removed_height) {
		var scroll_to = $(element_class).offset().top - removed_height;
		if($(window).scrollTop() != scroll_to) {
			$('.form-wizard').stop().animate({scrollTop: scroll_to}, 0);
		}
	}

	function bar_progress(progress_line_object, direction) {
		var number_of_steps = progress_line_object.data('number-of-steps');
		var now_value = progress_line_object.data('now-value');
		var new_value = 0;
		if(direction == 'right') {
			new_value = now_value + ( 100 / number_of_steps );
		}
		else if(direction == 'left') {
			new_value = now_value - ( 100 / number_of_steps );
		}
		progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
	}

	jQuery(document).ready(function() {
		
		/*
			Form
		*/
		$('.form-wizard fieldset:first').fadeIn('slow');
		
		$('.form-wizard .required').on('focus', function() {
			$(this).removeClass('input-error');
		});
		
		// next step
		$('.form-wizard .btn-next').on('click', function() {
			var parent_fieldset = $(this).parents('fieldset');
			var next_step = true;
			// navigation steps / progress steps
			var current_active_step = $(this).parents('.form-wizard').find('.form-wizard-step.active');
			var progress_line = $(this).parents('.form-wizard').find('.form-wizard-progress-line');
			
			// fields validation
			parent_fieldset.find('.required').each(function() {
				if( $(this).val() == "" ) {
					$(this).addClass('input-error');
					next_step = false;
					let errorMsg = '';
					if($(this).data('question')){
						errorMsg = '#errormsg';
						$(errorMsg).html(`Question No ${$(this).data('question')} is Required!`);
						$(errorMsg).removeClass('d-none');
					}else{
						errorMsg = '#errormsg1';
						$(errorMsg).html(`All Field is Required!`);
						$(errorMsg).removeClass('d-none');
					}

					setTimeout(function(){
						$(errorMsg).html('');
						$(errorMsg).addClass('d-none');
					},3000);

					return false;
				}
				else {
					$(this).removeClass('input-error');

					parent_fieldset.find('.checkboxArea-required input[type=checkbox][data-question]').each(function() {

						if($(this).is(':checked')){
							$(this).parent().find('input[type=checkbox]').removeClass('input-error');
							next_step = true;
							return false;
						}
		
						$(this).addClass('input-error');
						
						$('#errormsg').html(`Question No ${$(this).data('question')} is Required!`);
						$('#errormsg').removeClass('d-none');
						next_step = false;
		
						setTimeout(function(){
							$('#errormsg').html('');
							$('#errormsg').addClass('d-none');
						},3000);
					});
				}
			});


			
			// fields validation
			
			if( next_step ) {

				if($(this).hasClass('confirmSubmit')){

					$(document).on('click','#confirmSubmit',function(e){
						e.preventDefault();
		
						let form     = $('#myForm');
						let formData = form.serialize();
			
						$.ajax({
							url         : form.attr('action'),
							method      : 'POST',
							cache       : false,
							data        : formData,
							beforeSend  :function(){
								console.log('sending ....')
							},
							success     :function(res){
								leaveSuccessMessage(res?.msg);
							},
							error       :function(err){
								console.log(err)
								leaveErrorMessage(`${err?.responseJSON?.msg??'Something wents wrong!'}`);
								setTimeout(function(){
								    window.location.reload();
								},2000)
							}
						})
					});
				}

				parent_fieldset.fadeOut(400, function() {
					// change icons
					current_active_step.removeClass('active').addClass('activated').next().addClass('active');
					// progress bar
					bar_progress(progress_line, 'right');
					// show next step
					$(this).next().fadeIn();
					// scroll window to beginning of the form
					scroll_to_class( $('.form-wizard'), 20 );
				});
			}
			
		});
		
		// previous step
		$('.form-wizard .btn-previous').on('click', function() {
			// navigation steps / progress steps
			var current_active_step = $(this).parents('.form-wizard').find('.form-wizard-step.active');
			var progress_line = $(this).parents('.form-wizard').find('.form-wizard-progress-line');
			
			$(this).parents('fieldset').fadeOut(400, function() {
				// change icons
				current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
				// progress bar
				bar_progress(progress_line, 'left');
				// show previous step
				$(this).prev().fadeIn();
				// scroll window to beginning of the form
				scroll_to_class( $('.form-wizard'), 20 );
			});
		});
		
		// submit
		$('.form-wizard').on('submit', function(e) {
			// fields validation
			$(this).find('.required').each(function() {
				if( $(this).val() == "" ) {
					e.preventDefault();
					$(this).addClass('input-error');
				}
				else {
					$(this).removeClass('input-error');
				}
			});
			// fields validation
			
		});
		
		
	});
	


	// image uploader scripts 

	var $dropzone = $('.image_picker'),
		$droptarget = $('.drop_target'),
		$dropinput = $('#inputFile'),
		$dropimg = $('.image_preview'),
		$remover = $('[data-action="remove_current_image"]');

	$dropzone.on('dragover', function() {
	  $droptarget.addClass('dropping');
	  return false;
	});

	$dropzone.on('dragend dragleave', function() {
	  $droptarget.removeClass('dropping');
	  return false;
	});

	$dropzone.on('drop', function(e) {
	  $droptarget.removeClass('dropping');
	  $droptarget.addClass('dropped');
	  $remover.removeClass('disabled');
	  e.preventDefault();
	  
	  var file = e.originalEvent.dataTransfer.files[0],
		  reader = new FileReader();

	  reader.onload = function(event) {
		$dropimg.css('background-image', 'url(' + event.target.result + ')');
	  };
	  
	  console.log(file);
	  reader.readAsDataURL(file);

	  return false;
	});

	$dropinput.change(function(e) {
	  $droptarget.addClass('dropped');
	  $remover.removeClass('disabled');
	  $('.image_title input').val('');
	  
	  var file = $dropinput.get(0).files[0],
		  reader = new FileReader();
	  
	  reader.onload = function(event) {
		$dropimg.css('background-image', 'url(' + event.target.result + ')');
	  }
	  
	  reader.readAsDataURL(file);
	});

	$remover.on('click', function() {
	  $dropimg.css('background-image', '');
	  $droptarget.removeClass('dropped');
	  $remover.addClass('disabled');
	  $('.image_title input').val('');
	});

	$('.image_title input').blur(function() {
	  if ($(this).val() != '') {
		$droptarget.removeClass('dropped');
	  }
	});

	// image uploader scripts

}( jQuery ));