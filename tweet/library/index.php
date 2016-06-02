<?php
include "twitteroauth/twitteroauth.php";
require 'connect.php';

$consumer_key = "Your_Consumer_Key";
$consumer_secret = "Your_Consumer_Key_Secret";
$access_token = "Your_Access_Token";
$access_token_secret = "Your_Access_Token_Secret";

$twitter = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$select = "SELECT max(since_id) AS sincemax FROM twitter_database";
$query_run = mysqli_query($conn, $select);
$query_row = mysqli_fetch_assoc($query_run);
$since_id = $query_row['sincemax'];
if ($tweets = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q=The_specified_hash_tag&result_type=recent&count=1&since_id=' . $since_id)) {
   // print_r($tweets)
    foreach ($tweets->statuses as $key => $tweet) {
        $created_at = $tweet->created_at;
        $user_id = $tweet->user->id;
        $screen_name = $tweet->user->screen_name;
        $text = $tweet->text;
        $since_id = $tweet->id;
        $retweet = $tweet->retweet_count;
        if (isset($tweet->entities->media)) {
            foreach ($tweet->entities->media as $key => $new)
                $image_url = $new->media_url;
        } else {
            $image_url = 'not available';
        }
        if (isset($tweet->entities->hashtags)) {
            foreach ($tweet->entities->hashtags as $key => $new)
                $hashtag = $new->text;
                $arr = array();            
                $arr= $hashtag;
        }
        echo $arr;
        $sql = "INSERT INTO twitter_database (created_at, user_id, screen_name, tweet, retweet, image_url, hashtag, since_id) VALUES ('$created_at' ,'$user_id','$screen_name','$text','$retweet','$image_url','$hashtag','$since_id')";
        mysqli_query($conn, $sql);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <link href="../css/theme.css" rel="stylesheet" type="text/css"/>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="../js/bootstrap.js" type="text/javascript"></script>
        <title>Twitter API SEARCH</title>
    </head>
    <body>
        <div class="page-header">
            <h1>Twitter Data</h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Created At</th>
                            <th>Username</th>
                            <th>Tweet</th>
                            <th>Retweet Count</th>
                            <th>Image Used</th>
                            <th>Hashtags</th>
                        </tr>
                    </thead>
                    <?php
                    $select = "SELECT * FROM twitter_database ORDER BY id DESC";
                    $query_run = mysqli_query($conn, $select);
                    while ($query_row = mysqli_fetch_array($query_run)) {
                        $id = $query_row['id'];
                        $created_at = $query_row['created_at'];
                        $user_id = $query_row['user_id'];
                        $screen_name = $query_row['screen_name'];
                        $tweet = $query_row['tweet'];
                        $retweet = $query_row['retweet'];
                        $image_url = $query_row['image_url'];
                        $hashtag = $query_row['hashtag'];

                        echo "<tbody>
              <tr>
                <td>" . $id . "</td>
                <td>" . $created_at . "</td>
                <td>" . $screen_name . "</td>
                <td>" . $tweet . "</td>
                <td>" . $retweet . "</td>
                <td>" . $image_url . "</td>
                <td>" . $hashtag . "</td>
              </tr>";
                    }
                    ?>


                    </body>
                    </html>
