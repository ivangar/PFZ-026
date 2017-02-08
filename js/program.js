

    /*$.noConflict();*/
    $(document).ready(function () {

    	var videos = ["player1"];
    	var video_sources = [
    		"https://player.vimeo.com/video/190132047"
    		];

	    //this global function needs to be accessible to the loaded section in the tab
	    window.showTab = function (tab) {
				$("#v-nav ul li[tab=" + tab + "]").click();
	    }

	    // Bind the event hashchange, using jquery-hashchange-plugin
	    $(window).hashchange(function () {
			showTab(location.hash.replace("#", ""));
	    })

	    // Trigger the event hashchange on page load, using jquery-hashchange-plugin
	    $(window).hashchange();

	    $("html, body").animate({
        	scrollTop: 0
    	}, 400);  

    	$('#v-nav>ul>li').click(function(){
	    	var element = $( this ).attr( "title" );
	    	if( (element === "Video") ){
				var $frame = $('iframe#player1');
				$frame.attr('src', "https://player.vimeo.com/video/190132047");	    				
    		}
	    	else{
				
				//for(var index = 0; index < videos.length; index++){
				var $frame = $('iframe#player1');
				$frame.attr('src','');
	    	}
	    	
	    });

    	$('li#custom').click(function(){
	    	var element = $( this ).attr( "id" );
	    	
	    	if( (element == "custom") ){
				document.location.href = "https://" + window.location.hostname + "/programs/CCC_Symposium/rep_zone/login.html";
	    	}
	    	
	    });

	    $( "#bias_yes, #bias_no" ).change(function() {
	        var $input = $( this );
	        var my_val = $input.val();

	        //Check that the check property returns true, then disable/enable accordingly
	        if($input.prop( "checked" )){
	          if(my_val === 'yes'){
	            $( "#bias_no" ).prop( "disabled", true );
	          }

	            else{
	              $( "#bias_yes" ).prop( "disabled", true );
	            }
	        }
	          
	        else{
	            $( "#bias_yes" ).prop( "disabled", false );
	            $( "#bias_no" ).prop( "disabled", false );
	        }

      	});

	});//end document.ready
