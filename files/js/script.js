$(document).ready(function(){
	$(".switch").bootstrapSwitch();
	$(".chosen").chosen();
	$(".delete").confirmation();
	$(".yesno-switch").bootstrapSwitch({'onSwitchChange': function(event, state){
		var stateValue = (state)? 1 : 0;
		window.vento =event;
		$(event.target).closest(".controls").find(".flag-value").val(stateValue);
	}});
});


$(document).on("click", ".optionizer.icon-plus", function(){
	$(this).parent().clone().appendTo(".input-fields");
	$(".input-fields .controls").last().find("input").val("");
	$(this).removeClass("icon-plus").addClass("icon-minus");
	return false;
});

$(document).on("click", ".optionizer.icon-minus", function(){
	$(this).parent().remove();
	return false;
});