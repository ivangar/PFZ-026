

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


	   // $(document).ready(function () {
       $("#submit_evaluation").click(function(){
         var filledOut=true;
         var theAnswers = [];

         //check q1
         if(document.getElementById("textQ1").value===""){
          filledOut=false;
          document.getElementById("noQuestion1").style.display='block';
         }
         else{
          theAnswers.push(document.getElementById("textQ1").value);
          document.getElementById("noQuestion1").style.display='none';
         }

         //check q2
         if(document.getElementById("radioYesQ2").checked){
          if(document.getElementById("textQ2").value===""){
            filledOut = false;
            document.getElementById("noQuestion2").style.display='block';
          }
          else{
            theAnswers.push("YES: " + document.getElementById('textQ2').value);
            document.getElementById("noQuestion2").style.display='none';
          }
         }
         else if(document.getElementById('radioNoQ2').checked){
          theAnswers.push("No");
          document.getElementById("noQuestion2a").style.display='none';
          document.getElementById("noQuestion2").style.display='none';
         }
         else{
          document.getElementById("noQuestion2a").style.display='block';
          filledOut = false;
         }

         //check q3
         if(document.getElementById("textQ3").value===""){
          filledOut=false;
          document.getElementById("noQuestion3").style.display='block';
         }
         else{
          document.getElementById("noQuestion3").style.display='none';
          theAnswers.push(document.getElementById("textQ3").value);
         }

         //check q4
         if(document.getElementById("textQ4").value===""){
          filledOut=false;
          document.getElementById("noQuestion4").style.display='block';
         }
         else{
          document.getElementById("noQuestion4").style.display='none';
          theAnswers.push(document.getElementById("textQ4").value);
         }

         //check q5
         if(document.getElementById("radioYesQ5").checked){
          if(document.getElementById("textQ5").value===""){
            filledOut = false;
            document.getElementById("noQuestion5").style.display='block';
            document.getElementById("noQuestion5a").style.display='none';
          }
          else{
            theAnswers.push("YES: " + document.getElementById('textQ5').value);
            document.getElementById("noQuestion5").style.display='none';
            document.getElementById("noQuestion5a").style.display='none';
          }
         }
         else if(document.getElementById('radioNoQ5').checked){
          theAnswers.push("No");
          document.getElementById("noQuestion5a").style.display='none';
          document.getElementById("noQuestion5").style.display='none';
         }
         else{
          document.getElementById("noQuestion5a").style.display='block';
          filledOut = false;
         }

         //check q6
         if(document.getElementById("textQ6").value===""){
          theAnswers.push("NULL");
         }
         else{
          theAnswers.push(document.getElementById("textQ6").value);
         }


        if(filledOut){
                       
            var evaluation_submitted = {"qas": theAnswers};
            target = "resources/process_evaluation.php";

            $.ajax({
                url: target,
                cache: false,
                type: "POST",
                dataType: "html",
                data: evaluation_submitted
              }) 

            .done(function( data ) {
                if (data === "failed"){
                      $( ".parsley-container.evaluation" ).html( "<ul> <li>To submit the evaluation you must answer all questions.</li></ul>" );
                      $( ".parsley-container.evaluation" ).show();
                      $("html, body").animate({
                        scrollTop: 0
                      }, 500);     
                }

                if (data === "completed"){
                    document.location.reload(true); //reload page in order to update access to post-test form
                }
                
            })
            .fail(function() {
                  $( ".parsley-container.evaluation" ).html( "<ul> <li>We are sorry, the questions were not submitted. Try again. </li></ul>" );
                  $( ".parsley-container.evaluation" ).show();
                      $("html, body").animate({
                        scrollTop: 0
                      }, 500);     
            }); //ajax call

        }
        else{
          console.log("form not filled out.");
        }


       // });
    });
	});//end document.ready
