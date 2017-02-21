<?php 
//REQUIRE FIREPHP AND INITIALIZE OBJECT
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
session_start();
ob_start(); // Turn on output buffering. From this point output is stored in an internal buffer 
require_once('../../inc/php/membersite_config.php');
//require_once("../lib/php/program.php"); 


if(isset($_POST['login_submitted']))
{
	//After logged in redirect to index and catch session login at the beginning (Session var already active)
	if(!$fgmembersite->Login()){
		$error_returned = $fgmembersite->GetErrorMessage(); 
	}
}

//if user wants to logout
if(isset($_POST['logout_submitted']))
{	
	$fgmembersite->LogOut();
}

if(isset($_COOKIE['rememberme']) && !empty($_COOKIE['rememberme']) ){
	$fgmembersite->CheckCookie();
}

//If the user has not logged in, not show my account item
(!$fgmembersite->CheckLogin()) ? $menu_item = "<li><a href='/registration.php' class='accredited'>Register</a></li>" : $menu_item = "<li><a href='/account.php' class='accredited'>My Account</a></li>";

//if user wants to logout
if(isset($_POST['logout_submitted']))
{
	$fgmembersite->LogOut();
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<title>dxLink - PFZ-026</title>
<script src="/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<link href="/css/styles.css" rel="stylesheet" type="text/css" />

<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="/css/form-submit-button.css"/>
<link type="text/css" rel="stylesheet" href="/css/tabStyles.css"/>
<link type="text/css" rel="stylesheet" href="/css/Pretest/form.css"/>
<link type="text/css" rel="stylesheet" href="/css/Pretest/nova.css" />
<link type="text/css" rel="stylesheet" href="/programs/css/program_styles.css" />


<link type="text/css" rel="stylesheet" href="css/main.css" />
<script type="text/javascript" src="/js/parsley.js"></script>
<script type="text/javascript" src="/browser/bowser.min.js"></script>
<script type="text/javascript" src="/js/hashchange.js"></script>
<script type="text/javascript" src="/js/tabScript.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript" src="js/program.js"></script>
<script src="/js/jquery.blockUI.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">




<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49063752-3', 'auto');
  ga('send', 'pageview');

</script>



<style>
.ui-tooltip {
background: #f6f6f6;
border: 2px solid #969696;

}
.ui-tooltip {
border-radius: 10px;
box-shadow: 0 0 7px black;
font-family:Arial,Helvetica,sans-serif;
font-size:16px;
font-style: italic;
padding: 10px 20px;
}

.slides_qty{
font-family:Arial,Helvetica,sans-serif;
font-size:12px;
line-height: 10px;
}

</style>


<script type="text/javascript">

// unblock when ajax activity stops 
//$(document).ajaxStop($.unblockUI); 

$(document).ready(function(){
	var login_submitted = <?php if(isset($_POST['login_submitted'])) echo "true"; else echo "false";?>;
	var access = <?php if($fgmembersite->CheckLogin()) echo "true"; else echo "false";?>;
	var logged_in = <?php if(isset($_SESSION['welcome'])) {echo "true"; unset($_SESSION['welcome']);} else echo "false"; ?>;

    if(!access && login_submitted){
			$.blockUI({ message: $('#access-request'), 
	            css: { 
					top:  ($(window).height() - 400) /2 + 'px', 
					left: ($(window).width() - 500) /2 + 'px', 
					cursor:'auto',
					width: '430px',
					height: '200px',
					border: '10px solid #ccc',
					padding: '0', 
					backgroundColor: '#fff', 
					'-moz-border-radius': '20px',
					'-webkit-border-radius': '20px',
				    'border-radius': '20px'},
				 overlayCSS: { backgroundColor: '#000', opacity: .5, cursor:'not-allowed'}
			  });	
			  $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI); 
    }

    //close dialog window on clicking the gif button
    $('#close, #close2').click(function() { 
		$.unblockUI();
	});

    //Swap close image button
    $('#swap_button, #swap_button2').mouseover(function () {
    	var button_id = ( $(this).attr( "id" ) === "swap_button" ) ? "#close" : "#close2";
     	$(button_id).attr( "src", "/images/closebutton_hover.png" );
    });

	//Swap close image button
    $('#swap_button, #swap_button2').mouseout(function () {
    	var button_id = ( $(this).attr( "id" ) === "swap_button" ) ? "#close" : "#close2";
		$(button_id).attr( "src", "/images/closebutton.png" );
    });   

    //show welcome window on login
    if(access && logged_in){
		$.blockUI({ 
		            message: '\<br\>Welcome <?php echo $fgmembersite->UserFullName(); ?> \<br\>\<br\> Now you\'re logged in \<br\>\<br\>', 
		            fadeIn: 700, 
		            fadeOut: 1000, 
		            timeout: 2000, 
		            showOverlay: false, 
		            centerY: false, 
		            css: { 
		                width: '400px',
						height: '200px', 
						top:  ($(window).height() - 200) /2 + 'px', 
						left: ($(window).width() - 400) /2 + 'px', 
		                border: 'none', 
		                padding: '5px', 
						textAlign: 'center',
						font: '30px Arial,Helvetica,sans-serif',
		                backgroundColor: '#000', 
		                '-moz-border-radius': '10px',
		                '-webkit-border-radius': '10px', 
		                'border-radius': '10px',
		                opacity: .8, 
		                color: '#fff' 
		            } 
		}); 
    }
	
	var countChecked = function() {
		var remember = $( "input:checked" ).val();
		if(remember === '1'){
			 $("#remember_submitted").val("1");
		}

		else $("#remember_submitted").val("0");
	};

	countChecked();
	
	$( "#remember_me:checkbox" ).on( "click", countChecked );

	$("ul.success li").css({ "line-height": "50px", "font-size": "15px", "-webkit-transition": "all 1s linear", "-moz-transition": "all 1s linear", "-o-transition": "all 1s linear", "transition": "all 1s linear"});

	
});

