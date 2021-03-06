<?php
include_once("../wpdb-connect.php");
if(current_user_can('edit_others_pages')):
    $tb_request= $wpdb->get_blog_prefix() . 'rm_requests';
    $tb_user = $wpdb->get_blog_prefix() . "rm_users";
    $tb_category_age = $wpdb->get_blog_prefix() . 'rm_category_age';
    $tb_category_weight = $wpdb->get_blog_prefix() . 'rm_category_weight';
    $tb_games = $wpdb->get_blog_prefix() . 'rm_actual_games';

    $limit = strip_tags(stripslashes(trim($_POST['limit'])));
    $offset = strip_tags(stripslashes(trim($_POST['offset'])));
    $game = strip_tags(stripslashes(trim($_POST['game'])));
    $games = implode(',', $_POST['games']);
    $year = esc_sql(strip_tags(stripslashes(trim($_POST['year']))));
    $requests = $wpdb->get_results( "SELECT $tb_request.id, $tb_user.first_name, $tb_user.last_name, $tb_category_age.title, 
    $tb_category_weight.title_w, $tb_games.name, $tb_request.create_date 
    FROM $tb_request 
        JOIN $tb_user 
            ON $tb_request.user_id = $tb_user.id
        JOIN $tb_category_age
            ON $tb_request.age_category = $tb_category_age.id
        JOIN $tb_games
            ON $tb_request.current_competition = $tb_games.id
        LEFT JOIN $tb_category_weight
            ON $tb_request.weight_category = $tb_category_weight.id 
    WHERE $tb_request.year = $year AND $tb_request.current_competition IN ($games)
    ORDER BY $tb_request.create_date DESC
    LIMIT $limit OFFSET $offset");
    $return = json_encode($requests);
    print_r($return);
endif;