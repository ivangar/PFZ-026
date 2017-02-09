<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start();


if(!isset($_SESSION))
{
session_start();
}  

require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/php/connect_db.php");

//check if the $_GET variables are present and proceed with registration confirmation process
if(isset($_POST) && (!empty($_POST))){

	//If user is logged in, use this login, otherwise use anonymous (doctor id '233' for local server)
	if($_SESSION['user_id']){
		$doctor_id = strval($_SESSION['user_id']);
	}
	else{
		$doctor_id = strval(1255);
	}

	$answer;
	$data = $_POST; //contains questions-answer array and program section id
	$con = GetDBconnection(); // get database connection credentials
	$program_section_id = 'PFZ_026_Eval_01'; // program section id to be inserted in the foreign key column

	if(GetData($data, $program_section_id)){
		// should insert a new record with the program section answered and date.
		if (InsertEvaluation($con, $doctor_id, $program_section_id) ){
			// $_SESSION['section_submitted'] = true;
			echo 'completed';
		}
		
		else {echo 'failed';} 
		
	}

	else echo 'failed';

	/* close connection */
	mysqli_close($con);

}

function GetData($data, $program_section_id)
{
	global $doctor_id;
	global $con;
	global $answer;

	$questions_answers = $data['qas'];  //temporary array holding question and answers from post array
	$program_section_id = 'PFZ_026_Eval_01'; //program section id

	//loop through questions array
	foreach ($questions_answers as $qas_index => $value) {
		$value = Sanitize($value);  //Sanitize answers and questions before inserting into DB
		$answer = $value;	 
		
		//increment question id by 1
		$q_id = "PFZ_E_0";
		$q_id .= strval($qas_index + 1);
			
		if(!InsertAnswers($con, $doctor_id, $program_section_id, $q_id, $answer, "NULL")){
			return false;
		}
	}
	return true;
}


//replace html entities
function Sanitize($str,$remove_nl=true)
{
    if($remove_nl)
    {
        $injections = array('/(\n+)/i',
            '/(\r+)/i',
            '/(\t+)/i',
            '/(%0A+)/i',
            '/(%0D+)/i',
            '/(%08+)/i',
            '/(%09+)/i'
            );
        $str = preg_replace($injections,'',$str);
    }

    return $str;
}   
 
//Escape entities
function SanitizeForSQL($con, $str)
{
    if( function_exists( "mysqli_real_escape_string" ) )
    {
          $ret_str = mysqli_real_escape_string($con, $str);
    }
    else
    {
          $ret_str = addslashes( $str );
    }
    return $ret_str;
}

//Inserts all answers in the database
function InsertAnswers($con, $doctor_id, $program_section_id, $q_id, $answer, $choice)
{
	$program_section_id =  SanitizeForSQL($con, $program_section_id);
	$q_id =  SanitizeForSQL($con, $q_id);
	$answer =  SanitizeForSQL($con, $answer);

    $insert_answer_qr = "INSERT INTO doctor_answers (
            doctor_id,
            program_section_id,
            question_id,
            doctor_answer,
            answer_choice,
            date_of_answer
            )
            VALUES
            (
            '$doctor_id',
            '$program_section_id',
            '$q_id',
            '$answer',
            $choice,
            NOW()
            )"; 
    //mysqli_query() returns true on successful insertion, false otherwise
    $insert_answer = mysqli_query($con, $insert_answer_qr);

    if(!$insert_answer){
        return false;
    }

    return true;
}

//Insert a result for the completed program section
function InsertEvaluation($con, $doctor_id, $program_section_id){
	$program_section_id = SanitizeForSQL($con, $program_section_id);

    $insert_evaluation_qr = 'INSERT INTO evaluations (
            doctor_id,
            program_section_id,
            date_time
            )
            VALUES
            (
            "' . $doctor_id . '",
            "' . $program_section_id . '",
            NOW()
            )'; 

    //mysqli_query() returns true on successful insertion, false otherwise
    $insert_eval = mysqli_query($con, $insert_evaluation_qr);

    if(!$insert_eval){
        return false;
    }
    
    return true;
}?>