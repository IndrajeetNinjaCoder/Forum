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

    $id = $_GET['catid'];
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
        // Insert thread into db 
        $th_title = $_POST['title'];
        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);

        $th_desc = $_POST['desc'];
        $th_desc = str_replace("<", "&lt;", $th_desc);
        $commth_descent = str_replace(">", "&gt;", $th_desc);

        $user_id = $_SESSION['sno'];
        $sql = "INSERT INTO `threads` VALUES (NULL, '$th_title', '$th_desc', '$id', '$user_id', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your thread has been successfully added! Please wait for community to respond.
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

        <div class="card align-items-center my-4" style=" display: block; margin: auto;">
            <div class="card-body bg-secondary">
                <h1 class="card-title">Welcome to <?php echo $cat_name; ?> Forum</h1>
                <p class="card-text"><?php echo $cat_desc; ?></p>
                <hr>
                <p class="card-text">This is a Forum to Spread out Knowledge with each other.
                    No Spam / Advertising / Self-promote in the forums.
                    Do not post copyright-infringing material.
                    Do not post “offensive” posts, links or images.
                    Do not cross post questions.
                    Do not PM users asking for help.
                    Remain respectful of other members at all times.
                </p>
                <a href="#" class="btn btn-success">Browse</a>
            </div>
        </div>



    </div>

    <div class="container my-4">
        <h1 class="my-4">Ask a Quistions</h1>
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '<div class="container">
                

                <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Problem title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="title">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Elaborate your consern</label>
                        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>';
        } else {
            echo '<p class="lead">You are not Loggedin. Please login to start a Discussion.</p>';
        }
        ?>



        <h1 class="my-4">Browse Quistions</h1>
        <?php

        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;

        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];

            $sql2 = "SELECT * FROM `users` WHERE `sno` = $thread_user_id";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);


            echo '
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img src="img/user-default-2.png" width="55px" alt="default user">
                    </div>

                    <div class="flex-grow-1 ms-3">
                        <strong>'. $row2['user_email'] .' at ' . $thread_time . '</strong>
                        <h5><a href="thread.php?threadid=' . $id . '">' . $title . '</a></h5>
                        <p>' . $desc . '</p>
                    </div>
            </div>';
        }
        // echo var_dump($noResult);
        if ($noResult) {
            echo '<p class="lead"><b>Be the first person to ask a question.</b> </p>';
        }

        ?>

    </div>




    <?php include "partials/_footer.php"; ?>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>