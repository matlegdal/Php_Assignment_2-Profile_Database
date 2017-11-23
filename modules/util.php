<?php

function flash() {
	if ( isset($_SESSION['error']) ) {
	    $flash = '<div class="alert alert-danger">'.$_SESSION['error']."</div>\n";
	    unset($_SESSION['error']);
	    return $flash;
	}
	if ( isset($_SESSION['success']) ) {
	    $flash = '<div class="alert alert-success">'.$_SESSION['success']."</div>\n";
	    unset($_SESSION['success']);
	    return $flash;
	}
}

function load_profile($pdo, $profile_id, $secured=true) {
    if ($secured === true) {
        $query = $pdo->prepare("SELECT * FROM profiles WHERE profile_id = :profile_id AND user_id = :user_id");
        $query->execute(array(
            ':profile_id' => $_REQUEST['profile_id'],
            ':user_id' => $_SESSION['user_id']
        ));
        $profile = $query->fetch(PDO::FETCH_ASSOC);
    } else {
        $query = $pdo->prepare("SELECT * FROM profiles WHERE profile_id = :profile_id");
        $query->execute(array(':profile_id' => $profile_id));
        $profile = $query->fetch(PDO::FETCH_ASSOC);
    }

    if ($profile === false) {
        return false;
    }

    return $profile;
}

function load_positions($pdo, $profile_id) {
    $query = $pdo->prepare("SELECT * FROM positions WHERE profile_id = :profile_id");
    $query->execute(array(':profile_id' => $profile_id));
    $positions = $query->fetchAll(PDO::FETCH_ASSOC);

    return $positions;
}

// TODO: load educations


function insert_positions($pdo, $profile_id){
    try {
        $rank = 1;
        for ($i=1; $i < 11; $i++) {
            if (!isset($_POST['year' . $i])) continue;
            if (!isset($_POST['desc' . $i])) continue;
            $query = $pdo->prepare("INSERT INTO positions (profile_id, rank, year, description) VALUES(:profile_id, :rank, :year, :description)");
            $query->execute(array(
                ':profile_id' => $profile_id,
                ':rank' => $rank,
                'year' => $_POST['year' . $i],
                ':description' => $_POST['desc' . $i]
            ));
            $rank++;
        }
    } catch (Exception $e) {
            return $e;
        }
    return true;
}

// TODO: insert education

function validate_profile() {
	if (strlen($_POST['first_name'])<1 || strlen($_POST['last_name'])<1 || strlen($_POST['email'])<1 || strlen($_POST['headline'])<1 || strlen($_POST['summary'])<1) {
		return "All fields are required";
	}

	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		return 'Please enter a valid email address.';
	}

	return True;
}

function validate_pos() {
	for ($i=1; $i < 11; $i++) { 
		if (!isset($_POST['year'.$i])) continue;
		if (!isset($_POST['desc'.$i])) continue;
		if (strlen($_POST['year'.$i])<1 || strlen($_POST['desc'.$i])<1) {
			return "All fields in position are required";
		}
		if (!is_numeric($_POST['year'.$i])) {
			return "Year must be numeric";
		}
		return True;
	}
	
}

// TODO: validate education