</script>




</head>
<body class="gradient"> 
	<div id="access-request" style="display:none;"> 
	<?php $fgmembersite->printModalDialog(); ?>
</div> 
<table class="content" border="0" cellspacing="0">
  <tr valign="bottom">
    <td width="250" height="90" align="left" bgcolor="#FFFFFF" style="padding:0 0 10px 20px;" ><a href="/index.php"><img src="/images/dxLinkAP.jpg" width="147" height="42" align="left" alt="dxlink"/></a>
	</td>
	<td align="right" style="padding-right:20px">
	<div align="right" style="display: inline-block;">
		<!-- LOGIN/LOGOUT SECTION -->
		<?PHP

		if(!$fgmembersite->CheckLogin()){ $fgmembersite->printLogin();	}
		else{$fgmembersite->printLogout();}
		
		?>
	</div>
</td>
	<!-- <td bgcolor="#FFFFFF" style="padding:0 0 5px 0;" align="right">
		<div style="display: inline-block;"><?php //$fgmembersite->printLogout(); ?></div>
	</td> -->
  </tr>
</table>



<!-- NAV BAR TABLE -->
<table class="content" border="0" cellspacing="0">
  <tr align="center" valign="top">
    <td height="30" style="padding:0;background:#3B0CAF;">
		<ul id="MenuBar1" class="MenuBarHorizontal">
	      <li class="home"><a href="/index.php" class="accredited">Home</a></li>
	      <li><a href="" class="MenuBarItemSubmenu accredited">Programs</a>
	        <ul>
	          <li><a href="/accredited_programs.php" class="accredited">Accredited Programs</a></li>
	          <li><a href="/virtual_clinic.php" class="accredited">Virtual Clinic</a></li>
	          <li><a href="/congress_reports.php" class="accredited">Congress Reports</a></li>
	          <li><a href="/clinical_update.php" class="accredited">Clinical Update</a></li>
	        </ul>
	      </li>
	      <?= $menu_item; ?>
	      <li><a href="/contact_us.php" class="accredited">Contact Us</a></li>
      	  <li><a href="http://www.cjdiagnosis.com/?ac=diagnosis" target="_blank" class="accredited">CJ Diagnosis</a></li>
      	  <li><a href="http://www.cjcme.com//?ac=cme" target="_blank" class="accredited">CJ CME</a></li>
     	  <li class="last"><a href="http://www.stacommunications.com/" target="_blank" class="accredited">STA HealthCare Communications</a></li>
	    </ul>
	</td>
  </tr>
  </table>
  <!-- NAV BAR ENDS HERE -->
   <!-- INNER 3-COLUMN STYLE TABLE  -->
  <table class="three-columns" border="0" cellspacing="0">
  <tr valign="top">
	  <!-- LEFT VERTICAL TABBED SECTION -->

		  <td style="padding: 20px 0 0 0;">
	          <section id="wrapper" class="wrapper">
	              <div id="v-nav">
					  <ul>
	                      <li tab="tab1" class="first current" >Home</li>
	                      
	                      <li tab="tab2" title="*Watch Video*" ><i class="fa fa-video-camera fa-fw"></i> An Update on the Safety of Smoking-cessation Therapies<br>Robert M. Anthenelli, M.D.</li>
	                      
	                      <li tab="tab3" title="Evaluation" >Program Evaluation</li>
					  </ul>
	                  <div class="tab-content" >
	                  	<?php  require('introduction.html'); ?>  
	                  </div>
	                  
	                  <div class="tab-content" >
	                  		<?php  require_once('video.html'); ?> 
	                  </div>
	                  
	                  <div class="tab-content" >
	                        <?php  require_once('evaluation.html'); ?> 
	                  </div>

	              </div>
	          </section>
  	</td>
  </tr>
</table>
  <!-- END INNER 3-COLUMN TABLE  -->
  <table class="content" border="0" cellspacing="0">
  <tr>
    <td  height="35" colspan="3" valign="top" bgcolor="#FFFFFF" align="center">
   </td>
  </tr>
 </table>
  <!-- FOOTER TABLE -->
  <table class="content" border="0" cellspacing="0">
  <tr>
    <td style="padding:20px 50px 0 20px;display:inline-block;" height="55" valign="bottom" bgcolor="#FFFFFF" align="center">
		<? $fgmembersite->printCopyright(); ?>   
    </td>
    <td style="padding:0 0 10px 400px;display:inline-block;" valign="bottom" bgcolor="#FFFFFF" align="center">  
    	<? $fgmembersite->printTermsConditions(); ?>
   </td>
  </tr>
</table>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1");
</script>
</body>
</html>
<?php ob_flush(); //This function will send the contents of the output buffer ?>