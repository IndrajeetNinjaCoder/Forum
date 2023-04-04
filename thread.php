<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- custome CSS  -->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        .card-body {
            background-color: gainsboro;
        }
    </style>
    <title>iDiscuss - Coding Forum</title>
</head>

<body>

    <?php include "partials/_header.php"; ?>
    <?php include "partials/_dbconnect.php" ?>
    <?php

    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `category` WHERE `category_id`=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $cat_name = $row['category_name'];
        $cat_desc = $row['category_description'];
    }
    ?>

    <?php

    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    // echo $method;
    if ($method == 'POST') {

        // Insert comment into db 
        $comment = $_POST['comment'];
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);

        $user_id = $_SESSION['sno'];

        $sql = "INSERT INTO `comments` VALUES (NULL, '$comment', '$id', '$user_id', current_timestamp());";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Comment has been successfully added!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        // if($result){
        //     echo "Thread successfully added.";
        // }
        // else{
        //     echo "Thread not added.";
        // }

    }

    ?>


    <div class="container my-4">

        <?php


        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {

            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_user_id = $row['thread_user_id'];


            $sql2 = "SELECT * FROM `users` WHERE `sno` = $thread_user_id";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['user_email'];

            echo '<div class="card align-items-center my-4" style=" display: block; margin: auto;">
            <div class="card-body">
                <h1 class="card-title">' . $title . '</h1>
                <p class="card-text"><?php echo $cat_desc; ?></p>
                <hr>
                <p class="card-text">' . $desc . '</p>
                <p>Posted by: <em>' . $posted_by . '</em></p>
            </div>
        </div>


    </div>';
        }
        ?>

        <div class="container my-4">
            <h1 class="my-4">Post a Comment</h1>

            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

                echo '<div class="container">
                
                <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Type your Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Post Comment</button>
                </form>
            </div>';
            } else {
                echo '<p class="lead">You are not Loggedin. Please login to start a Discussion.</p>';
            }

            ?>
            <div class="container">
                <h1 class="my-4">Discusion</h1>

                <?php

                $id = $_GET['threadid'];
                $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
                $result = mysqli_query($conn, $sql);
                $noResult = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    $noResult = false;
                    $id = $row['comment_id'];
                    $content = $row['comment_content'];
                    $comment_time = $row['comment_time'];
                    $comment_by = $row['comment_by'];

                    $sql2 = "SELECT * FROM `users` WHERE `sno` = $comment_by";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);



                    echo '
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="img/user-default-2.png" width="55px" alt="default user">
                        </div>

                        <div class="flex-grow-1 ms-3">
                            <strong>' . $row2['user_email'] . ' at ' . $comment_time . '</strong>
                            <p>' . $content . '</p>
                        </div>
                    </div>';
                }

                if ($noResult) {
                    echo '<p class="lead">No Comments found! Be the first person to comment.</p>';
                }

                ?>


            </div>





            <!--       
        <div class="d-flex">
            <div class="flex-shrink-0">
                <img src="img/user-default-2.png" width="55px" alt="default user">
            </div>

            <div class="flex-grow-1 ms-3">
                <h5>unable to install pyaudio in windows</h5>
                <p>This is some content from a media component. You can replace this with any content and adjust it as needed.</p>
            </div>
        </div>
-->


        </div>









        <?php include "partials/_footer.php"; ?>


        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>