<?php
session_start();
include_once("controllermovielist.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>MOVIE DETAIL</title>
</head>

<body>

    <nav class="bg-slate-800 fixed top-0 w-full">
        <div class="mx-auto max-w-6xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button id="mobile-menu-button" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" id="icon-menu" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg class="hidden h-6 w-6" id="icon-close" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-between sm:-mr-32">
                    <div class="flex flex-shrink-0 items-center sm:-ml-32">
                        <p class="font-bold text-2xl text-white">MovieZone</p>
                        <!-- <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company"> -->
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4 px-5">
                            <a href="showmovielist.php" class="text-orange-300 border-b-4 border-orange-300 px-3 py-5 text-sm font-medium" aria-current="page">Movie</a>
                            <a href="createmovie.php" class="text-orange-200 hover:text-orange-300 px-3 py-5 text-sm font-medium">Add Movie</a>
                            <a href="time.php" class="text-orange-200 hover:text-orange-300 px-3 py-5 text-sm font-medium">Showtime</a>
                            <a href="create_time.php" class="text-orange-200 hover:text-orange-300 px-3 py-5 text-sm font-medium">Add Showtime</a>
                            <div class="py-5 text-sm font-medium">
                                <p class="text-white font-bold text-l">Hello <?= htmlspecialchars($_SESSION["username"]) ?>!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="hidden sm:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <a href="showmovielist.php" class="bg-gray-900 text-orange-300 block rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Movie</a>
                <a href="createmovie.php" class="text-orange-200 hover:bg-gray-700 hover:text-orange-300 block rounded-md px-3 py-2 text-base font-medium">Add Movie</a>
                <a href="time.php" class="text-orange-200 hover:bg-gray-700 hover:text-orange-300 block rounded-md px-3 py-2 text-base font-medium">Showtime</a>
                <a href="create_time.php" class="text-orange-200 hover:bg-gray-700 hover:text-orange-300 block rounded-md px-3 py-2 text-base font-medium">Add Showtime</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="lg:text-3xl text-2xl font-semibold leading-7 text-gray-900 mx-4">Movie Detail</h1>
        <?php
        $movieID = $_GET["movieID"];
        if ($movieID != "") {
            $movie = getMovieWithID($movieID);
            $tempDate = date_create($movie["release_date"]);
            $showDate = date_format($tempDate, "d F Y");

            $showtimes = getDetail($movieID);
        ?>

            <div class="mx-5 my-5">
                <div class="row">
                    <div class="col-sm my-8 mx-8">
                        <a href="showmovielist.php" class="btn btn-primary text-orange-400 hover:underline hover:text-orange-500">
                            < Back to Movie List</a><br><br>
                                <div class="flex flex-col">
                                    <h2 class="lg:text-3xl text-2xl font-bold leading-7 text-gray-900 mb-5"><?= $movie["title"] ?></h2>
                                    <img class="h-full w-48 mb-4" src="<?= $movie["image"] ?>" alt="">

                                    <p class="mt-1 text-base leading-6 text-gray-600"><?= $movie["description"] ?></p>
                                </div>
                                <div>
                                    <p class="card-text">Genre: <?= $movie["genre"] ?></p>
                                    <p class="card-text">Duration: <?= $movie["duration"] ?> minutes</p>
                                    <p class="card-text">Release date: <?= $showDate ?></p><br><br>
                                    <?php if (!empty($showtimes)) : ?>
                                        <h3>Showtimes</h3>
                                        <ul>
                                            <?php foreach ($showtimes as $showtime) : ?>
                                                <li><?= $showtime["times"] ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <p>No showtimes available yet.</p>
                                    <?php endif; ?>
                                    <p class="card-text">Rating Age: <?= $showtime["age"] ?></p>

                                    <a href="updatemovie.php?movieID=<?= $movie["movie_id"] ?>">
                                        <button type="button" class="mt-5 text-slate-700 bg-orange-200 hover:bg-orange-300
                    font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-orange-200 
                    dark:hover:bg-orange-300 focus:outline-none dark:focus:ring-blue-800">Update Detail</button>
                                    </a>
                                    <a href="deletemovie.php?movieID=<?= $movie["movie_id"] ?>">
                                        <button type="button" class="mt-5 text-slate-700 bg-red-300 hover:bg-red-400
                    font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-300 
                    dark:hover:bg-red-400 focus:outline-none dark:focus:ring-blue-800">Delete Detail</button>
                                    </a>
                                </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

    </div>
    <footer class="bg-slate-800 py-5">
        <p class="text-center text-white">©copyright by RachelleJesslyn</p>
    </footer>
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            var iconMenu = document.getElementById('icon-menu');
            var iconClose = document.getElementById('icon-close');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                iconMenu.classList.add('hidden');
                iconClose.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                iconMenu.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }
        });

        document.addEventListener('click', function(event) {
            var userMenuButton = document.getElementById('user-menu-button');
            var userMenu = document.getElementById('user-menu');
            if (userMenuButton && userMenu) {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            }
        });
    </script>
</body>

</html>