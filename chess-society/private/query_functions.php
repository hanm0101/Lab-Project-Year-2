<?php
	// Members
	function find_all_members() {
		global $db;
		$sql = "SELECT * FROM Members";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}

	function find_members_elo($id){
		global $db;
		$sql = "SELECT * FROM Members WHERE id='".db_escape($db,$id)."'";
		$result = mysqli_query($db,$sql);
		confirm_result_set($result);
		$result = mysqli_fetch_assoc($result)['elo'];
		return $result;
	}

	function get_full_name($id){
		global $db;
		$sql1 = "SELECT * FROM Members WHERE id='".db_escape($db,$id)."'";
		$fname = mysqli_query($db,$sql1);
		confirm_result_set($fname);
		$fname = mysqli_fetch_assoc($fname);
		return $fname['fname']." ".$fname['lname'];
	}

	function find_all_elos(){
		global $db;
		$sql = $db->query("SELECT elo FROM Members");
		if($sql){
			while($row = $sql->fetch_assoc()){
				$result[]=$row['elo'];
			}
		}
		return $result;
		
	}

	function find_elo_history($id){
		global $db;
		$sql = "SELECT * FROM TournamentMembers WHERE elo_after > -1 AND member_id='".db_escape($db,$id)."'";
		$result=mysqli_query($db,$sql);
		confirm_result_set($result);
		return $result;

	}

	function find_all_members_emails(){
		global $db;
		$sql = "SELECT email FROM Members";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}

	function email_to_ID($email){
			global $db;

			$sql = "SELECT id FROM Members ";
			$sql .= "WHERE email='" . db_escape($db, $email) . "'";
			$result = mysqli_query($db, $sql);
			confirm_result_set($result);
			$member = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			return $member;
	}

	function find_member_by_email($email) {
		global $db;
		$sql = "SELECT * FROM Members ";
		$sql .= "WHERE email='" . db_escape($db, $email) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$member = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $member;
	}
	function find_member_by_ID($id) {
		global $db;

		$sql = "SELECT * FROM Members ";
		$sql .= "WHERE id='" . db_escape($db, $id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$member = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $member;
	}

	function find_member_password_by_email($email) {
		global $db;

		if(is_banned($email)) {
			echo "You are banned";
			return false;
		}

		$sql = "SELECT password FROM Members ";
		$sql .= "WHERE email='" . db_escape($db, $email) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$member = mysqli_fetch_assoc($result);
		if ($result != false && mysqli_num_rows($result) > 0) {
			mysqli_free_result($result);
			return $member;
		}
	}

	function member_exists($email) {
		global $db;
		$sql = "SELECT * FROM Members ";
		$sql .= "WHERE email='" . db_escape($db, $email) . "'";
		$result = mysqli_query($db, $sql);

		if ($result && mysqli_num_rows($result) > 0) {
			mysqli_free_result($result);
			return true;
		}
		else false;
	}

	function officer_exists($id) {
		global $db;

		$sql = "SELECT * FROM Officers WHERE member_id=".db_escape($db,$id);
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);

		if ($result  && mysqli_num_rows($result) > 0) {
			mysqli_free_result($result);
			return true;
		}
		else false;
	}

	function officer_member_to_id($id) {
		global $db;

  	$sql = "SELECT * FROM Officers WHERE member_id=".db_escape($db,$id);
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$officer = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $officer['id'];
	}

	function member_pass_correct($email,$password) {
		global $db;
		if(is_banned($email)){
			echo "You are banned";
			return false;
		}
		if(!member_exists($email)) {
			echo "Does not exist";
			return false;
		}
		$sql = "SELECT password FROM Members ";
		$sql .= "WHERE email='" . db_escape($db, $email) . "'";
		$result = mysqli_query($db, $sql);

		if ($result!= false && mysqli_num_rows($result) > 0 && password_verify($password,mysqli_fetch_row($result)[0]) ) {
			mysqli_free_result($result);
			return true;
		}
		else false;
	}
	function insert_member($member) {
		global $db;

		$sql = "INSERT INTO members(email, password, fname, lname, address, phone_no, gender, dob) ";
		$sql .= "VALUES (";
		$sql .= "'".db_escape($db, $member['email'])."',";
		$sql .= "'".db_escape($db, $member['password'])."',";
		$sql .= "'".db_escape($db, $member['fname'])."',";
		$sql .= "'".db_escape($db, $member['lname'])."',";
		$sql .= "'".db_escape($db, $member['address'])."',";
		$sql .= "'".db_escape($db, $member['phone_no'])."',";
		$sql .= "'".db_escape($db, $member['gender'])."',";
		$sql .= "'".db_escape($db, $member['dob'])."'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}

	function update_member($member) {
			global $db;

			foreach($member as $key => $value) {
				echo $value.'</br>';
			}
			$sql = "UPDATE members SET fname = ";
			$sql .= "'".db_escape($db, $member['fname'])."',";
			$sql .= "lname = ";
			$sql .= "'".db_escape($db, $member['lname'])."',";
			$sql .= "address = ";
			$sql .= "'".db_escape($db, $member['address'])."',";
			$sql .= "phone_no = ";
			$sql .= "'".db_escape($db, $member['phone_no'])."',";
			$sql .= "gender = ";
			$sql .= "'".db_escape($db, $member['gender'])."',";
			$sql .= "DoB = ";
			$sql .= "'".db_escape($db, $member['dob'])."'";
			$sql .= "WHERE email = '".db_escape($db, $member['email'])."'";
			$result = mysqli_query($db, $sql);
			if($result) {
			  return true;
			}
			else {
			  echo mysqli_error($db);
			  db_disconnect($db);
			  exit;
			}
	}

	function update_member_password($member) {
			global $db;

			foreach($member as $key => $value) {
				echo $value.'</br>';
			}
			$sql = "UPDATE members SET password = ";
			$sql .= "'".db_escape($db, $member['password'])."'";
			$sql .= "WHERE email = '".db_escape($db, $member['email'])."'";
			$result = mysqli_query($db, $sql);
			if($result) {
			  return true;
			}
			else {
			  echo mysqli_error($db);
			  db_disconnect($db);
			  exit;
			}
	}

	function delete_member($email) {
		global $db;

		$sql = "DELETE FROM members WHERE email = '$email'";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // DELETE failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}

	function delete_member_from_tournament($id){
		global $db;
		$sql = "DELETE FROM TournamentMembers WHERE member_id = $id";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // DELETE failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
	// Officers
	function delete_officer($id) {
		global $db;

		$sql = "DELETE FROM Officers WHERE member_id =$id";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // DELETE failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}

	function find_all_officers() {
		global $db;
		$sql = "SELECT * FROM Officers";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}

	function find_all_officers_as_members() {
		global $db;

		$sql = "SELECT Officers.id as officer_id, Members.id as id, email,lname,fname FROM Officers LEFT JOIN Members ON Officers.member_id=Members.id";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}
	function find_officer_by_id($id) {
		global $db;
		$sql = "SELECT * FROM Officers ";
		$sql .= "WHERE id='" . db_escape($db, $id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$officer = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $officer;
	}

	function make_officer($memberID) {
		global $db;
    $memberID = (string)$memberID;

		$sql = "INSERT INTO Officers(member_id) ";
		$sql.= "VALUES (".db_escape($db,$memberID).")";

		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // INSERT failed

		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}


	// Admins
	function get_admin() {
		global $db;
		$sql = "SELECT * FROM Admins";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}
	// Tournaments
	function find_all_tournaments() {
		global $db;
		$sql = "SELECT * FROM Tournaments";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}
	
	function update_tournament($tour) {
		global $db;



		$sql = "UPDATE Tournaments SET title = ";
		$sql .= "'".db_escape($db, $tour['title'])."',";
		$sql .= "description = ";
		$sql .= "'".db_escape($db, $tour['description'])."',";
		$sql .= "tournament_date = ";
		$sql .= "'".db_escape($db, $tour['tournament_date'])."',";
		$sql .= "deadline = ";
		$sql .= "'".db_escape($db, $tour['deadline'])."'";
		$sql .= "WHERE id = '".db_escape($db, $tour['id'])."'";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
	function find_tournament_by_id($id) {
		global $db;
		$sql = "SELECT * FROM Tournaments ";
		$sql .= "WHERE id='" . db_escape($db, $id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$tournament = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $tournament;
	}
	function getTournamentTitle($id){
		global $db;
		$sql = "SELECT * FROM Tournaments WHERE id='".db_escape($db,$id)."'";
		$result= mysqli_query($db,$sql);
		confirm_result_set($result);
		$title = mysqli_fetch_assoc($result)['title'];
		return $title;
	}

	function insert_tournament($tournament,$officer_id) {
		global $db;
		$sql = "INSERT INTO tournaments(title, description, deadline, tournament_date) ";
		$sql .= "VALUES (";
		$sql .= "'".db_escape($db, $tournament['title'])."',";
		$sql .= "'".db_escape($db, $tournament['description'])."',";
		$sql .= "'".db_escape($db, $tournament['deadline'])."',";
		$sql .= "'".db_escape($db, $tournament['tournament_date'])."'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		if($result) {
			 $last_id = mysqli_insert_id($db);
		return	insert_tournament_organiser($officer_id,$last_id);
		}
		else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}

	function setFinished($id){
		global $db;
		$sql = "UPDATE Tournaments SET finished=1 WHERE id='".db_escape($db,$id)."'";
		$result=mysqli_query($db,$sql);
		if($result){
			return true;
		}
		else{
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function isFinished($id){
		global $db;
		$sql= "SELECT * FROM Tournaments WHERE finished=1 AND id='".db_escape($db,$id)."'";
		$result=mysqli_query($db,$sql);
		
		if(mysqli_num_rows($result)>0) {
		return true;
		}
		else return false;

	}
	// TournamentMembers
	function find_members_of_tournament($tournament_id) {
		global $db;
		$sql = "SELECT * FROM TournamentMembers WHERE tournament_id=".db_escape($db, $tournament_id);
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$members_of_tournament = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $members_of_tournament;
	}
	function find_members_of_tournament_by_row($tournament_id) {
		global $db;

		$sql = "SELECT * FROM TournamentMembers WHERE tournament_id=".db_escape($db, $tournament_id);

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}



	function find_members_of_tournament_detailed($tournament_id){
		global $db;
		$sql = "SELECT * FROM TournamentMembers LEFT JOIN Members ON member_id=id WHERE tournament_id=".db_escape($db, $tournament_id);
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}

	function find_organisers_of_tournament_detailed($tournament_id){
		global $db;
		$sql = "SELECT * FROM TournamentOrganisers JOIN Officers on officer_id= id JOIN Members on member_id=Members.id Where tournament_id=".db_escape($db, $tournament_id);
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}
	function is_in_tournament($memberID,$tournament_id){
		global $db;
		$sql = "SELECT * FROM TournamentMembers JOIN Members on member_id=id  WHERE  member_id=$memberID AND tournament_id=".db_escape($db, $tournament_id);
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		if ($result && mysqli_num_rows($result) > 0) {
     $arr =mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			return true;
		}
		else false;
	}
	function find_tournaments_of_member($member_id) {
		global $db;
		$sql = "SELECT * FROM TournamentMembers ";
		$sql = "WHERE member_id='" . db_escape($db, $member_id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$tournament_of_member = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $tournament_of_member;
	}
	function insert_tournament_member($tournament_member) {
		global $db;
		$sql = "INSERT INTO tournamentmembers(member_id, tournament_id, elo_before, elo_after) ";
		$sql .= "Values('".db_escape($db, $tournament_member['member_id'])."',";
		$sql .= "'".db_escape($db, $tournament_member['tournament_id'])."',";
		$sql .= "'".db_escape($db, $tournament_member['elo_before'])."',";
		$sql .= "'".db_escape($db, $tournament_member['elo_after'])."'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		if($result) {

		  return true;
		}
		else {
		  // INSERT failed

		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}

	function updateElo($p1Elo,$p1ID,$p2Elo,$p2ID,$tournamentID){
		global $db;
		$updateP1 = "UPDATE tournamentMembers SET elo_after='".db_escape($db,$p1Elo)."' WHERE member_id='".db_escape($db,$p1ID)."' AND tournament_id='".db_escape($db,$tournamentID)."'";
		$updateP2 = "UPDATE tournamentMembers SET elo_after='".db_escape($db,$p2Elo)."' WHERE member_id='".db_escape($db,$p2ID)."' AND tournament_id='".db_escape($db,$tournamentID)."'";
		$updateMember1 = "UPDATE Members SET elo='".db_escape($db,$p1Elo)."' WHERE id='".db_escape($db,$p1ID)."'";
		$updateMember2 = "UPDATE Members SET elo='".db_escape($db,$p2Elo)."' WHERE id='".db_escape($db,$p2ID)."'";
		$result = true;
		while($result){
			$result = mysqli_query($db,$updateP1);
			$result = mysqli_query($db,$updateP2);
			$result = mysqli_query($db,$updateMember1);
			$result = mysqli_query($db,$updateMember2);
		break;
		}
		if($result == false){
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
			else return true;

	}


	// TournamentOrganisers
	function find_organisers_of_tournament($tournament_id) {
		global $db;
		$sql = "SELECT * FROM TournamentOrganisers ";
		$sql = "WHERE tournament_id='" . db_escape($db, $tournament_id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$organisers_of_tournament = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $organisers_of_tournament;
	}
	function find_tournaments_of_organiser($officer_id) {
		global $db;
		$sql = "SELECT * FROM TournamentOrganisers ";
		$sql .= "WHERE organiser_id='" . db_escape($db, $officer_id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$tournament_of_organiser = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $tournament_of_organiser;
	}
	function is_organiser($tournament_id,$org_id){
		global $db;
		$sql = "SELECT * FROM TournamentOrganisers ";
		$sql .= "WHERE tournament_id='" . db_escape($db, $tournament_id) . "' and officer_id='".db_escape($db,$org_id)."'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		if ($result && mysqli_num_rows($result) > 0) {
			mysqli_free_result($result);
			return true;
		}
		else false;
	}
	function delete_organiser($tournament_id,$org_id){

			global $db;

			$sql = "DELETE FROM TournamentOrganisers  ";
			$sql .= "WHERE tournament_id='" . db_escape($db, $tournament_id) . "' and officer_id='".db_escape($db,$org_id)."'";
			$result = mysqli_query($db, $sql);
			if($result) {

				return true;
			}
			else {
				// DELETE failed
				echo mysqli_error($db);
				db_disconnect($db);
				exit;
			}

	}


	function insert_tournament_organiser($officer_id,$tournament_id) {
		global $db;
		$officer_id = (int) $officer_id;
		$tournament_id = (int) $tournament_id;
		$sql = "INSERT INTO TournamentOrganisers(officer_id, tournament_id)";
		$sql .= "Values(".db_escape($db, $officer_id).",";
		$sql .= "".db_escape($db, $tournament_id)."";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}

	// News
	function find_all_news() {
		global $db;
		$sql = "SELECT * FROM News";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}
	function find_news_by_id($id) {
		global $db;
		$sql = "SELECT * FROM News ";
		$sql .= "WHERE id='" . db_escape($db, $id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$news = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $news;
	}

	function insert_news($news) {
		global $db;
		$sql = "INSERT INTO news(title, description, expiry_date, officer_id) ";
		$sql .= "Values('".db_escape($db, $news['title'])."',";
		$sql .= "'".db_escape($db, $news['description'])."',";
		$sql .= "'".db_escape($db, $news['expiry_date'])."',";
		$sql .= "'".db_escape($db, $news['officer_id'])."'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}


	function update_news($news) {
		global $db;

		$query = "UPDATE news SET title = ";
		$query .= "'".db_escape($db, $news['title'])."',";
		$query .= "description = ";
		$query .= "'".db_escape($db, $news['description'])."',";
		$query .= "expiry_date = ";
		$query .= "'".db_escape($db, $news['expiry_date'])."'";
		$query .= "WHERE id = '".db_escape($db, $news['id'])."'";
		$result = mysqli_query($db, $query);
		if($result) {
			return true;
		}
		else {
			// INSERT failed
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function delete_news($id) {
	    global $db;

	    $sql = "DELETE FROM news ";
	    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
	    $sql .= "LIMIT 1";

	    $result = mysqli_query($db, $sql);
	    if ($result) {
	        return true;
	    } else {
	        echo mysqli_error($db);
	        db_disconnect($db);
	        exit;
	    }
	}
	// Events
	function find_all_events() {
		global $db;
		$sql = "SELECT * FROM Events ";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}
	function find_event_by_id($id) {
		global $db;
		$sql = "SELECT * FROM Events ";
		$sql .= "WHERE id='" . db_escape($db, $id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$event = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $event;
	}

	function insert_events($event) {
		global $db;
		$sql = "INSERT INTO events(title, description, expiry_date, officer_id) ";
		$sql .= "VALUES('".db_escape($db, $event['title'])."',";
		$sql .= "'".db_escape($db, $event['description'])."',";
		$sql .= "'".db_escape($db, $event['expiry_date'])."',";
		$sql .= "'".db_escape($db, $event['officer_id'])."'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}

	function update_event($event) {
		global $db;

		$query = "UPDATE events SET title = ";
		$query .= "'".db_escape($db, $event['title'])."',";
		$query .= "description = ";
		$query .= "'".db_escape($db, $event['description'])."',";
		$query .= "expiry_date = ";
		$query .= "'".db_escape($db, $event['expiry_date'])."'";
		$query .= "WHERE id = '".db_escape($db, $event['id'])."'";
		$result = mysqli_query($db, $query);
		if($result) {
			return true;
		}
		else {
			// INSERT failed
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}



	function delete_event($id) {
		global $db;
		$sql = "DELETE FROM events WHERE id =$id";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // DELETE failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
	// Matches
	function find_all_matches() {
		global $db;
		$sql = "SELECT * FROM Matches ";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}
	function find_matches_by_id($id) {
		global $db;
		$sql = "SELECT * FROM Matches ";
		$sql .= "WHERE id='" . db_escape($db, $id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$match = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $match;
	}
	function find_matches_by_tournament($tournament_id) {
		global $db;
		$sql = "SELECT * FROM Matches ";
		$sql .= "WHERE tournament_id='" . db_escape($db, $tournament_id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$match = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $match;
	}
	
	function find_matches_by_member($id){
		global $db;
		$sql = "SELECT * FROM Matches ";
		$sql .= "WHERE member1_id='" . db_escape($db, $id) . "'";
		$sql .= "OR member2_id='" . db_escape($db, $id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}

	function find_matches_by_tournament_row($tournament_id) {
		global $db;
		$sql = "SELECT * FROM Matches ";
		$sql .= "WHERE tournament_id='" . db_escape($db, $tournament_id) . "'";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		
		return $result;
	}

	function insert_match($match) {
		global $db;


		$sql = "INSERT INTO matches(tournament_id, member1_id, member2_id, outcome) ";
		$sql .= "VALUES (";
		$sql .= "'".db_escape($db, $match['tournament_id'])."',";
		$sql .= "'".db_escape($db, $match['member1_id'])."',";
		$sql .= "'".db_escape($db, $match['member2_id'])."',";
		$sql .= "'".db_escape($db, $match['outcome'])."'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}

	function insert_final($match) {
		global $db;

		$sql = "INSERT INTO matches(tournament_id, member1_id, member2_id, outcome, final) ";
		$sql .= "VALUES (";
		$sql .= "'".db_escape($db, $match['tournament_id'])."',";
		$sql .= "'".db_escape($db, $match['member1_id'])."',";
		$sql .= "'".db_escape($db, $match['member2_id'])."',";
		$sql .= "'".db_escape($db, $match['outcome'])."',";
		$sql .= "'1'";
		$sql .= ")";
		if($db->query($sql)) {
		  return true;
		}
		else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
	
	function update_match_result($id, $outcome){
		global $db;
		$sql = "UPDATE Matches SET outcome='".db_escape($db,$outcome)."' WHERE id='".db_escape($db,$id)."'";
		$result = mysqli_query($db,$sql);
		if($result) {
			return true;
		  }
		  else {
			// INSERT failed
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		  }
	}

	// Banned
	function find_all_banned_members() {
		global $db;
		$sql = "SELECT * FROM Banned ";
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}
	function insert_banned($email) {
		global $db;
		$sql = "INSERT INTO banned(email) ";
		$sql .= "VALUES('".db_escape($db, $email)."'";
		$sql .= ")";
		$result = mysqli_query($db, $sql);
		if($result) {
		  return true;
		}
		else {
		  // INSERT failed
		  echo mysqli_error($db);
		  db_disconnect($db);
		  exit;
		}
	}
	function is_banned($email) {
		global $db;
		$sql = "SELECT * FROM Banned ";
		$sql .= "WHERE email='" . db_escape($db, $email) . "'";
		$result = mysqli_query($db, $sql);

		if ($result && mysqli_num_rows($result) > 0) {
			mysqli_free_result($result);
			return true;
		}
		else false;
	}

?>
