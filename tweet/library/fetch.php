<?php require 'connect.php';?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Twitter API SEARCH</title>
    </head>
    <body>
        <?php
        //print_r($tweets);

        $select = "SELECT * FROM twitter_database ORDER BY since_id DESC";
        if($query_run = mysqli_query($conn, $select) || exit("error")){
            while ($query_row = mysqli_fetch_assoc($query_run)){
                $created_at= $query_row['created_at'];
                $user_id= $query_row['user_id'];
                $screen_name= $query_row['screen_name'];
                $tweet= $query_row['tweet'];
                $retweet= $query_row['retweet'];
                $image_url= $query_row['image_url'];
                $hashtag= $query_row['hashtag'];
                
                echo $created_at, $user_id, $screen_name, $tweet, $retweet, $image_url, $hashtag;
                
            }
        }
        
        ?>
    </body>
</html>