<?php
function my_connectDB()
{
    $host = "localhost";
    $user = "root";
    $pwd  = "";
    $db   = "webprog_alp";

    $conn = mysqli_connect($host, $user, $pwd, $db) or die("Error Connect to Database");

    // kembalikan hasil koneksi ke database (mysqli_connect)
    return $conn;
}

// function untuk close connection
function my_closeDB($conn)
{
    mysqli_close($conn);
}


function readMovielist()
{
    $allData = array();
    $conn = my_connectDB(); //buka koneksi krn mau connect ke database

    // pengecekan apakah koneksinya berhasil
    if ($conn != NULL) {
        $sql_query = "SELECT * FROM `movie`";

        // melakukan koneksi ke database, ambil data dari database, ditampung di $result
        $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

        // num_rows itu jumlah row yang ada di dlm $result
        // num_rows itu function yg dipanggil untuk dijalankan atas variable result
        if ($result->num_rows > 0) {

            // fetch_assoc akan ambil data dari array yg dikirim di dlm $result satu persatu, disimpan didlm $row, looping
            while ($row = $result->fetch_assoc()) {
                // simpan data dari database ke dalam array $row yg isinya kolom guestbook_id dari tabel
                $data["id"] = $row["movie_id"];
                $data["title"] = $row["title"];
                $data["description"] = $row["description"];
                $data["genre"] = $row["genre"];
                $data["duration"] = $row["duration"];
                $data["release_date"] = $row["release_date"];
                $data["image"] = $row["image"];

                // sumpan $data ke dalam $allData
                array_push($allData, $data);
            }
        }
    }
    my_closeDB($conn);
    return $allData;
}

function getMovieWithID($id)
{
    $result = NULL;
    $conn = my_connectDB();
    $sql = "SELECT * FROM `movie` WHERE movie.movie_id = movie_id AND movie_id=" . $id;
    $allData = mysqli_query($conn, $sql);

    if ($allData != NULL) {
        $result = $allData->fetch_assoc();
    }
    my_closeDB($conn);
    return $result;
}

function getMovieWithIDForUpdate($id)
{
    $conn = my_connectDB();
    $sql = "SELECT movie.*, showtimes.age, times.times 
            FROM movie
            INNER JOIN showtimes ON movie.movie_id = showtimes.movie_id
            INNER JOIN times ON showtimes.time_id = times.time_id
            WHERE movie.movie_id = $id";

    $result = mysqli_query($conn, $sql);
    $movieData = array();

    if ($result != NULL && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (empty($movieData)) {
                $movieData = array(
                    "movie_id" => $row["movie_id"],
                    "title" => $row["title"],
                    "description" => $row["description"],
                    "genre" => $row["genre"],
                    "duration" => $row["duration"],
                    "release_date" => $row["release_date"],
                    "image" => $row["image"],
                    "age" => $row["age"],
                    "showtimes" => $row["times"]
                );
            }
        }

    }

    my_closeDB($conn);
    return $movieData;
}

function createMovielist()
{
    $title = $_POST["title"];
    $description = $_POST["description"];
    $genre = $_POST["genre"];
    $duration = $_POST["duration"];
    $release_date = $_POST["release_date"];
    $times = isset($_POST['times']) ? $_POST['times'] : [];
    $age = $_POST["age"];
    $conn = my_connectDB();

    // Upload the image and get the path
    $image = uploadImage('image/', $_FILES["image"]);

    // Ensure the image upload was successful before proceeding
    if ($image != 1) {
        die($image);  // Handle the error (you can display the error message)
    }

    $imagePath = 'image/' . basename($_FILES["image"]["name"]);

    if ($conn != NULL) {
        // Insert movie into the movie table
        $sql_query_movie = "INSERT INTO `movie` (title, description, genre, duration, release_date, image) VALUES ('$title', '$description', '$genre', '$duration', '$release_date', '$imagePath')";
        $result = mysqli_query($conn, $sql_query_movie) or die(mysqli_error($conn));

        // Get the last inserted movie ID
        $movie_id = mysqli_insert_id($conn);

        // Insert times and age into the showtimes table
        foreach ($times as $time_id) {
            $sql_query_showtimes = "INSERT INTO `showtimes` (movie_id, time_id, age) VALUES ('$movie_id', '$time_id', '$age')";
            mysqli_query($conn, $sql_query_showtimes) or die(mysqli_error($conn));
        }

        return $result;
    }
}


