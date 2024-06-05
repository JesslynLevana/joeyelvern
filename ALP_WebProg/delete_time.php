<?php
session_start();
include_once("controllermovielist.php");

// Handle delete request
if (isset($_GET['deleteID'])) {
    $deleteID = $_GET['deleteID'];
    if (deleteTime($deleteID)) {
        header("Location: time.php?message=Time deleted successfully");
        exit;
    } else {
        echo "<p>Failed to delete the time.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="javascript.js"></script>
</head>

<body>
    <nav class="bg-slate-800 fixed top-0 w-full">
        <div class="mx-auto max-w-6xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
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
                            <a href="showmovielist.php" class="text-orange-200 hover:text-orange-300 px-3 py-5 text-sm font-medium">Movie</a>
                            <a href="createmovie.php" class="text-orange-200 hover:text-orange-300 px-3 py-5 text-sm font-medium">Add Movie</a>
                            <a href="time.php" class="text-orange-300 border-b-4 border-orange-300 px-3 py-5 text-sm font-medium" aria-current="page">Showtime</a>
                            <a href="create_time.php" class="text-orange-200 hover:text-orange-300 px-3 py-5 text-sm font-medium">Add Showtime</a>
                            <div class="py-5 text-sm font-medium">
                                <p class="text-white font-bold text-l">Hello <?= htmlspecialchars($_SESSION["username"]) ?>!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden sm:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <a href="showmovielist.php" class="text-orange-200 hover:bg-gray-700 hover:text-orange-300 block px-3 py-2 rounded-md text-base font-medium">Movie</a>
                <a href="createmovie.php" class="text-orange-200 hover:bg-gray-700 hover:text-orange-300 block px-3 py-2 rounded-md text-base font-medium">Add Movie</a>
                <a href="time.php" class="bg-gray-900 text-orange-300 block rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Showtime</a>
                <a href="create_time.php" class="text-orange-200 hover:bg-gray-700 hover:text-orange-300 block px-3 py-2 rounded-md text-base font-medium">Add Showtime</a>
            </div>
        </div>
    </nav>
    <main>
        <div class="container mt-20">

            <?php
            if (isset($_GET["timeID"])) {
                $timeID = $_GET["timeID"];
                $times = getTimeWithID($timeID);
                if ($times) {
            ?>
                    <ul class="mb-5 p-5 border border-gray-200 rounded-lg">
                        <li class="font-semibold text-2xl">Showtime: <br><?= htmlspecialchars($times["times"]) ?></li>
                        <p>Are you sure want to delete this showtime?</p><br>
                        <a href="delete_time.php?deleteID=<?= $timeID ?>">
                            <button type="button" class="text-slate-700 bg-red-300 hover:bg-red-400 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-400 dark:hover:bg-red-500 focus:outline-none dark:focus:ring-blue-800">Delete</button>
                        </a>
                    </ul>
                <?php
                } else {
                    echo "<p>No showtime found.</p>";
                }
            } else {
                $result = readTime();
                foreach ($result as $barisdata) {
                ?>
                    <div class="mx-24 my-4 border-2 border-gray-400 rounded-lg">
                        <div class="row">
                            <div class="col-sm my-8 mx-8">
                                <h2 class="lg:text-3xl text-2xl font-semibold leading-7 text-gray-900"><?= htmlspecialchars($barisdata["times"]) ?></h2>
                                <a href="delete_time.php?deleteID=<?= $barisdata["time_id"] ?>">
                                    <button type="button" class="text-slate-700 bg-red-300 hover:bg-red-400 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-400 dark:hover:bg-red-500 focus:outline-none dark:focus:ring-blue-800">Delete</button>
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </main>
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