<?php

function controller_page_load($page) {

    $array = array();
    $data = model_page_load($page);

    foreach ($data as $index => $sauts) {
        $counter = 0;
        if ($counter < 5) {
            global $array;
            $array[] = $sauts["Username"];
            $array[] = $sauts["Sauts"];
            $array[] = $sauts["Points"];
            $array[] = substr($sauts["Added"], 5, 2) . "." .
                substr($sauts["Added"], 8, 2) . "." .
                substr($sauts["Added"], 2, 2) . " " .
                substr($sauts["Added"], 11, 5);
            $array[] = $sauts['Id'];
            global $counter;
            $counter += 1;
        }
    }

    return $array;
}

function controller_data_load($page) {
    controller_page_load($page);
    return true;
}

function controller_user_add($username, $password1, $password2){

    if ($username == '' || $username.length > 16 || $password1 != $password2 || $password1 == '' || $password1.length > 16
        || password2.length > 16 || $password2 == '') {
        return false;
    } elseif (model_user_exists($username) != NULL) {
        return false;
    } else {
        return model_user_add($username, $password1);
    }
}

function controller_sauts_add($sauts){
    if($sauts.length > 34) {
        return false;
    } else {
        model_numberofposts_increment($_SESSION['user']);
        return model_sauts_add($sauts);
    }
}

function controller_user_check($username, $password){

    if ($username == '' || $password == ''){
        return false;
    } else if ((password_verify($password, model_user_check($username)))) {
        return true;
    } else {
        return false;
    }
}

function controller_points_increment($index){
    return model_points_increment($index);
}

function controller_numberofposts_get($username){
    return model_numberofposts_get($username);
}

function controller_numberofposts_increment($username){
    return model_numberofposts_increment($username);
}

function controller_maxpoints_get($username){
    return model_maxpoints_get($username);
}

function controller_highestsauts_get($username){
    return model_highestsauts_get($username);
}

function controller_highestsauts_check($username, $index){
    $points = model_numberofpoints_get($index);
    if ($points >= model_maxpoints_get($username)) {
        model_highestsauts_add($username, $points, model_highestsauts_get($username));
    }
    return true;
}