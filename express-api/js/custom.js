/* ========================================================== */
/*   Custom jquery functions                              */
/* ========================================================== */

$( document ).ready(function() {

	/* to print projekt data */
	$("body").delegate(".img-fluid", "click", function(){

		var $elmnt = $(this);
		$elmnt.hide();
		$gif = $elmnt.parent().parent().find('.loader');
		$gif.show();
		var $type = $elmnt.data("type");
		var $guid = $elmnt.data("guid");
		
		$.ajax({
			url: "main-ajax.php",
			type: "POST",
			data: {type: $type, guid: $guid} ,
			success: function (response) {
				//$(".output_result").html(response);
				$(".output_result").remove();
				var result = '<div class="output_result">'+response+'</div>';
				$elmnt.parent().parent().parent().after(result);
				$gif.hide();
				$elmnt.show();
				/* if($type == 'projekt'){
					$('html, body').animate({
						scrollTop: $(".output_result").offset().top
					}, 600);
				} */
			},
			error: function(jqXHR, textStatus, errorThrown) {
			   console.log(textStatus, errorThrown);
			}
		});

	}); 
	
	
	/* to get all projects */
	
	$(".menu").click(function(){
		
		var $elmnt = $(this);
		load_projekts($elmnt);
		
	}); 
	
	
	$("body").delegate(".api_table", "click", function(){
		var $elmnt = $(this);
		if($elmnt.next().hasClass('output_result')){
			$('.output_result').remove();
		}
		
	}); 
	
	$(".show_all").click(function(){
		
		if($(this).text() == "Hide All"){
			$(".all_api_data").html("");
			$(".show_all").text('Show All');
			return false;
		}
		var $show_all = $('.api_button_main').find('.menu.active').data('type');
		$("#loader-icon").show();
		$.ajax({
			url: "main-ajax.php",
			type: "POST",
			data: {show_all: $show_all},
			success: function (response) {
				$("#loader-icon").hide();
				$(".show_all").text('Hide All');
				$('.output_result').remove();
				$(".all_api_data").html(response);
			},
			error: function(jqXHR, textStatus, errorThrown) {
			   console.log(textStatus, errorThrown);
			}
		});
		
	});
	
	
	function load_projekts($elmnt){
		
		active_menu($elmnt);
		
		var $type = $elmnt.data("type");
		
		if($type == 'get_projekts'){
			var $projekt_text = "Projekt";
		}else if($type == 'get_successions'){
			var $projekt_text = "Succession";
		}else if($type == 'get_succession_projekts'){
			var $projekt_text = "Succession Projekts";
		}
		
		$("#loader-icon").show();
		$.ajax({
			url: "main-ajax.php",
			type: "POST",
			data: {type: $type},
			success: function (response) {
				$("#loader-icon").hide();
				$(".projekt_heading").text($projekt_text); 
				$("#project_listing").html(response);
				$(".output_result").html("");
			},
			error: function(jqXHR, textStatus, errorThrown) {
			   console.log(textStatus, errorThrown);
			}
		});
	}
		
	function active_menu($menu){

		$('.menu.active').removeClass('active');
		$menu.addClass('active');
	}

});