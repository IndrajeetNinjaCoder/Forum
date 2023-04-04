<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>iDiscuss - Coding Forum</title>
</head>

<body>

    <?php include "partials/_header.php"; ?>
    <?php include "partials/_dbconnect.php" ?>

    <!-- Search Results  -->
    <div class="container my-4">
        <h1 class="py-2">Search Results for <em>"<?php echo $_GET['search']; ?>"</em></h1>

        <div class="searchResults container" style="min-height: 76vh;">

            <?php
            $search_query = $_GET["search"];
            $sql = "SELECT * FROM `threads` WHERE MATCH(`thread_title`, `thread_desc`) AGAINST('$search_query');";
            $result = mysqli_query($conn, $sql);

            // Display the search Results 
            $num_rows = mysqli_num_rows($result);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['thread_id'];
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];

                echo '
            <div class="result">
                <h3><a href="thread.php?threadid=' . $id . '" class="text-dark">' . $title . '</a></h3>
                <p>' . $desc . '</p>
            </div>';
            }

            if($num_rows == 0){
                echo '<h3>No Results Found.</h3>';
            }
            ?>


        </div>

    </div>







    <?php include "partials/_footer.php"; ?>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>