<?php
session_start();
include_once("controllermovielist.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Create MovieList</title>
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
                            <a href="showmovielist.php" class="text-orange-200 hover:text-orange-300 px-3 py-5 text-sm font-medium">Movie</a>
                            <a href="createmovie.php" class="text-orange-300 border-b-4 border-orange-300 px-3 py-5 text-sm font-medium" aria-current="page">Add Movie</a>
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
                <a href="showmovielist.php" class="text-orange-200 hover:bg-gray-700 hover:text-orange-300 block rounded-md px-3 py-2 text-base font-medium">Movie</a>
                <a href="createmovie.php" class="bg-gray-900 text-orange-300 block rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Add Movie</a>
                <a href="time.php" class="text-orange-200 hover:bg-gray-700 hover:text-orange-300 block rounded-md px-3 py-2 text-base font-medium">Showtime</a>
                <a href="create_time.php" class="text-orange-200 hover:bg-gray-700 hover:text-orange-300 block rounded-md px-3 py-2 text-base font-medium">Add Showtime</a>
            </div>
        </div>
    </nav>


    <form action="createmovie.php" method="POST" enctype="multipart/form-data" class="p-6">
        <div class="space-y-12 mt-20">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="lg:text-3xl text-2xl font-bold leading-7 text-gray-900">CREATE MOVIE LIST</h2>
                <p class="mt-1 text-base leading-6 text-gray-600">Fill out the details below to add a new movie to the list.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                        <div class="mt-2">
                            <input type="text" name="title" id="title" class="block w-full rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                        <div class="mt-2">
                            <textarea name="description" id="description" rows="3" class="block w-full rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="genre" class="block text-sm font-medium leading-6 text-gray-900">Genre</label>
                        <div class="mt-2">
                            <input type="text" name="genre" id="genre" class="block w-full rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="duration" class="block text-sm font-medium leading-6 text-gray-900">Duration</label>
                        <div class="mt-2">
                            <input type="text" name="duration" id="duration" class="block w-full rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="release_date" class="block text-sm font-medium leading-6 text-gray-900">Release Date</label>
                        <div class="mt-2">
                            <input type="date" name="release_date" id="release_date" class="block w-full rounded-md border-0 py-1.5 pl-2 pr-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="age" class="block text-sm font-medium leading-6 text-gray-900">Rating Age</label>
                        <div class="mt-2">
                            <input type="text" name="age" id="age" class="block w-full rounded-md border-0 py-1.5 pl-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input class="form-control" type="file" id="image" name="image">
                    </div>

                    <div class="col-span-full">
                        <label for="times" class="block text-sm font-medium leading-6 text-gray-900">Times</label>
                        <div class="mt-2">
                            <?php
                            $conn = my_connectDB();
                            if ($conn != NULL) {
                                $result = mysqli_query($conn, "SELECT time_id, times FROM times");
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<div>';
                                        echo '<input type="checkbox" id="time_' . $row['time_id'] . '" name="times[]" value="' . $row['time_id'] . '">';
                                        echo '<label for="time_' . $row['time_id'] . '">' . $row['times'] . '</label>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "Error fetching times: " . mysqli_error($conn);
                                }
                                mysqli_close($conn);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="submit" name="submit" class="rounded-md bg-orange-300 px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-orange-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
        </div>
    </form>

    <br>
    <?php
    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
        $result = createMovielist();
        echo '<script>window.location.href = "showmovielist.php";</script>';
    }
    ?>
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