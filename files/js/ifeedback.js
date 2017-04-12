var max_idle;
var idle_timeout;
var r_value;
var activeRatingSumSpan;
var activeRatingSumBottomSpans;
var activeRatingSumBottomSpanWraps;

// new custom rating strings for individual topics
var customRatingDefaultLabel		=	ratingDefaultLabel;
var customRating1Label			=	rating1Label;
var customRating2Label			=	rating2Label;
var customRating3Label			=	rating3Label;
var customRating4Label			=	rating4Label;
var customRating5Label			=	rating5Label;
var customNoRatingValueError		= 	noRatingValueError;

function setTopicId(topic_id, topic_name, topic_description) {
	$("#tx_ifeedback_ratingform_topic_id").val(topic_id);
	$("#ratingFormHeader").html(topic_name);
	$("#ratingform_topic_description").html(topic_description);
	return true;
}

function setTopicIdo(topic_id, topic_name, topic_description, topic_options) {
	$("#tx_ifeedback_optionform_topic_id").val(topic_id);
	$("#optionFormHeader").html(topic_name);
	$("#optionform_topic_description").html(topic_description);
	var options_html = "";
	for (option in topic_options) {
		if (topic_options[option]['flag'] == 1) {
			options_html += '<div class="radio-wrapper">'+
							'<legend>'+topic_options[option]['option']+'</legend>'+
							'<input class="checkboxxy" id="score['+topic_id+']'+topic_options[option]['id']+'y" type="radio" name="score['+topic_id+']['+topic_options[option]['id']+']" value="1">'+
							'<label for="score['+topic_id+']'+topic_options[option]['id']+'y">Yes</label>'+
							'<input class="checkboxxy" id="score['+topic_id+']'+topic_options[option]['id']+'n" type="radio" name="score['+topic_id+']['+topic_options[option]['id']+']" value="0">'+
							'<label for="score['+topic_id+']'+topic_options[option]['id']+'n">No</label>'+
							'</div>';
		} else {
			options_html += '<input class="checkboxxy" id="score['+topic_id+']'+topic_options[option]['id']+'" type="checkbox" name="score['+topic_id+']['+topic_options[option]['id']+']">'+
							'<label for="score['+topic_id+']'+topic_options[option]['id']+'">'+topic_options[option]['option']+'</label>';
		}
	}
	$("#optionform_topic_options").html(options_html);
	return true;
}

function geolocFail() {
	window.setTimeout(self.location.href = pagelink+'&plat=-1&plon=-1');
}

function idleTimeout() {
	//$(document).unbind('mousedown mousemove mouseup touchstart touchmove touchend keydown keypress keyup');
	clearTimeout(idle_timeout);
	$('#hi_idlesubmit').val('yes');
	
	///// DYNAMIC FORM FIELDS /////
	// set required fields
	/*var req_fields = $('.input-required');
	$.each(req_fields, function() {
		$(this).val('n/a');
	});*/
	var req_fields = $('.input-required');
	$.each(req_fields, function() {
		if('' == $.trim($(this).val())) {
			$(this).val('n/a');
		}
	});
	var ask_once_fields = $('.input-ask_once');
	$.each(ask_once_fields, function() {
		if('' == $.trim($(this).val())) {
			$(this).val('n/a');
		}
	});
	var is_condreqs = $('.iscondreq');
	$.each(is_condreqs, function() {
		$(this).removeClass('iscondreq');
	});
	var cfr_askonces = $('.cfr-backing-ask_once');
	$.each(cfr_askonces, function() {
		$(this).removeClass('cfr-backing-ask_once');
	});
	var cfr_reqs = $('.cfr-backing-req');
	$.each(cfr_reqs, function() {
		$(this).removeClass('cfr-backing-req');
	});
	var cfr_commentreqs = $('.cfr-comment-req');
	$.each(cfr_commentreqs, function() {
		$(this).removeClass('cfr-comment-req');
	});
	///////////////////////////////
	
	// set potentially required fields
	if($('#tx_ifeedback_contactform_nationality').length) {
		//$('#tx_ifeedback_contactform_nationality').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_nationality').val())) $('#tx_ifeedback_contactform_nationality').val('n/a');
	}
	
	if($('#tx_ifeedback_contactform_roomno').length) {
		//$('#tx_ifeedback_contactform_roomno').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_roomno').val())) $('#tx_ifeedback_contactform_roomno').val('n/a');
	}
	
	if($('#tx_ifeedback_contactform_mail').length) {
		//$('#tx_ifeedback_contactform_mail').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_mail').val())) $('#tx_ifeedback_contactform_mail').val('n/a');
	}
	
	if($('#checkout_roomno').length) {
		//$('#tx_ifeedback_contactform_roomno').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_roomno').val())) $('#tx_ifeedback_contactform_roomno').val('n/a');
	}
	if($('#checkout_confroomno').length) {
		//$('#tx_ifeedback_contactform_confroomno').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_confroomno').val())) $('#tx_ifeedback_contactform_confroomno').val('n/a');
	}
	if($('#checkout_tableno').length) {
		//$('#tx_ifeedback_contactform_tableno').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_nationality').val())) $('#tx_ifeedback_contactform_nationality').val('n/a');
	}
	if($('#checkout_age').length) {
		//$('#tx_ifeedback_contactform_age').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_age').val())) $('#tx_ifeedback_contactform_age').val('n/a');
	}
	if($('#checkout_waiter').length) {
		//$('#tx_ifeedback_contactform_waiter').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_waiter').val())) $('#tx_ifeedback_contactform_waiter').val('n/a');
	}
	if($('#checkout_address').length) {
		//$('#tx_ifeedback_contactform_address').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_address').val())) $('#tx_ifeedback_contactform_address').val('n/a');
	}
	if($('#checkout_advice').length) {
		//$('#tx_ifeedback_contactform_advice').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_advice').val())) $('#tx_ifeedback_contactform_advice').val('n/a');
	}
	if($('#checkout_visit').length) {
		//$('#tx_ifeedback_contactform_visit').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_visit').val())) $('#tx_ifeedback_contactform_visit').val('n/a');
	}
	if($('#checkout_gender').length) {
		//$('#tx_ifeedback_contactform_gender').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_gender').val())) $('#tx_ifeedback_contactform_gender').val('n/a');
	}
	if($('#checkout_location').length) {
		//$('#tx_ifeedback_contactform_location').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_location').val())) $('#tx_ifeedback_contactform_location').val('n/a');
	}
	if($('#checkout_reciept').length) {
		//$('#tx_ifeedback_contactform_reciept').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_reciept').val())) $('#tx_ifeedback_contactform_reciept').val('n/a');
	}
	if($('#checkout_staff').length) {
		//$('#tx_ifeedback_contactform_staff').val('n/a');
		if('' == $.trim($('#tx_ifeedback_contactform_staff').val())) $('#tx_ifeedback_contactform_staff').val('n/a');
	}
	
	// remove potentially set checkboxes
	/*if($('#tx_ifeedback_contactform_checkbox_callback').length) {
		$('#tx_ifeedback_contactform_checkbox_callback').attr('checked', false)
	}
	if($('#tx_ifeedback_contactform_checkbox_newsletter').length) {
		$('#tx_ifeedback_contactform_checkbox_newsletter').attr('checked', false)
	}
	if($('#tx_ifeedback_contactform_checkbox_lottery').length) {
		$('#tx_ifeedback_contactform_checkbox_lottery').attr('checked', false)
	}*/
	
	//$('#tx_ifeedback_contactform_submit_button').click();
	$('#tx_ifeedback_contactform').submit();
	//window.setTimeout(self.location.href = $('#entryname').val());
	window.setTimeout('idleRedirect()', 10000);
}