function updateMovie($updatedID, $title, $description, $genre, $duration, $release_date, $image_location, $age)
{
    $conn = my_connectDB();
    
    // Update 'movie' table
    if ($image_location == "") {
        $sql = "UPDATE `movie` SET `title` = ?, 
                                  `description` = ?, 
                                  `genre` = ?, 
                                  `duration` = ?, 
                                  `release_date` = ?
                                WHERE `movie`.`movie_id` = ?";
    } else {
        $sql = "UPDATE `movie` SET `title` = ?, 
                                  `description` = ?, 
                                  `genre` = ?, 
                                  `duration` = ?, 
                                  `release_date` = ?,
                                  `image` = ? 
                                WHERE `movie`.`movie_id` = ?";
    }

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters without image_location
    if ($image_location == "") {
        mysqli_stmt_bind_param($stmt, "sssssi", $title, $description, $genre, $duration, $release_date, $updatedID);
    } else {
        // Bind parameters with image_location
        mysqli_stmt_bind_param($stmt, "ssssssi", $title, $description, $genre, $duration, $release_date, $image_location, $updatedID);
    }

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Update 'age' in 'showtimes' table
    $sql_showtimes = "UPDATE `showtimes` SET `age` = ? WHERE `movie_id` = ?";
    $stmt_showtimes = mysqli_prepare($conn, $sql_showtimes);
    mysqli_stmt_bind_param($stmt_showtimes, "si", $age, $updatedID);
    mysqli_stmt_execute($stmt_showtimes);
    mysqli_stmt_close($stmt_showtimes);

    // Close the connection
    my_closeDB($conn);

    return $result;
}




function getDetail($movieID)
{
    $conn = my_connectDB();
    $sql_query = "SELECT *
    FROM
        movie
    INNER JOIN
        showtimes ON movie.movie_id = showtimes.movie_id
    INNER JOIN
        times ON showtimes.time_id = times.time_id
    WHERE movie.movie_id = '" . $movieID . "'";
    $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));
    my_closeDB($conn);
    return $result;
}



function uploadImage($foldername, $photoFile)
{
    $target_dir = $foldername . "/";
    $target_file = $target_dir . basename($photoFile["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        return "<script>alert('Sorry, file already exists.')</script>";
    }

    // Check file size
    if ($photoFile["size"] > 500000) {
        $uploadOk = 0;
        return "<script>alert('Sorry, your file is too large.')</script>";
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
        return "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($photoFile["tmp_name"], $target_file)) {
            return 1;
        } else {
            return "<script>alert('Sorry, there was an error uploading your file.')</script>";
        }
    }
}


function deleteMovie($deleteID)
{
    $conn = my_connectDB();

    $sql1 = "DELETE FROM showtimes WHERE `showtimes`.`movie_id` = $deleteID";
    $sql2 = "DELETE FROM movie WHERE `movie`.`movie_id` = $deleteID";
    $result = mysqli_query($conn, $sql1);
    $result2 =  mysqli_query($conn, $sql2);
    my_closeDB($conn);
    return $result;
}



function createTime()
{
    $times = $_POST["showtime"];
    $conn = my_connectDB();

    if ($conn != null) {
        $sql_query = "INSERT INTO `times` (times) VALUES('$times')";
        $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));
        return $result;
    }
}



function readTime()
{
    $allData = array();
    $conn = my_connectDB();
    if ($conn != null) {
        $sql_query = "SELECT * FROM `times`";
        $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // simpan data dari database ke dalam array
                $data['id'] = $row["time_id"];
                $data['times'] = $row["times"];
                array_push($allData, $data);
            }
        }
    }
    return $allData;
}

function getTimeWithID($id)
{
    $result = null;
    $conn = my_connectDB();
    $sql = "SELECT * FROM times WHERE time_id=" . $id;
    $allData = mysqli_query($conn, $sql);

    if ($allData != null && $allData->num_rows > 0) {
        $result = $allData->fetch_assoc();
    }
    my_closeDB($conn);
    return $result;
}


function updateTime($updatedID, $times)
{

    if ($updatedID != "" && $times != "") {
        $conn = my_connectDB();
        $sql_query = "UPDATE `times` SET `times` = '$times' WHERE `times`.`time_id` = $updatedID;";
        $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

        my_closeDB($conn);
        return $result;
    }
}

function getShowtimeDetail($timeID)
{
    $conn = my_connectDB();
    $sql_query = "SELECT *
    FROM
        times
    INNER JOIN
        showtimes ON movie.movie_id = showtimes.movie_id
    INNER JOIN
        times ON showtimes.time_id = times.time_id
    WHERE times.time_id = '" . $timeID . "'";
    $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));
    my_closeDB($conn);
    return $result;
}


function deleteTime($deleteID){
    $conn = my_connectDB();
    $sql1 = "DELETE FROM showtimes WHERE `showtimes`.`time_id` = $deleteID";
    $sql2 = "DELETE FROM times WHERE `times`.`time_id` = $deleteID";
    $result = mysqli_query($conn, $sql1);
    $result2 =  mysqli_query($conn, $sql2);
    my_closeDB($conn);
    return $result;
}
