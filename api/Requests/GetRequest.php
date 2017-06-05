<?php
include_once("../wpdb-connect.php");
$requestID = strip_tags(stripslashes(trim($_POST['id'])));
$tb_request = $wpdb->get_blog_prefix() . 'rm_requests';
$tb_user = $wpdb->get_blog_prefix() . "rm_users";
$tb_category_age = $wpdb->get_blog_prefix() . 'rm_category_age';
$tb_category_weight = $wpdb->get_blog_prefix() . 'rm_category_weight';
$tb_games = $wpdb->get_blog_prefix() . 'rm_actual_games';
$tb_games_before = $wpdb->get_blog_prefix() . 'rm_before_games';
$tb_regions = $wpdb->get_blog_prefix() . 'rm_regions';
$tb_coaches = $wpdb->get_blog_prefix().'rm_coaches';
$request = $wpdb->get_results("SELECT $tb_request.id, $tb_user.first_name, $tb_user.last_name, $tb_user.middle_name, $tb_user.birth_date,
$tb_regions.region, $tb_user.region AS region_id, $tb_category_age.title, $tb_request.age_category AS age_category_id, $tb_request.weight_category AS weight_category_id,
$tb_category_weight.title_w, $tb_games.name AS current_competition,
$tb_request.current_competition AS current_competition_id, $tb_games_before.name AS pre_competition, $tb_request.pre_competition AS pre_competition_id,
$tb_request.disciplines AS results, $tb_request.doping, $tb_request.visa, $tb_request.coaches AS coaches
FROM $tb_request
    JOIN $tb_user
        ON $tb_request.user_id = $tb_user.id
    JOIN $tb_regions
        ON $tb_user.region = $tb_regions.id
    JOIN $tb_category_age
        ON $tb_request.age_category = $tb_category_age.id
    JOIN $tb_category_weight
        ON $tb_request.weight_category = $tb_category_weight.id
    JOIN $tb_games
        ON $tb_request.current_competition = $tb_games.id       
    JOIN $tb_games_before
        ON $tb_request.pre_competition = $tb_games_before.id
WHERE $tb_request.id = $requestID");
$request[0]->doping = unserialize($request[0]->doping);
$request[0]->results = unserialize($request[0]->results);
$request[0]->visa = unserialize($request[0]->visa);
$request[0]->coaches = unserialize($request[0]->coaches);
if($request[0]->coaches){
    $coaches = $request[0]->coaches;
    $request[0]->coach_details = array();
    foreach($coaches as $coach){
        $coachFullName = $wpdb->get_results("SELECT id, first_name, last_name, middle_name FROM $tb_coaches WHERE id = $coach[0]");
        array_push($request[0]->coach_details, $coachFullName[0]);
    }
}else{
    $request[0]->coaches = 'false';
}
$return = json_encode($request);
print_r($return);
