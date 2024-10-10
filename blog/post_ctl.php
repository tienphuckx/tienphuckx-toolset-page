<?php

require "sys_const.php";

require "connect_db.php";

require "response_msg.php";



function get_newest_post($num_post, $index)
{

    $conn = get_db_connection();

    if ($conn->connect_error) {

        return DB_CONNECTION_ERROR;

    }
    $post_array = [];
    $sql_select_posts = "

        SELECT id, title, short_intro, created_date, post_content_id, user_id 

        FROM tbl_posts 

        WHERE status = 1 

        ORDER BY created_date DESC 

        LIMIT ?, ?";



    if ($stmt = $conn->prepare($sql_select_posts)) {

        $offset = $index * $num_post;

        $stmt->bind_param("ii", $offset, $num_post);

        $stmt->execute();

        $result = $stmt->get_result();



        $post_ids = [];



        while ($row = $result->fetch_assoc()) {

            $post_id = $row['id'];

            $post_ids[] = $post_id;



            $post_array[$post_id] = [

                'id' => $row['id'],

                'title' => $row['title'],

                'short_intro' => $row['short_intro'],

                'created_date' => $row['created_date'],

                'post_content_id' => $row['post_content_id'],

                'user_id' => $row['user_id'],

                'tags' => []

            ];

        }

        $stmt->close();



        if (!empty($post_ids)) {

            fetch_tags_for_posts($conn, $post_array, $post_ids);

        }



    } else {

        $conn->close();

        return QUERY_PREPARE_ERROR;

    }



    $conn->close();



    return array_values($post_array);

}





function fetch_tags_for_posts($conn, &$post_array, $post_ids)
{



    $placeholders = implode(',', array_fill(0, count($post_ids), '?'));



    $sql_select_tags = "

        SELECT t.tag_name, pt.post_id

        FROM tbl_tags t

        LEFT JOIN tbl_post_tag pt ON t.id = pt.tag_id

        WHERE pt.post_id IN ($placeholders)";



    if ($stmt_tags = $conn->prepare($sql_select_tags)) {



        $stmt_tags->bind_param(str_repeat('i', count($post_ids)), ...$post_ids);

        $stmt_tags->execute();



        $result_tags = $stmt_tags->get_result();



        while ($row = $result_tags->fetch_assoc()) {

            $post_id = $row['post_id'];

            $post_array[$post_id]['tags'][] = $row['tag_name'];

        }



        $stmt_tags->close();

    }

}



function fetch_tags()
{
    $conn = get_db_connection();

    if ($conn->connect_error) {
        return DB_CONNECTION_ERROR;
    }

    $tags_array = [];

    // SQL query to fetch all tags
    $sql_fetch = "SELECT t.tag_name FROM tbl_tags t";

    if ($stmt_tags = $conn->prepare($sql_fetch)) {
        $stmt_tags->execute();
        $result = $stmt_tags->get_result();

        // Fetch and store the tag names in an array
        while ($row = $result->fetch_assoc()) {
            $tags_array[] = $row['tag_name'];
        }

        $stmt_tags->close();
    }

    $conn->close();
    
    return $tags_array;
}










