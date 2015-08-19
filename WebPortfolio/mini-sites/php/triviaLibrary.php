<?php
/*
	Purpose: to read the total number of votes for a question
	Input: String, Path to the array where the votes are stored
	Output: Integer, number of total votes
	*/
	function readVotes($qPath)
	{
		$results = "";
		$v_records = mySQLDoQuery("select * from trivia_answers where triviaQID = $qPath");
		foreach($v_records as $key => $value)
		{
			$tempResults = $value['numVotes'];
			$results += $tempResults;
		}
		return $results;
	}
	
		/*
	Purpose: To display the categories of questions for a quiz
	Input: Location of the categories (String)
	Output: String, HTML for the categories
	*/
	function displayCategories($header,$status)
	{
		$results = "<p style=\"font-size:14px; margin-top:5px;\">$header</p><p>";
		$v_records = mySQLDoQuery("select * from trivia_topics where status = '$status'");
		foreach($v_records as $key => $value)
		{
			if($status == "closed")
			{
				$results .= "<a href=\"index.php?page=pastQuizzes&amp;category=topic&amp;chosen=".$value['topicID']."\">".$value['topicName']."</a><br />";
			}
			else {
				$results .= "<a href=\"index.php?category=topic&amp;chosen=".$value['topicID']."\">".$value['topicName']."</a><br />";
			}
			$results .= "<div style=\"margin-left:10px;\"><span style=\"font-style:italic;\">Description:</span> ".$value['topicDescription']."</div><br />";
		}
		$results .="</p>";
		return $results;
	}
	/*
	Purpose: To determine if the topics/questions in the category that the user chose are inactive & display them accordingly
	Input: Index of the category that the user chose (String, to be converted to an Int), Path to the Topic (String)
	Output: String of HTML to display the topics
	*/
	function displayTopics($chosenCategory,$goto)
	{
		settype($chosenCategory, "int");
		if($goto == "results")
		{
			$result = "Select a Previous Question Topic: <br /><ul>";
		}
		else {
			$result = "Select a Question Topic: <br /><ul>";
		}
		$v_records = mySQLDoQuery("select * from trivia_questions where topicID=$chosenCategory");
			foreach($v_records as $key => $value)
			{
				if($value['active'] == 1 && $goto != "results")
				{
					$result .= "<li><a href=\"index.php?index=".$value['triviaQID']."&amp;category=question\">".$value['description']."</a><img src=\"images/unlocked.gif\" class=\"locking\" alt=\"unlocked\" /></li>";
				}
				else if($value['active'] == 0)
				{
					$result .= "<li><a href=\"index.php?index=".$value['triviaQID']."&amp;category=results&amp;referred=topic\">".$value['description']."</a><img src=\"images/locked.gif\" class=\"locking\" alt=\"locked\" /></li>";
				}
				else if($value['active'] == 1 && $goto == "results")
				{
					$result .= "<li><a href=\"index.php?index=".$value['triviaQID']."&amp;category=results&amp;referred=topic\">".$value['description']."</a><img src=\"images/unlocked.gif\" class=\"locking\" alt=\"unlocked\" /></li>";
				}
			}
		$result .= "</ul>";
		return $result;
	}
	
	/*
	Purpose: To display the question that the user selected and display the choices of that question to allow the user to vote
	Input: 	Index to the question topic that the user chose (Int), Index for the category that the topics and questions are in (Int),
			Path of the question (String)
	Output: String of HTML including a form to allow the user to vote for an answer
	*/
	function displayQuestion($indexNum)
	{
		$query = "select * from trivia_questions q join trivia_answers a on(a.triviaQID = q.triviaQID) where a.triviaQID=$indexNum";
		//echo($query);
		$v_records = mySQLDoQuery($query);
		//echo(showObject($v_records));
		$questionString = "<p>Your Trivia Question: </p>".$v_records[0]['quizQuestion'];
		$questionString .= "<form action='index.php' method='post'>";
		$questionString .= "<input type='hidden' name='category' value='results'></input>";
		$questionString .= "<input type='hidden' name='index' value='$indexNum'></input><ol>";
		foreach($v_records as $key => $value)
		{
			$questionString .= "<li><input type=\"radio\" name=\"choices\" value=\"".$value['answerID']."\" />";
			$questionString .= $value['answerText']."</li>";
		}
		$questionString .= "</ol><br/><input type='submit' id='button' value='Submit Answer'></input></form>";
		
		return $questionString;
	}
	/*
	Purpose: To display the results for a question after a user votes, or display the results of the question if it is inactive
	Input: 	Answer/Index of the question that the user chose (Int), Path of the question that the user chose (String, 
			Page that brough the user to this "page" (String)
	Output: String of HTML to display the results
	*/
	function displayResults($answerChoice,$indexNum,$referrer)
	{
		$v_records = mySQLDoQuery("select * from trivia_questions q join trivia_answers a on(a.triviaQID = q.triviaQID) where a.triviaQID=$indexNum");
		
		$results = "Question: ".$v_records[0]['quizQuestion']."<br /><ol>";
		foreach($v_records as $key => $value)
		{
			$answerValid = $value['correct'];
			$imagePath = "images/$answerValid.png";
			$totalVotes = readVotes($indexNum);
			$percent = (($value['numVotes']/$totalVotes)*100);
			settype($percent,"int");
			if($value['answerID'] == $answerChoice && $referrer != "topic")
			{
				$results.= "<li id=\"choice\">";
			}
			else
			{
				$results .= "<li>";
			}
			$results .= $value['answerText']."<img src=\"$imagePath\" class=\"valid\" alt=\"Valid Answer\" />";
			$results .= "<div class=\"votes\">".$percent."%</div></li>";
		}
		if($referrer !="topic")
		{
			$results .= "</ol>You chose: ";
			foreach ($v_records as $key => $value)
			{
				if($value['answerID'] == $answerChoice)
				{
					$results.= $value['answerText'];
				}
			}
		}
		return $results;
	}
	
?>