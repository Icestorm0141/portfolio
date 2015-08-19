<?php
include "tools.php";

function triviaUpdate($action,$table)
{
	if($action == "modify" && $table == "trivia_topics")
	{
		if($_POST['status'] == "active")
		{
			$v_records = mySQLDoQuery("select * from trivia_topics");
			foreach($v_records as $key => $value)
			{
				if($value['status'] == "active")
				{
					$updateStatus = "update trivia_topics set status='closed' where topicID='".$value['topicID']."';";
					//echo $updateStatus;
					writeSQL($updateStatus);
				}
			}
		}
		
		$nextField = "', ";
		$query = "update ".$table." set ";
		if($_POST['topicName'] != "")
		{ $query .= "topicName='".$_POST['topicName'];}
		if($_POST['topicDescription'] != "" && $_POST['topicName'] != "")
		{ $query .=$nextField;}
		if($_POST['topicDescription'] != "")
		{ $query .= "topicDescription='".$_POST['topicDescription'];}
		if($_POST['status'] != "" && ($_POST['topicDescription'] != "" || $_POST['topicName'] != ""))
		{ $query .=$nextField; }
		if($_POST['status'] != "")
		{ $query .= "status='".$_POST['status']."'"; }
		 $query .= " where topicID=".$_POST['topicID'];
		 
	}
	else if($action == "modify" && $table == "trivia_questions")
	{
		$nextField = "', ";
		$query = "update ".$table." set ";
		if($_POST['quizQuestion'] != "")
		{ $query .= "quizQuestion='".$_POST['quizQuestion']; }
		if($_POST['description'] != "" && $_POST['quizQuestion'] != "")
		{ $query .=$nextField;}
		if($_POST['description'] != "")
		{ $query .= "description='".$_POST['description'];}
		if($_POST['active'] != "" && ($_POST['description'] != "" || $_POST['quizQuestion'] != ""))
		{ $query .=$nextField; }
		if($_POST['active'] != "")
		{ $query .= "active='".$_POST['active']."'"; }
		 $query .= " where triviaQID=".$_POST['triviaQID'];
	}
	else if($action == "modify" && $table == "trivia_answers")
	{
		$nextField = "', ";
		$query = "update ".$table." set ";
		if($_POST['answerText'] != "")
		{ $query .= "answerText='".$_POST['answerText']; }
		if($_POST['numVotes'] != "" && $_POST['answerText'] != "")
		{ $query .=$nextField; }
		if($_POST['numVotes'] != "")
		{ $query .= "numVotes='".$_POST['numVotes']; }
		if($_POST['correct'] != "" && ($_POST['numVotes'] != "" || $_POST['answerText'] != ""))
		{ $query .=$nextField;}
		if($_POST['correct'] != "")
		{ $query .= "correct='".$_POST['correct']."'";}
		 $query .= " where answerID=".$_POST['answerID'];
	}
	else if($action == "add" && $table == "trivia_topics")
	{
		if($_POST['status'] == "active")
		{
			$v_records = mySQLDoQuery("select * from trivia_topics");
			foreach($v_records as $key => $value)
			{
				if($value['status'] == "active")
				{
					$updateStatus = "update trivia_topics set status='closed' where topicID='".$value['topicID']."';";
				//	echo $updateStatus;
					writeSQL($updateStatus);
				}
			}
		}
		
		$query = "insert into ".$table." values(NULL,'".$_POST['topicName']."','";
		$query .= $_POST['topicDescription']."','".$_POST['status']."');";
	
	}
	else if($action == "add" && $table == "trivia_questions")
	{
		$query = "insert into ".$table." values(NULL,'".$_POST['topicID']."','";
		$query .= $_POST['description']."','".$_POST['active']."','".$_POST['quizQuestion']."');";
	}
	else if($action == "add" && $table == "trivia_answers")
	{
		$query = "insert into ".$table." values(NULL,'".$_POST['triviaQID']."','";
		$query .= $_POST['answerText']."','".$_POST['correct']."','0');";
	}
	else if($action == "delete" && $table == "trivia_questions")
	{
		$query = "delete from ".$table." where triviaQID='".$_POST['triviaQID']."'";
	}
	else if($action == "delete" && $table == "trivia_topics")
	{
		$query = "delete from ".$table." where topicID='".$_POST['topicID']."';";
		//$query .= "delete from trivia_questions where topicID='".$_POST['topicID']."'";
		//$query = "delete * from ".$table." where topicID='".$_POST['topicID']."';";
		//$query .= "delete * from trivia_questions where topicID='".$_POST['topicID']."'";
	}
	else if($action == "delete" && $table == "trivia_answers")
	{
		$query = "delete from ".$table." where answerID='".$_POST['answerID']."'";
	}
	//echo $query;
	return $query;
}

