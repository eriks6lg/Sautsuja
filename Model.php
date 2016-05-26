<?php
$host = 'localhost';
$username = 'test';
$password = 't3st3r123';
$db = 'test';
$link = mysqli_connect($host, $username, $password, $db);

mysqli_query($link, 'SET CHARACTER SET UTF8');
function model_page_load($page) {
    global $link;
    $query = '';
    switch ($page) {
        case 'home':
            $query = "SELECT Id, Username, Sauts, Points, Added FROM `esolg__sautsuja__sautsud` ORDER BY Added DESC";
            break;
        case 'toptoday':
            $query = "SELECT Id, Username, Sauts, Points, Added FROM `esolg__sautsuja__sautsud` WHERE Added>CURDATE() ORDER BY Points DESC";
            break;
        case 'topalltime':
            $query = "SELECT Id, Username, Sauts, Points, Added FROM `esolg__sautsuja__sautsud` ORDER BY Points DESC";
            break;
    }

    $result = mysqli_query($link, $query);

    $answer = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $answer[] = $row;
    }

    return $answer;
}

function model_sauts_add($sauts) {
    global $link;
    $query = 'INSERT INTO esolg__sautsuja__sautsud (Username, Sauts) VALUES (?, ?)';
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $_SESSION['user'], $sauts);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function model_user_add($username, $password) {
    global $link;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = 'INSERT INTO esolg__sautsuja__kasutajad (Username, Password) VALUES (?, ?)';
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $hash);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function model_user_check($username) {
    global $link;
    $query = 'SELECT Password FROM `esolg__sautsuja__kasutajad` WHERE Username=?';
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc((mysqli_stmt_get_result($stmt)))["Password"];

}

function model_user_exists($username) {
    global $link;
    $query = 'SELECT Username FROM `esolg__sautsuja__kasutajad` WHERE Username=?';
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc((mysqli_stmt_get_result($stmt)))["Username"];


}

function model_points_increment($index) {
    global $link;
    $query = 'UPDATE `esolg__sautsuja__sautsud` SET Points = Points+1 WHERE Id=?';
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'i', $index);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function model_highestsauts_add($username, $points, $sauts) {

    global $link;
    $query = 'UPDATE `esolg__sautsuja__kasutajad` SET HighestNUM = ?, HighestTEXT = ? WHERE Username = ?';
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, 'iss', $points, $sauts, $username);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function model_maxpoints_get($username) {
    global $link;

    $query = 'SELECT MAX(Points) FROM `esolg__sautsuja__sautsud` WHERE Username=?';

    $stmt = mysqli_prepare($link, $query);

    mysqli_stmt_bind_param($stmt, 's', $username);

    mysqli_stmt_execute($stmt);

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))["MAX(Points)"];
}

function model_numberofposts_get($username) {
    global $link;

    $query = 'SELECT Posts FROM `esolg__sautsuja__kasutajad` WHERE Username=?';

    $stmt = mysqli_prepare($link, $query);

    mysqli_stmt_bind_param($stmt, 's', $username);

    mysqli_stmt_execute($stmt);

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['Posts'];

}
function model_numberofposts_increment($username) {
    global $link;

    $query = 'UPDATE `esolg__sautsuja__kasutajad` SET Posts = Posts + 1 WHERE Username=?';

    $stmt = mysqli_prepare($link, $query);

    mysqli_stmt_bind_param($stmt, 's', $username);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
function model_highestsauts_get($username) {
    global $link;

    $maxpoints = model_maxpoints_get($username);

    $query='SELECT Sauts FROM `esolg__sautsuja__sautsud` WHERE Username=? AND Points=? LIMIT 1';

    $stmt = mysqli_prepare($link, $query);

    mysqli_stmt_bind_param($stmt, 'si', $username, $maxpoints);

    mysqli_stmt_execute($stmt);

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['Sauts'];
}

function model_numberofpoints_get($index) {
    global $link;

    $query = 'SELECT Points FROM `esolg__sautsuja__sautsud` WHERE Id=?';

    $stmt = mysqli_prepare($link, $query);

    mysqli_stmt_bind_param($stmt, 'i', $index);

    mysqli_stmt_execute($stmt);

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['Points'];
}

function model_username_get($index) {
    global $link;

    $query = 'SELECT Username FROM `esolg__sautsuja__sautsud` WHERE Id=?';

    $stmt = mysqli_prepare($link, $query);

    mysqli_stmt_bind_param($stmt, 'i', $index);

    mysqli_stmt_execute($stmt);

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['Username'];
}