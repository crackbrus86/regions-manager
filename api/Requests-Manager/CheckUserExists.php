<?php
    include("../wpdb-connect.php");
    $tb_verify = $wpdb->get_blog_prefix()."rm_verify";
    $userId = strip_tags(stripslashes(trim($_POST["userId"])));
    $code = strip_tags(stripslashes(trim($_POST["code"])));

    $sql = $wpdb->prepare("SELECT id FROM $tb_verify WHERE user_id = %d AND code = %d", $userId, $code);
    $match = $wpdb->get_row($sql);

    $remove = $wpdb->prepare("DELETE FROM $tb_verify WHERE user_id = %d", $userId);
    $wpdb->query($remove);

    $visa = new stdClass();
    $visa->hasVisa = "false";
    $visa->type = "0";
    $visa->term = null;

    if($match){
        $tb_users = $wpdb->get_blog_prefix()."rm_users";
        $getUser = $wpdb->prepare("SELECT  id, region, last_name_pass, first_name_pass, serial_number_pass, number_pass, 
        expiration_date_pass, individual_number, phone, email, photo_national_pass_id, 
        photo_international_pass_id, accreditation_photo_id FROM $tb_users WHERE id = %d", $userId);
        $user = $wpdb->get_row($getUser);
        $user->visa = $visa;
        $return = json_encode($user);
        echo $return;        
    }else{
        $tb_regions = $wpdb->get_blog_prefix()."rm_regions";
        $regionId = $wpdb->get_row("SELECT id FROM $tb_regions LIMIT 1");
        $user = new stdClass();
        $user->id = null;
        $user->region = $regionId->id;
        $user->last_name_pass = "";
        $user->first_name_pass = "";
        $user->serial_number_pass = "";
        $user->number_pass = "";
        $user->expiration_date_pass = null;
        $user->individual_number = "";
        $user->phone = "";
        $user->email = "";
        $user->photo_national_pass_id = "";
        $user->photo_international_pass_id = "";
        $user->accreditation_photo_id = "";
        $user->visa = $visa;
        $return = json_encode($user);
        echo $return; 
    }