function showUpdateForm($view,$subView,$v_records,$v_questions,$v_answers)
{
	//echo showObject($v_answers);
	if($view == "add" && $subView ==NULL)
	{
		$form ="<div class=\"leftAdmin\">\n";
		$form .= "<h2>Add a Topic</h2>\n";
		$form .= "<p>WARNING: Please do not use any single quotes or apostrophes (ex: ')</p>";
		$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\" name=\"addtopic\">\n";
		$form .="<input type=\"hidden\" name=\"subView\" value=\"status\" />\n";
		$form .="<input type=\"hidden\" name=\"table\" value=\"trivia_topics\" />\n";
		$form .="<input type=\"hidden\" name=\"view\" value=\"add\" />\n";
		$form .= "<p>Topic name: <input type=\"text\" name=\"topicName\" maxlength=\"50\" /></p>\n";
		$form .= "<p>Topic description: <input type=\"text\" name=\"topicDescription\" maxlength=\"100\" /></p>\n";
		$form .= "<p>Topic Status: <select name=\"status\">";
		$form .= "<option value=\"pending\">Pending</option>\n";
		$form .= "<option value=\"active\">Active</option><br />\n";
		$form .= "<option value=\"closed\">Closed</option></select></p>\n";
		$form .= "<p><input type=\"submit\" value=\"Add Topic\" /></p></form></div>\n";
		
		$form .="<div class=\"rightAdmin\">\n";
		$form .= "<h2>Add a Question</h2>\n";
		$form .= "<p>WARNING: Please do not use any single quotes or apostrophes (ex: ')</p>";
		$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\" name=\"addquestion\">\n";
		$form .="<input type=\"hidden\" name=\"subView\" value=\"status\" />\n";
		$form .="<input type=\"hidden\" name=\"table\" value=\"trivia_questions\" />\n";
		$form .="<input type=\"hidden\" name=\"view\" value=\"add\" />\n";
		$form .= "<p>Quiz Question: <input type=\"text\" name=\"quizQuestion\" maxlength=\"255\" /></p>\n";
		$form .= "<p>Short Quiz Description: <input type=\"text\" name=\"description\" maxlength=\"100\" /></p>\n";
		$form .= "<p>Open status: <select name=\"active\">\n";
		$form .= "<option value=\"0\">closed</option>\n";
		$form .= "<option value=\"1\">open</option></select></p>\n";
		$form .= "<p>Add to topic: <select name=\"topicID\">\n";
		foreach($v_records as $key => $value)
		{
			$form .="<option value=\"".$value['topicID']."\">".$value['topicName']."</option>\n";
		}
		$form .="</select></p>\n";
		$form .= "<p><input type=\"submit\" value=\"Add Question\" /></p></form></div>\n";
		
		$form .="<div class=\"bottomAdmin\">\n";
		$form .= "<h2>Add an Answer</h2>\n";
		$form .= "<p>WARNING: Please do not use any single quotes or apostrophes (ex: ')</p>";
		$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\" name=\"addanswer\">\n";
		$form .="<input type=\"hidden\" name=\"subView\" value=\"status\" />\n";
		$form .="<input type=\"hidden\" name=\"table\" value=\"trivia_answers\" />\n";
		$form .="<input type=\"hidden\" name=\"view\" value=\"add\" />\n";
		$form .= "<p>Answer Text: <input type=\"text\" name=\"answerText\" maxlength=\"255\" /></p>\n";
		$form .= "<p>Is this the correct answer to the question? <select name=\"correct\">\n";
		$form .= "<option value=\"true\">Yes</option>\n";
		$form .= "<option value=\"false\">No</option></select></p>\n";
		$form .= "<p>Add to Question: <select name=\"triviaQID\">\n";
		foreach($v_questions as $key => $value)
		{
			$form .="<option value=\"".$value['triviaQID']."\">".$value['quizQuestion']."</option>\n";
		}
		$form .="</select></p>\n";
		$form .= "<p><input type=\"submit\" value=\"Add Answer\" /></p></form></div>\n";
		}
		else if($view =="modify" && $subView == NULL)
		{
			$form ="<div class=\"leftAdmin\">\n";
			$form .= "<h2>Modify a Topic</h2>\n";
			$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\" name=\"modifytopic\">\n";
			$form .="<input type=\"hidden\" name=\"view\" value=\"modify\" />\n";
			$form .="<input type=\"hidden\" name=\"subView\" value=\"trivia_topic\" />\n";
			$form .= "<p>Modify topic: <select name=\"topicID\">\n";
			foreach($v_records as $key => $value)
			{
				$form .="<option value=\"".$value['topicID']."\">".$value['topicName']."</option>\n";
			}
			$form .="</select></p>\n";
			$form .= "<p><input type=\"submit\" value=\"Select Topic\" /></p></form></div>\n";
			
			$form .="<div class=\"bottomAdmin\" style=\"top:250px;\">\n";			
			$form .= "<h2>Modify a Question</h2>\n";
			$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\" name=\"modifyquestion\">\n";
			$form .="<input type=\"hidden\" name=\"view\" value=\"modify\" />\n";
			$form .="<input type=\"hidden\" name=\"subView\" value=\"trivia_Question\" />\n";
			$form .= "<p>Modify Question: <select name=\"triviaQID\">\n";
			foreach($v_questions as $key => $value)
			{
				$form .="<option value=\"".$value['triviaQID']."\">".$value['quizQuestion']."</option>\n";
			}
			$form .="</select></p>\n";
			$form .= "<p><input type=\"submit\" value=\"Select Question\" /></p></form></div>\n";
			
			$form .="<div class=\"bottomAdmin\" style=\"top:400px;\">\n";			
			$form .= "<h2>Modify an Answer</h2>\n";
			$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\" name=\"modifyanswer\">\n";
			$form .="<input type=\"hidden\" name=\"view\" value=\"modify\" />\n";
			$form .="<input type=\"hidden\" name=\"subView\" value=\"trivia_answers\" />\n";
			$form .= "<p>Modify answers to which question? <select name=\"triviaQID\">\n";
			foreach($v_questions as $key => $value)
			{
				$form .="<option value=\"".$value['triviaQID']."\">".$value['quizQuestion']."</option>\n";
			}
			$form .="</select></p>\n";
			$form .= "<p><input type=\"submit\" value=\"Select Question\" /></p></form></div>\n";
			
		}
		else if($view == "modify" && $subView =="topic")
		{
			foreach($v_records as $key => $value)
			{
				if($value['topicID'] == $_POST['topicID'])
				{
					$topic = $value['topicName'];
				}
			}
			$form ="<div class=\"leftAdmin\" style=\"width:700px;\">\n";
			$form .= "<h2>Modify $subView: $topic</h2>\n";
			$form .= "<p>WARNING: Please do not use any single quotes or apostrophes (ex: ')</p>";
			$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\" name=\"addtopic\">\n";
			$form .="<input type=\"hidden\" name=\"topicID\" value=\"".$_POST['topicID']."\" />\n";
			$form .="<input type=\"hidden\" name=\"table\" value=\"trivia_topics\" />\n";
			$form .="<input type=\"hidden\" name=\"subView\" value=\"status\" />\n";
			$form .="<input type=\"hidden\" name=\"view\" value=\"modify\" />\n";
			$form .= "<p>New topic name: <input type=\"text\" name=\"topicName\" maxlength=\"50\" /></p>\n";
			$form .= "<p>New topic description: <input type=\"text\" name=\"topicDescription\" maxlength=\"100\" /></p>\n";
			$form .= "<p>Topic status: <select name=\"status\">\n";
			$form .= "<option value=\"pending\">Pending</option>\n";
			$form .= "<option value=\"active\">Active</option><br />\n";
			$form .= "<option value=\"closed\">Closed</option></select></p>\n";
			$form .= "<p><input type=\"submit\" value=\"Done\" /></p></form></div>\n";
		}
		else if($view == "modify" && $subView =="question")
		{
			foreach($v_questions as $key => $value)
			{
				if($value['triviaQID'] == $_POST['triviaQID'])
				{
					$question = $value['quizQuestion'];
				}
			}
			$form ="<div class=\"leftAdmin\" style=\"width:700px;\">\n";
			$form .= "<h2>Modify $subView: $question</h2>\n";
			$form .= "<p>WARNING: Please do not use any single quotes or apostrophes (ex: ')</p>";
			$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\" name=\"addtopic\">\n";
			$form .="<input type=\"hidden\" name=\"triviaQID\" value=\"".$_POST['triviaQID']."\" />\n";
			$form .="<input type=\"hidden\" name=\"table\" value=\"trivia_questions\" />\n";
			$form .="<input type=\"hidden\" name=\"subView\" value=\"status\" />\n";
			$form .="<input type=\"hidden\" name=\"view\" value=\"modify\" />\n";
			$form .= "<p>New question: <input type=\"text\" name=\"quizQuestion\" maxlength=\"255\" /></p>\n";
			$form .= "<p>New short quiz description: <input type=\"text\" name=\"description\" maxlength=\"100\" /></p>\n";
			$form .= "<p>Open status: <select name=\"active\">\n";
			$form .= "<option value=\"0\">closed</option>\n";
			$form .= "<option value=\"1\">open</option></select></p>\n";
			$form .= "<p><input type=\"submit\" value=\"Done\" /></p></form></div>\n";
		}
		else if($view == "modify" && $subView =="answers")
		{
			foreach($v_questions as $key => $value)
			{
				if($value['triviaQID'] == $_POST['triviaQID'])
				{
					$question = $value['quizQuestion'];
				}
			}
			$form ="<div class=\"leftAdmin\" style=\"width:700px;\">\n";
			$form .= "<h2>Modify $subView to question: $question</h2>\n";
			$form .= "<p>WARNING: Please do not use any single quotes or apostrophes (ex: ')</p>";
			$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\">\n";
			$form .="<input type=\"hidden\" name=\"triviaQID\" value=\"".$_POST['triviaQID']."\" />\n";
			$form .="<input type=\"hidden\" name=\"table\" value=\"trivia_answers\" />\n";
			$form .="<input type=\"hidden\" name=\"subView\" value=\"status\" />\n";
			$form .="<input type=\"hidden\" name=\"view\" value=\"modify\" />\n";
			$form .="<p>Select answer to modify: <select name=\"answerID\">\n";
			foreach($v_answers as $key => $value)
			{
				if($value['triviaQID'] == $_POST['triviaQID'])
				{
					$form .="<option value=\"".$value['answerID']."\">".$value['answerText']."</option>\n";
				}
			}
			$form .="</select></p>\n";
			$form .= "<p>New answer text: <input type=\"text\" name=\"answerText\" maxlength=\"255\" /></p>\n";
			$form .= "<p>Is this the correct answer to the question? <select name=\"correct\">\n";
			$form .= "<option value=\"true\">Yes</option>\n";
			$form .= "<option value=\"false\">No</option></select></p>\n";
			$form .= "<p>New number of votes: <input type=\"text\" name=\"numVotes\" maxlength=\"11\" size=\"5\"/></p>\n";
			$form .= "<p><input type=\"submit\" value=\"Done\" /></p></form></div>\n";
		}
		else if($view =="delete" && $subView == NULL)
		{
			$form ="<div class=\"leftAdmin\">\n";
			$form .= "<h2>Delete a Topic</h2>\n";
			$form .= "<p>Warning: Clicking the Delete button WILL DELETE topic. There will be no further prompts to confirm.</p>\n";
			$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\" name=\"deletetopic\">\n";
			$form .="<input type=\"hidden\" name=\"table\" value=\"trivia_topics\" />\n";
			$form .="<input type=\"hidden\" name=\"view\" value=\"delete\" />\n";
			$form .="<input type=\"hidden\" name=\"subView\" value=\"status\" />\n";
			$form .= "<p>Delete topic: <select name=\"topicID\">\n";
			foreach($v_records as $key => $value)
			{
				$form .="<option value=\"".$value['topicID']."\">".$value['topicName']."</option>\n";
			}
			$form .="</select></p>\n";
			$form .= "<p><input type=\"submit\" value=\"Delete Topic\" /></p></form></div>\n";
			
			$form .="<div class=\"bottomAdmin\">\n";			
			$form .= "<h2>Delete a Question</h2>\n";
			$form .= "<p>Warning: Clicking the Delete button WILL DELETE topic. There will be no further prompts to confirm.</p>\n";
			$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\" name=\"deleteQuestion\">\n";
			$form .="<input type=\"hidden\" name=\"table\" value=\"trivia_questions\" />\n";
			$form .="<input type=\"hidden\" name=\"view\" value=\"delete\" />\n";
			$form .="<input type=\"hidden\" name=\"subView\" value=\"status\" />\n";
			$form .= "<p>Delete Question: <select name=\"triviaQID\">\n";
			foreach($v_questions as $key => $value)
			{
				$form .="<option value=\"".$value['triviaQID']."\">".$value['quizQuestion']."</option>\n";
			}
			$form .="</select></p>\n";
			$form .= "<p><input type=\"submit\" value=\"Delete Question\" /></p></form></div>\n";
			
				$form .="<div class=\"bottomAdmin\" style=\"top:500px;\">\n";			
			$form .= "<h2>Delete an Answer</h2>\n";
			$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\">\n";
			$form .="<input type=\"hidden\" name=\"view\" value=\"delete\" />\n";
			$form .="<input type=\"hidden\" name=\"subView\" value=\"trivia_answers\" />\n";
			$form .= "<p>Delete answers to which question? <select name=\"triviaQID\">\n";
			foreach($v_questions as $key => $value)
			{
				$form .="<option value=\"".$value['triviaQID']."\">".$value['quizQuestion']."</option>\n";
			}
			$form .="</select></p>\n";
			$form .= "<p><input type=\"submit\" value=\"Select Question\" /></p></form></div>\n";
		}
		else if($view == "delete" && $subView =="answers")
		{
			foreach($v_questions as $key => $value)
			{
				if($value['triviaQID'] == $_POST['triviaQID'])
				{
					$question = $value['quizQuestion'];
				}
			}
			$form ="<div class=\"leftAdmin\" style=\"width:700px\">\n";
			$form .= "<h2>Delete an Answer to the Question: $question</h2>\n";
			$form .= "<p>Warning: Clicking the Delete button WILL DELETE topic. There will be no further prompts to confirm.</p>\n";
			$form .= "<form action=\"".$_SERVER['PHP_SELF'] ."\" method=\"post\">\n";
			$form .="<input type=\"hidden\" name=\"table\" value=\"trivia_answers\" />\n";
			$form .="<input type=\"hidden\" name=\"view\" value=\"delete\" />\n";
			$form .="<input type=\"hidden\" name=\"subView\" value=\"status\" />\n";
			$form .= "<p>Delete answer: <select name=\"answerID\">\n";
			foreach($v_answers as $key => $value)
			{
				if($value['triviaQID'] == $_POST['triviaQID'])
				{
					$form .="<option value=\"".$value['answerID']."\">".$value['answerText']."</option>\n";
				}
			}
			$form .="</select></p>\n";
			$form .= "<p><input type=\"submit\" value=\"Delete Answer\" /></p></form></div>\n";
		}
		else if($subView == "status")
		{
			$form ="<div class=\"leftAdmin\">\n";
			$view = $_POST['view'];
			$table = $_POST['table'];
			if(updateSQL($view,$table) =="true")
			{
				$form .= "Request Completed Successfully.";
			} 
			else if (updateSQL($view,$table) == "false")
			{
				$form .= "Sorry there was a problem with your request.";
			}
		}
		return $form;
}
?>