function idleRedirect() {
	window.setTimeout(self.location.href = $('#entryname').val());
}

function validateEmail(string) {
	if ($('#hi_idlesubmit').val() == 'yes') return true;
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(string);
}

function validatePositiveInteger(string) {
	if ($('#hi_idlesubmit').val() == 'yes') return true;
	if('0' == string) return true;
	var re = /^(?!^0)\d{1,9}$/;
	return re.test(string);
}

function validatePhoneNumber(string) {
	if ($('#hi_idlesubmit').val() == 'yes') return true;
	var stripped = string.replace(/[\(\)\.\-\ ]/g, '');
	if(isNaN(parseInt(stripped)))
		return false;
	else
		return true;
}

$(document).ready(
		function() {
			
			$('.dfield-error').hide();
			
			/*if(navigator.cookieEnabled) {
				//
			} else {
				alert('Diese Seite benutzt Cookies. Bitte aktivieren Sie Cookies in Ihren Browsereinstellungen.');
			}*/
			
			// start idle timer
			max_idle = 240000;
			//max_idle = 10000;
			
			if ('no' == $('#showsendbutton').val()) {
				$('.send_feedback_button').hide();
			}
			
			if('no' == $('#use_transitions').val()) {
				$.mobile.defaultPageTransition = 'none';
				$.mobile.defaultDialogTransition = 'none';
			} else if('slide' == $('#use_transitions').val()) {
				$.mobile.defaultPageTransition = 'slide';
			}
			
			$('.rating_value_span').hide();
			$('.rating_comment_span').hide();
			
			if($('#rateit6').length) {
				// set default label only when star rating is available
				$('#value6').text(customRatingDefaultLabel);
				r_value = customRatingDefaultLabel;
			}
			
			activeRatingSumSpan = null;
			activeRatingSumBottomSpans = null;
			activeRatingSumBottomSpanWraps = null;
			
			if($('#ip_splash').length) {
				$('#ip_splash').fadeIn(1250).delay(3000).fadeOut(100, function() {
					window.setTimeout(self.location.href = '#ip_start'); // workaround, since jQuery Mobile 1.1.0rc1 changepage didnt work properly in Webkit Browsers anymore
				});
			}
			
			if($('#ip_splash2').length) {
				if(true) {
					$('#ip_splash2').fadeIn(1250).delay(3000).fadeOut(100, function() {
						window.setTimeout(self.location.href = $('#if_startpage_temp').val()); // workaround, since jQuery Mobile 1.1.0rc1 changepage didnt work properly in Webkit Browsers anymore
					});
				} 
			}
			
			// geolocation test
			if($('#ip_pagelink').length) {
				pagelink = $('#ip_pagelink').val();
				if(navigator.geolocation) {
					
					var location_timeout = setTimeout("geolocFail()", 8000);
					
					navigator.geolocation.getCurrentPosition(function(position) {
						clearTimeout(location_timeout);
						var lat = position.coords.latitude;
						var lon = position.coords.longitude;
						window.setTimeout(self.location.href = pagelink+'&plat='+lat+'&plon='+lon);
					}, function(err) {
						clearTimeout(location_timeout);
						geolocFail();
					});
				} else {
					geolocFail();
				}
			}
			
			//$(document).bind('mousedown mousemove mouseup touchstart touchmove touchend keydown keypress keyup', function(event) {
			$(document).bind('touchstart touchmove touchend', function(event) {
				clearTimeout(idle_timeout);
				if('yes' == $('#use_idle_timeout').val()) {
					idle_timeout = setTimeout("idleTimeout()", max_idle);
				}
			});
			$('#triggerFile').click(function(e){
		        e.preventDefault();
		        $("#imageFileUpload").trigger('click');
		    });
			
     		$('#imageFileUpload').change(function(){

	    		$('.uploadStatus').each(function(i, obj){
     				$(this).css('display','none');
     			});
	    		     			
	    		//$('.uploadStatus').html('Upload läuft ...').css('color', 'black');
				var formData = $('#tx_ifeedback_contactform').serialize();
				
		        var validExtensions = ['png','jpg','gif', 'PNG']; //array of valid extensions
		        var originalFileName;
		        var fileSize;
		        var fileNameExt;
	     		var data = new FormData();
	     		
				$.each($('#imageFileUpload')[0].files, function(i, file) {
					data.append('file-'+i, file);
					originalFileName = file.name;
					fileSize = file.size;
				});
				
			    fileNameExt = originalFileName.substr(originalFileName.lastIndexOf('.') + 1);
			    
			    // check if the file ending and the size is ok
			    	if ($.inArray(fileNameExt, validExtensions) == -1){
			    		//alert("Ungültiger Dateityp");
			    		//$("#yourElem").uploadifyCancel(q);
			    		//$('.uploadStatus').html('Ungültiges Dateiformat.').css('color', 'red');

			    		$('.uploadStatus').each(function(i, obj){
		     				$(this).css('display','none');
		     			});
		     			$('.uploadStatus.noImage').css('display','block');
		     			
	     		        $('.fileUploadState').attr('value', '');
			    		return false;
			        }
			    	if(fileSize > (5* 1024 * 1024)){
			    		//alert("Datei darf nicht größer sein als 1MB");
			    		//$('.uploadStatus').html('Datei zu groß (mehr als 1MB)').css('color', 'red');
			    		$('.uploadStatus').each(function(i, obj){
		     				$(this).css('display','none');
		     			});
		     			$('.uploadStatus.tooBig').css('display','block');
		     			
	     		        $('.fileUploadState').attr('value', '');
			    		return false;
			    	}
			        
				var fileName = $('#imageFileUpload').attr('fileName') + '.' + fileNameExt;
					
				data.append('fileName', fileName);
					
				data.append('custFolder', $('#custFolder').attr('value'));
     		  
				data.append('imageUploadSubmitButtonClicked', 'yes');

				
     			$('.uploadStatus.willBeUploaded').css('display','block');
     			
     		 $.ajax({
				url: $('#tx_ifeedback_contactform').attr('action'),
				//url: '/typo3conf/ext/ifeedback/imageupload.php',
     		    data: data,
     		    cache: false,
     		    contentType: false,
     		    processData: false,
     		    type: 'POST',
     		    success: function(data){
     		        //alert("Erfolgreich hochgeladen");
     		    	var uploadStatus = $('.uploadStatus');
		    		//uploadStatus.html('Erfolgreich hochgeladen.').css('color', 'blue');
    	    		$('.uploadStatus').each(function(i, obj){
         				$(this).css('display','none');
         			});
         			$('.uploadStatus.successfullyUploaded').css('display','block');
     		        $('.fileUploadState').attr('value', fileName);
     		    }
     		});
     		    /*
     		    $.ajax({
     		        //url: '/typo3conf/ext/ifeedback/imageupload.php',  //Server script to process data
     		        url: $('#tx_ifeedback_contactform').attr('action'),
     		    	type: 'POST',
     		        xhr: function() {  // Custom XMLHttpRequest
     		            var myXhr = $.ajaxSettings.xhr();
     		            if(myXhr.upload){ // Check if upload property exists
     		                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
     		            }
     		            return myXhr;
     		        },
     		        //Ajax events
     		        beforeSend: beforeSendHandler,
     		        success: completeHandler,
     		        error: errorHandler,
     		        // Form data
     		        data: $('#tx_ifeedback_contactform').serialize(),
     		        //Options to tell jQuery not to process data or worry about content-type.
     		        cache: false,
     		        contentType: false,
     		        processData: false
     		    });*/
     		});
     		function progressHandlingFunction(e){
     		    if(e.lengthComputable){
     		        $('progress').attr({value:e.loaded,max:e.total});
     		    }
     		}
     		function completeHandler(e){alert('Data Uploaded: ');}
     		function beforeSendHandler(e){}
     		function errorHandler(e){alert('Data Error: ');}
     		
			 $('#tx_ifeedback_contactform').submit(function(event) {
				event.preventDefault();
				
				//$('.loadingAnimation').toggle();
				
				///// DYNAMIC FIELDS LOGIC /////
				
				// NEW: COMBINED CHECKBOXES
				var ccbsCheckSuccess = true;
				var ccbWrappers = $('.ifbck-ccb-wrapper');
				$.each(ccbWrappers, function() {
					var min = parseInt($(this).attr('min-req'));
					var max = parseInt($(this).attr('max-req'));
					var checkedBoxes = $(this).find('input:checked').length;

					//alert('Found CCB elemt, min = '+min+', max = '+max+', currently selected: '+checkedBoxes);
					$(this).find('.dfield-error').first().hide();
					if (checkedBoxes < min || checkedBoxes > max) {
						$(this).find('.dfield-error').first().show();
						ccbsCheckSuccess = false;
					}
				});
				
				if (!ccbsCheckSuccess){

					//$('.loadingAnimation').toggle();
					return false;
				}
				
				// remove requirements from fields potientially marked in previous attempts
				// to submit the form (otherwise these fields will be required forever, regardless
				// of whether or not the causing field is still checked/selected or not
				var markedfields = $('.creqmarked');
				$.each(markedfields, function() {
					$(this).removeClass('select-required input-required cbox-required required_input');
					$(this).next('.dfield-error').hide();
				});
				
				var condreqs = $('.iscondreq');
				$.each(condreqs, function() {
					
					var causeType = 'select';
					if ('text' == $(this).attr('type')) {
						causeType = 'text';
					}
					if ('checkbox' == $(this).attr('type')) {
						causeType = 'checkbox';
					}
					
					var doCondReq = false;
					
					if ('text' == causeType) {
						if ('' != $.trim($(this).val())) doCondReq = true;
					}
					if ('checkbox' == causeType) {
						if ($(this).is(':checked')) doCondReq = true;
					}
					if ('select' == causeType) {
						if ('0' != $(this).val()) doCondReq = true;
					}
					
					if (doCondReq) {
						var condreqStr = $(this).attr('condreqs');
						var uids = condreqStr.split(',');
						$.each(uids, function(index, value) {
							var idStr = 'dfield'+value;
							var theType = $('#'+idStr).attr('type');
							var newReqClass = 'select-required';
							if ('text' == theType) {
								newReqClass = 'input-required';
							}
							if ('checkbox' == theType) {
								newReqClass = 'cbox-required';
							}
							$('#'+idStr).addClass(newReqClass);
							$('#'+idStr).addClass('creqmarked');
						});
					} else {
						var condreqStr = $(this).attr('condreqs');
						var uids = condreqStr.split(',');
						$.each(uids, function(index, value) {
							var idStr = 'dfield'+value;
							var theType = $('#'+idStr).attr('type');
							var removeReqClass = 'select-required';
							if ('text' == theType) {
								removeReqClass = 'input-required';
							}
							if ('checkbox' == theType) {
								removeReqClass = 'cbox-required';
							}
							if (!($('#'+idStr).hasClass(removeReqClass))) { // only remove class if another field didn't set it already
								$('#'+idStr).removeClass(removeReqClass);
							}
						});
					}
				});
				
				// input text fields
				var dfield_required = false;
				var req_fields = $('.input-required');
				$.each(req_fields, function() {
					
					var errMsgId = '#'+$(this).attr('id')+'-error-required';
					$(this).removeClass('required_input');
					$(errMsgId).hide();
					
					if ('' == $.trim($(this).val())) {
						dfield_required = true;
						$(errMsgId).show();
						$(this).addClass('required_input');
					}
				});
				
				var req_selects = $('.select-required');
				$.each(req_selects, function() {
					var errMsgId = '#'+$(this).attr('id')+'-error-required';
					//$(this).removeClass('required_input');
					$(errMsgId).hide();
					
					if ('0' == $(this).val()) {
						dfield_required = true;
						$(errMsgId).show();
						//$(this).addClass('required_input');
					}
				});
				
				var req_cboxes = $('.cbox-required');
				$.each(req_cboxes, function() {
					var errMsgId = '#'+$(this).attr('id')+'-error-required';
					//$(this).removeClass('required_input');
					$(errMsgId).hide();
					
					if (!($(this).is(':checked'))) {
						dfield_required = true;
						$(errMsgId).show();
						//$(this).addClass('required_input');
					}
				});
				
				// new: star ratings in contact form
				var req_backings = $('.cfr-backing-req');
				$.each(req_backings, function() {
					if ($(this).val() == 0) {
						dfield_required = true;
						var textSpanId = $(this).attr('req-err-span');
						if ( !($('#'+textSpanId).length) ) {
							$(this).after('<span id="'+textSpanId+'" class="ratinglabel"></span><br />');
						}
						$('#'+textSpanId).text($(this).attr('req-err-msg'));
						$('#'+textSpanId).css('color', 'red');
					}
				});
				var req_comments = $('.cfr-comment-req');
				$.each(req_comments, function() {
					if ( $.trim($(this).val()) == '' ) {
						dfield_required = true;
						$('#'+$(this).attr('req-err-span')).text($(this).attr('req-err-msg'));
						$('#'+$(this).attr('req-err-span')).css('color', 'red');
					}
				});
				
				
				if (dfield_required){

					//$('.loadingAnimation').toggle();
					return false;
				}
				
				var dfield_ask_once = false;
				var ask_fields = $('.input-ask_once');
				$.each(ask_fields, function() {
					if ('' == $.trim($(this).val())) {
						dfield_ask_once = true;
						alert($(this).attr('askonce'));
						$(this).removeClass('input-ask_once');
					}
				});
				
				var ask_selects = $('.select-ask_once');
				$.each(ask_selects, function() {
					if ('0' == $(this).val()) {
						dfield_ask_once = true;
						alert($(this).attr('askonce'));
						$(this).removeClass('select-ask_once');
					}
				});
				
				var ask_cboxes = $('.cbox-ask_once');
				$.each(ask_cboxes, function() {
					if (!($(this).is(':checked'))) {
						dfield_ask_once = true;
						alert($(this).attr('askonce'));
						$(this).removeClass('cbox-ask_once');
					}
				});
				
				var ask_backings = $('.cfr-backing-ask_once');
				$.each(ask_backings, function() {
					if ( $(this).val() == 0 ) {
						dfield_ask_once = true;
						var textSpanId = $(this).attr('req-err-span');
						if ( !($('#'+textSpanId).length) ) {
							$(this).after('<span id="'+textSpanId+'" class="ratinglabel"></span><br />');
						}
						$('#'+textSpanId).text($(this).attr('ask-once-msg'));
						$('#'+textSpanId).css('color', 'red');
						$(this).removeClass('cfr-backing-ask_once');
					}
				});
				
				if (dfield_ask_once){

					//$('.loadingAnimation').toggle();
					return false;
				}
				
				
				var noValidEmail = false;
				var validateEmail_fields = $('.validate-email');
				$.each(validateEmail_fields, function() {
					var emailString = $(this).val();
					if (('' != $(this).val()) && (!validateEmail(emailString))) {
						//alert(emailString+': '+'No valid email!');
						alert(emailString+': '+$(this).attr('ve-email'));
						noValidEmail = true;
					}
				});
				if (noValidEmail){

					//$('.loadingAnimation').toggle();
					return false;
				}
				
				////////////////////////////////
				
				var f_required = false;
				
				$('#tx_ifeedback_contactform_nationality').removeClass('required_input');
				$('#tx_ifeedback_contactform_roomno').removeClass('required_input');
				$('#tx_ifeedback_contactform_mail').removeClass('required_input');
				
				$('#d_callback_req').hide();
				$('#d_newsletter_req').hide();
				$('#d_lottery_req').hide();
				
				if($('#coutpage_fields_required').length) {
					if('' == $.trim($('#tx_ifeedback_contactform_nationality').val()) || '' == $.trim($('#tx_ifeedback_contactform_roomno').val()) || '' == $.trim($('#tx_ifeedback_contactform_mail').val())) {
						alert($('#coutpage_fields_required').val());
						$('#d_nationality_req').show();
						$('#d_roomno_req').show();
						$('#d_mail_req').show();

						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// CHECKBOXES
				if($('#tx_ifeedback_contactform_checkbox_callback').attr('checked')) { // CALLBACK
					if( ('' == $('#tx_ifeedback_contactform_nationality').val() || '' == $('#tx_ifeedback_contactform_roomno').val() || !(validatePhoneNumber($('#tx_ifeedback_contactform_roomno').val())) ) ) {
						if(!(validateEmail($('#tx_ifeedback_contactform_mail').val()))) {
							//alert($('#requirement_attributes').attr('callbackreq'));
							//return false;
							f_required = true;
							$('#tx_ifeedback_contactform_nationality').addClass('required_input');
							$('#tx_ifeedback_contactform_roomno').addClass('required_input');
							$('#tx_ifeedback_contactform_mail').addClass('required_input');
							$('#d_nationality_req').show();
							$('#d_roomno_req').show();
							$('#d_mail_req').show();
							
							$('#d_callback_req').show();
						}
					}
				}
				
				if($('#tx_ifeedback_contactform_checkbox_lottery').attr('checked')) { // LOTTERY
					if( ('' == $('#tx_ifeedback_contactform_nationality').val() || '' == $('#tx_ifeedback_contactform_roomno').val() || !(validatePhoneNumber($('#tx_ifeedback_contactform_roomno').val())) ) ) {
						if(!(validateEmail($('#tx_ifeedback_contactform_mail').val()))) {
							//alert($('#requirement_attributes').attr('lotteryreq'));
							//return false;
							f_required = true;
							$('#tx_ifeedback_contactform_nationality').addClass('required_input');
							$('#tx_ifeedback_contactform_roomno').addClass('required_input');
							$('#tx_ifeedback_contactform_mail').addClass('required_input');
							$('#d_nationality_req').show();
							$('#d_roomno_req').show();
							$('#d_mail_req').show();
							
							$('#d_lottery_req').show();
						}
					}
				}
				
				if($('#tx_ifeedback_contactform_checkbox_newsletter').attr('checked')) { // NEWSLETTER
					
					if(!(validateEmail($('#tx_ifeedback_contactform_mail').val()))) {
						//alert($('#requirement_attributes').attr('newsletterreq'));
						//return false;
						f_required = true;
						$('#tx_ifeedback_contactform_mail').addClass('required_input');
						$('#d_mail_req').show();
						
						$('#d_newsletter_req').show();
					}
				}
				
				if($('#tx_ifeedback_contactform_checkbox_newsletter').attr('checked')) {
					
				}
				
				if($('#tx_ifeedback_contactform_checkbox_lottery').attr('checked')) {
					
				}
				
				
				// NATIONALITY
				if($('#checkout_nationality').length) {
					$('#tx_ifeedback_contactform_nationality').removeClass('required_input');
					$('#d_nationality_req').hide();
					
					if('required' == $('#checkout_nationality').val() && '' == $.trim($('#tx_ifeedback_contactform_nationality').val())) {
						//alert($('#cout_page_nationality_required').val());
						//return false;
						$('#tx_ifeedback_contactform_nationality').addClass('required_input');
						$('#d_nationality_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_nationality').val() && '' == $.trim($('#tx_ifeedback_contactform_nationality').val())) {
						alert($('#cout_page_nationality_required').val());
						$('#checkout_nationality').val('asked');
						$('#tx_ifeedback_contactform_nationality').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// ROOMNO
				if($('#checkout_roomno').length) {
					$('#tx_ifeedback_contactform_roomno').removeClass('required_input');
					$('#d_roomno_req').hide();
					
					if('required' == $('#checkout_roomno').val() && '' == $.trim($('#tx_ifeedback_contactform_roomno').val())) {
						//alert($('#cout_page_roomno_required').val());
						//return false;
						$('#tx_ifeedback_contactform_roomno').addClass('required_input');
						$('#d_roomno_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_roomno').val() && '' == $.trim($('#tx_ifeedback_contactform_roomno').val())) {
						alert($('#cout_page_roomno_required').val());
						$('#checkout_roomno').val('asked');
						$('#tx_ifeedback_contactform_roomno').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// MAIL
				if($('#checkout_mail').length) {
					$('#tx_ifeedback_contactform_mail').removeClass('required_input');
					$('#d_mail_req').hide();
					
					if('required' == $('#checkout_mail').val() && '' == $.trim($('#tx_ifeedback_contactform_mail').val())) {
						//alert($('#cout_page_mail_required').val());
						//return false;
						$('#tx_ifeedback_contactform_mail').addClass('required_input');
						$('#d_mail_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_mail').val() && '' == $.trim($('#tx_ifeedback_contactform_mail').val())) {
						alert($('#cout_page_mail_required').val());
						$('#checkout_mail').val('asked');
						$('#tx_ifeedback_contactform_mail').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// ROOMNO
				if($('#checkout_roomno').length) {
					$('#tx_ifeedback_contactform_roomno').removeClass('required_input');
					$('#d_roomno_req').hide();
					
					if('required' == $('#checkout_roomno').val() && '' == $.trim($('#tx_ifeedback_contactform_roomno').val())) {
						//alert($('#cout_page_roomno_required').val());
						//return false;
						$('#tx_ifeedback_contactform_roomno').addClass('required_input');
						$('#d_roomno_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_roomno').val() && '' == $.trim($('#tx_ifeedback_contactform_roomno').val())) {
						alert($('#cout_page_roomno_required').val());
						$('#checkout_roomno').val('asked');
						$('#tx_ifeedback_contactform_roomno').removeClass('required_input');

						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// CONF.ROOMNO
				if($('#checkout_confroomno').length) {
					$('#tx_ifeedback_contactform_confroomno').removeClass('required_input');
					$('#d_confroomno_req').hide();
					
					if('required' == $('#checkout_confroomno').val() && '' == $.trim($('#tx_ifeedback_contactform_confroomno').val())) {
						//alert($('#cout_page_confroomno_required').val());
						//return false;
						$('#tx_ifeedback_contactform_confroomno').addClass('required_input');
						$('#d_confroomno_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_confroomno').val() && '' == $.trim($('#tx_ifeedback_contactform_confroomno').val())) {
						alert($('#cout_page_confroomno_required').val());
						$('#checkout_confroomno').val('asked');
						$('#tx_ifeedback_contactform_confroomno').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// TABLENO
				if($('#checkout_tableno').length) {
					$('#tx_ifeedback_contactform_tableno').removeClass('required_input');
					$('#d_tableno_req').hide();
					
					if('required' == $('#checkout_tableno').val() && '' == $.trim($('#tx_ifeedback_contactform_tableno').val())) {
						//alert($('#cout_page_tableno_required').val());
						//return false;
						$('#tx_ifeedback_contactform_tableno').addClass('required_input');
						$('#d_tableno_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_tableno').val() && '' == $.trim($('#tx_ifeedback_contactform_tableno').val())) {
						alert($('#cout_page_tableno_required').val());
						$('#checkout_tableno').val('asked');
						$('#tx_ifeedback_contactform_tableno').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// AGE
				if($('#checkout_age').length) {
					$('#tx_ifeedback_contactform_age').removeClass('required_input');
					$('#d_age_req').hide();
					
					if('required' == $('#checkout_age').val() && ('' == $.trim($('#tx_ifeedback_contactform_age').val()) || !(validatePositiveInteger($('#tx_ifeedback_contactform_age').val())))) {
						//alert($('#cout_page_age_required').val());
						//return false;
						$('#tx_ifeedback_contactform_age').addClass('required_input');
						$('#d_age_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_age').val() && '' == $.trim($('#tx_ifeedback_contactform_age').val())) {
						alert($('#cout_page_age_required').val());
						$('#checkout_age').val('asked');
						$('#tx_ifeedback_contactform_age').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// WAITER
				if($('#checkout_waiter').length) {
					$('#tx_ifeedback_contactform_waiter').removeClass('required_input');
					$('#d_waiter_req').hide();
					
					if('required' == $('#checkout_waiter').val() && '' == $.trim($('#tx_ifeedback_contactform_waiter').val())) {
						//alert($('#cout_page_waiter_required').val());
						//return false;
						$('#tx_ifeedback_contactform_waiter').addClass('required_input');
						$('#d_waiter_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_waiter').val() && '' == $.trim($('#tx_ifeedback_contactform_waiter').val())) {
						alert($('#cout_page_waiter_required').val());
						$('#checkout_waiter').val('asked');
						$('#tx_ifeedback_contactform_waiter').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// ADDRESS
				if($('#checkout_address').length) {
					$('#tx_ifeedback_contactform_address').removeClass('required_input');
					$('#d_address_req').hide();
					
					if('required' == $('#checkout_address').val() && '' == $.trim($('#tx_ifeedback_contactform_address').val())) {
						//alert($('#cout_page_address_required').val());
						//return false;
						$('#tx_ifeedback_contactform_address').addClass('required_input');
						$('#d_address_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_address').val() && '' == $.trim($('#tx_ifeedback_contactform_address').val())) {
						alert($('#cout_page_address_required').val());
						$('#checkout_address').val('asked');
						$('#tx_ifeedback_contactform_address').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// ADVICE
				if($('#checkout_advice').length) {
					$('#tx_ifeedback_contactform_advice').removeClass('required_input');
					$('#d_advice_req').hide();
					
					if('required' == $('#checkout_advice').val() && '' == $.trim($('#tx_ifeedback_contactform_advice').val())) {
						//alert($('#cout_page_advice_required').val());
						//return false;
						$('#tx_ifeedback_contactform_advice').addClass('required_input');
						$('#d_advice_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_advice').val() && '' == $.trim($('#tx_ifeedback_contactform_advice').val())) {
						alert($('#cout_page_advice_required').val());
						$('#checkout_advice').val('asked');
						$('#tx_ifeedback_contactform_advice').removeClass('required_input');
			
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// VISIT
				if($('#checkout_visit').length) {
					$('#tx_ifeedback_contactform_visit').removeClass('required_input');
					$('#d_visit_req').hide();
					
					if('required' == $('#checkout_visit').val() && '' == $.trim($('#tx_ifeedback_contactform_visit').val())) {
						//alert($('#cout_page_visit_required').val());
						//return false;
						$('#tx_ifeedback_contactform_visit').addClass('required_input');
						$('#d_visit_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_visit').val() && '' == $.trim($('#tx_ifeedback_contactform_visit').val())) {
						alert($('#cout_page_visit_required').val());
						$('#checkout_visit').val('asked');
						$('#tx_ifeedback_contactform_visit').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// GENDER
				if($('#checkout_gender').length) {
					$('#tx_ifeedback_contactform_gender').removeClass('required_input');
					$('#d_gender_req').hide();
					
					if('required' == $('#checkout_gender').val() && '' == $.trim($('#tx_ifeedback_contactform_gender').val())) {
						//alert($('#cout_page_gender_required').val());
						//return false;
						$('#tx_ifeedback_contactform_gender').addClass('required_input');
						$('#d_gender_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_gender').val() && '' == $.trim($('#tx_ifeedback_contactform_gender').val())) {
						alert($('#cout_page_gender_required').val());
						$('#checkout_gender').val('asked');
						$('#tx_ifeedback_contactform_gender').removeClass('required_input');

						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// LOCATION
				if($('#checkout_location').length) {
					$('#tx_ifeedback_contactform_location').removeClass('required_input');
					$('#d_location_req').hide();
					
					if('required' == $('#checkout_location').val() && '' == $.trim($('#tx_ifeedback_contactform_location').val())) {
						//alert($('#cout_page_gender_required').val());
						//return false;
						$('#tx_ifeedback_contactform_location').addClass('required_input');
						$('#d_location_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_location').val() && '' == $.trim($('#tx_ifeedback_contactform_location').val())) {
						alert($('#cout_page_location_required').val());
						$('#checkout_location').val('asked');
						$('#tx_ifeedback_contactform_location').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				
				// RECIEPT
				if($('#checkout_reciept').length) {
					$('#tx_ifeedback_contactform_reciept').removeClass('required_input');
					$('#d_reciept_req').hide();
					
					if('required' == $('#checkout_reciept').val() && '' == $.trim($('#tx_ifeedback_contactform_reciept').val())) {
						//alert($('#cout_page_gender_required').val());
						//return false;
						$('#tx_ifeedback_contactform_reciept').addClass('required_input');
						$('#d_reciept_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_reciept').val() && '' == $.trim($('#tx_ifeedback_contactform_reciept').val())) {
						alert($('#cout_page_reciept_required').val());
						$('#checkout_reciept').val('asked');
						$('#tx_ifeedback_contactform_reciept').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				// STAFF
				if($('#checkout_staff').length) {
					$('#tx_ifeedback_contactform_staff').removeClass('required_input');
					$('#d_staff_req').hide();
					
					if('required' == $('#checkout_staff').val() && '' == $.trim($('#tx_ifeedback_contactform_staff').val())) {
						//alert($('#cout_page_gender_required').val());
						//return false;
						$('#tx_ifeedback_contactform_staff').addClass('required_input');
						$('#d_staff_req').show();
						f_required = true;
					}
									
					if('ask_once' == $('#checkout_staff').val() && '' == $.trim($('#tx_ifeedback_contactform_staff').val())) {
						alert($('#cout_page_staff_required').val());
						$('#checkout_staff').val('asked');
						$('#tx_ifeedback_contactform_staff').removeClass('required_input');
						
						//$('.loadingAnimation').toggle();
						return false;
					}
				}
				
				
				if(f_required) {
					//alert($('#fields_required_msg').val());
					//$('.loadingAnimation').toggle();
					return false;
				}
				

				//////$('.loadingAnimation').toggle();
				$('.send_feedback_button').hide();
				$.mobile.changePage('#checkout');
				
				var formData = $('#tx_ifeedback_contactform').serialize();
				
				//$.post($('#tx_ifeedback_contactform').attr('action'), $('#tx_ifeedback_contactform').serialize());
				$.ajax({
					type: 'POST',
					url: $('#tx_ifeedback_contactform').attr('action'),
					data: formData,
					async: true
				});
				
				if('yes' == $('#use_idle_timeout').val()) {
					window.setTimeout('idleRedirect()', 10000);
				}
			});
			
			$('#tx_ifeedback_ratingform').submit(function(event) {
				event.preventDefault();
				
				// dont save rating for non-star-ratings without comment
				if($('#rateit6').length == 0) {
					if('' == $.trim($('#textarea-a').val()) || $('#ta-a_placeholder').val() == $('#textarea-a').val()) {
						//alert('KOMMENTAR ERFORDLICH');
						alert($('#no_stars_comment_required').val());
						//history.back();
						return false;
					}
				}
				
				var ratingValue = $('#backing6').val();
				if(0 == ratingValue && $('#rateit6').length) {
					// if star rating is available and rating value is 0,
					// refuse to submit form until user has set a rating
					// value of at least 1 star.
					alert(customNoRatingValueError);
					return false;
				}
				
				if($('#comment_required_at_value').length) {
					if(ratingValue <= $('#comment_required_at_value').val()) {
						if('' == $.trim($('#textarea-a').val()) || $('#ta-a_placeholder').val() == $('#textarea-a').val()) {
							alert(commentRequired);
							return false;
						}
					}
				}
				
				if($('#ta-a_placeholder').val() == $('#textarea-a').val()) {
					$('#textarea-a').val('');
				}
				
				var id = $('#tx_ifeedback_ratingform_topic_id').val();
				$.post($('#tx_ifeedback_ratingform').attr('action'), $('#tx_ifeedback_ratingform').serialize());
				/*$.ajax({
					type: 'POST',
					url: $('#tx_ifeedback_ratingform').attr('action'),
					data: $('#tx_ifeedback_ratingform').serialize(),
					async: false
				});*/
				//alert($('#backing6').val());
				var ratingComment = $('#textarea-a').val();
				//alert(ratingValue);
				var rating_span = '#rating_span'+id;
				var rating_value_span = '#rating_value_span'+id;
				var rating_comment_span = '#rating_comment_span'+id;
				var listitem = '#l'+id;
				
				// refresh sum of ratings..
				if('' == $(rating_value_span).text()) {
					
					//if($('#rateit6').length) {
						$(activeRatingSumSpan).text(parseInt($(activeRatingSumSpan).text())+1);
						$(activeRatingSumBottomSpans).text($(activeRatingSumSpan).text());
						$(activeRatingSumBottomSpans).css('visibility', 'visible');
						$(activeRatingSumBottomSpanWraps).css('visibility', 'visible');
					//}
				}
				$(rating_value_span).text(ratingValue);
				
				if($('#rateit6').length) {
					// show rated stars when star rating is available
					$(rating_span).html('<img src="/files/images/stars32_'+ratingValue+'.png" class="liststars">');
				} else {
					// otherwise show an image that implies a 'rating' has been done.
					$(rating_span).html('<img src="/files/images/checked.png" class="liststars">');
				}
				
				$(rating_span).css('visibility', 'visible');
				$(rating_comment_span).text($.trim(ratingComment));
				$(listitem).attr('data-icon', 'false');
				//$('.send_feedback_button').show();
				//$('#rating_submit').hide();
				//alert('click!');
				history.back();
				$('.send_feedback_button').fadeIn(1000);
				
			});

			$('#yes-button').bind('click', function(event){
				$('#yes-no').hide();
				$(".checkboxxy").each(function(){$(this).checkboxradio()});
				$('#options-wrapper').show('fast');
			});

			$('#tx_ifeedback_optionform').submit(function(event) {
				event.preventDefault();
				
				var id = $('#tx_ifeedback_ratingform_topic_id').val();
				$.post($('#tx_ifeedback_optionform').attr('action'), $('#tx_ifeedback_optionform').serialize());
				/*$.ajax({
					type: 'POST',
					url: $('#tx_ifeedback_ratingform').attr('action'),
					data: $('#tx_ifeedback_ratingform').serialize(),
					async: false
				});*/
				//alert($('#backing6').val());
				//alert(ratingValue);
				var ratingValue = 0;
				var rating_span = '#rating_span'+id;
				var rating_value_span = '#rating_value_span'+id;
				var rating_comment_span = '#rating_comment_span'+id;
				var listitem = '#l'+id;
				
				// refresh sum of ratings..
				if('' == $(rating_value_span).text()) {
					
					//if($('#rateit6').length) {
						$(activeRatingSumSpan).text(parseInt($(activeRatingSumSpan).text())+1);
						$(activeRatingSumBottomSpans).text($(activeRatingSumSpan).text());
						$(activeRatingSumBottomSpans).css('visibility', 'visible');
						$(activeRatingSumBottomSpanWraps).css('visibility', 'visible');
					//}
				}
				$(rating_value_span).text(ratingValue);
				
				// if($('#rateit6').length) {
				// 	// show rated stars when star rating is available
				// 	$(rating_span).html('<img src="/files/images/stars32_'+ratingValue+'.png" class="liststars">');
				// } else {
					// otherwise show an image that implies a 'rating' has been done.
					$(rating_span).html('<img src="/files/images/checked.png" class="liststars">');
				// }
				
				$(rating_span).css('visibility', 'visible');
				// $(rating_comment_span).text($.trim(ratingComment));
				$(listitem).attr('data-icon', 'false');
				//$('.send_feedback_button').show();
				//$('#rating_submit').hide();
				//alert('click!');
				history.back();

				$('#optionform_topic_options').html();
				$('#options-wrapper').hide();
				$('#yes-no').show();
				$('.send_feedback_button').fadeIn(1000);
				
			});
			
			
			$('#textarea-a').bind('change', function () {
				if(($('#backing6').val() != null) && (0 < $('#backing6').val()))
				$('#rating_submit').fadeIn(1000);
			});
			
			
			// Validate email on change
			$('#tx_ifeedback_contactform_mail').bind('change', function() {
				if(!(validateEmail($('#tx_ifeedback_contactform_mail').val())) && $('#tx_ifeedback_contactform_mail').val() != '') {
					if($('#tx_ifeedback_contactform_mail').attr('validationalert') != undefined) {
						alert($('#tx_ifeedback_contactform_mail').val() + ': ' + $('#tx_ifeedback_contactform_mail').attr('validationalert'));
					}
				}
			});
			
			// Validate age on change
			$('#tx_ifeedback_contactform_age').bind('change', function() {
				if(!(validatePositiveInteger($('#tx_ifeedback_contactform_age').val())) && $('#tx_ifeedback_contactform_age').val() != '') {
					if($('#tx_ifeedback_contactform_age').attr('validationalert') != undefined) {
						alert($('#tx_ifeedback_contactform_age').val() + ': ' + $('#tx_ifeedback_contactform_age').attr('validationalert'));
					}
				}
			});
			
			// Validate phone on change
			$('#tx_ifeedback_contactform_roomno').bind('change', function() {
				if(!(validatePhoneNumber($('#tx_ifeedback_contactform_roomno').val())) && $('#tx_ifeedback_contactform_roomno').val() != '') {
					if($('#tx_ifeedback_contactform_roomno').attr('validationalert') != undefined) {
						alert($('#tx_ifeedback_contactform_roomno').val() + ': ' + $('#tx_ifeedback_contactform_roomno').attr('validationalert'));
					}
				}
			});
			
			$('#rateit6').bind('rated', function (event, value) {
				
				if (value == null) {valuetxt1 = customRatingDefaultLabel};
				if (value == 0) {valuetxt1 = customRatingDefaultLabel};
				if (value == 1) {valuetxt1 = customRating1Label};
				if (value == 2) {valuetxt1 = customRating2Label};
				if (value == 3) {valuetxt1 = customRating3Label};
				if (value == 4) {valuetxt1 = customRating4Label};
				if (value == 5) {valuetxt1 = customRating5Label};
				
				r_value = valuetxt1;
				
				//$('#value5').text(valuetxt1);
				$('#value6').text(r_value);
				
				//$('#submit3').fadeIn(1000);
				$('#rating_submit').fadeIn(1000);
			
			});
			
			$('#rateit6').bind('hover', function (event, value) {
				if (value == null) {valuetxt2 = value};
				if (value == 0) {valuetxt2 = customRatingDefaultLabel};
				if (value == 1) {valuetxt2 = customRating1Label};
				if (value == 2) {valuetxt2 = customRating2Label};
				if (value == 3) {valuetxt2 = customRating3Label};
				if (value == 4) {valuetxt2 = customRating4Label};
				if (value == 5) {valuetxt2 = customRating5Label};
				
				//r_value = valuetxt2;

				$('#value6').text(valuetxt2);
			});
			
			$('#rateit6').bind('mouseleave', function () {
				//var value = $('#value6').text();
				//var value2 = r_value;
				//alert('Event: ' + event + '; Value: ' + value + '; r_value: ' + value2);
				$('#value6').text(r_value);
			});
			
			$('#feedback').live('pagebeforeshow', function(event, ui) {
				if('' == $('#textarea-a').val()) {
					//$('#textarea-a').val($('#ta-a_placeholder').val());
					//$('#textarea-a').css('color', '#ccc');
				}
			});
			
			$('#feedback').live('pagehide', function(event, ui) {
				if(0 < $('#backing6').val()) {
					$('#textarea-a').val('');
				}
				$('#rateit6').rateit('value', '0');
				//$('#rating_submit').hide();
				value = customRatingDefaultLabel;
				$('#value6').text(value);
			});
			
			$('#textarea-a').bind('click', function(event) {
				if($('#ta-a_placeholder').val() == $('#textarea-a').val()) {
					$('#textarea-a').val('');
					$('#textarea-a').css('color', '#000');
				}
			});
			
			// new handler for rating links (needs to be put before old handler
			// to correctly set the needed vars before old handler uses them)
			$('.rating_link').click(function(event) {									
				var r_strs = $(this).attr('rating-strs');
				var r_strs_arr = r_strs.split(';');
				
				if (r_strs_arr.length == 7) {
					customRatingDefaultLabel		=	r_strs_arr[0];
					customRating1Label				=	r_strs_arr[1];
					customRating2Label				=	r_strs_arr[2];
					customRating3Label				=	r_strs_arr[3];
					customRating4Label				=	r_strs_arr[4];
					customRating5Label				=	r_strs_arr[5];
					customNoRatingValueError		= 	r_strs_arr[6];
				} else {
					customRatingDefaultLabel		=	ratingDefaultLabel;
					customRating1Label				=	rating1Label;
					customRating2Label				=	rating2Label;
					customRating3Label				=	rating3Label;
					customRating4Label				=	rating4Label;
					customRating5Label				=	rating5Label;
					customNoRatingValueError		= 	noRatingValueError;
				}
				
				$('#value6').text(customRatingDefaultLabel);
				r_value = customRatingDefaultLabel;
				
			});
			
			$('.rating_link').bind('click', function(event) {
				var page_id = $(this).attr('id');
				var rating_value_span = '#rating_value_span'+page_id.substr(1);
				var rating_comment_span = '#rating_comment_span'+page_id.substr(1);
				var rating_value = $(rating_value_span).text();
				var rating_comment = $(rating_comment_span).text();
				if('' != rating_value) {
					$('#rateit6').rateit('value', rating_value);
					if('1' == rating_value) { $('#value6').text(customRating1Label); };
					if('2' == rating_value) { $('#value6').text(customRating2Label); };
					if('3' == rating_value) { $('#value6').text(customRating3Label); };
					if('4' == rating_value) { $('#value6').text(customRating4Label); };
					if('5' == rating_value) { $('#value6').text(customRating5Label); };
					
					r_value = $('#value6').text();
				}
				if('' != rating_comment) {
					$('#textarea-a').val(rating_comment);
					$('#textarea-a').css('color', '#000');
				} else {
					$('#textarea-a').css('color', '#ccc');
					$('#textarea-a').val($('#ta-a_placeholder').val());
				}
			});
			
			$('.category_link').bind('click', function(event) {
				var page_id =$(this).attr('id');
				var ratingsum_span = 'ratingsum_span'+page_id.substr(1);
				var ratingsum_wrap = 'ratingsum_wrap'+page_id.substr(1);
				activeRatingSumSpan = '#'+ratingsum_span;
				activeRatingSumBottomSpans = '.'+ratingsum_span;
				activeRatingSumBottomSpanWraps = '.'+ratingsum_wrap;
			});
			
			$('.li_lng').click(function(event) {
				$('#ul_langselect').addClass('ui-disabled');
			});
			
			// TODO: EXTREMELY ugly workaround. Try to get this done properly.
			$('.send_without_contactform').click(function() {
				$.mobile.changePage('#sendfeedbackpage');
				$('#tx_ifeedback_contactform_submit_button').click();
				//$.mobile.changePage('#checkout');
				//$('#tx_ifeedback_contactform_submit_button').click();
			});
			
			// contactform header send button
			$('#cf_header_send').click(function(event) {
				event.preventDefault();
				$('#tx_ifeedback_contactform_submit_button').click();
			});
			
		}
);