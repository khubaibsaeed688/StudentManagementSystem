<?php
session_start();
include "../config/db_connect.php";

$c_id = $_GET['id'];
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    $c_id = $_GET['id'];
    $sql = "DELETE FROM `courses` WHERE courseID = $c_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: my_courses.php");
        exit();
    }else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit();
}
if ($_SESSION['role'] !== 'teacher' && $_SESSION['role'] !== 'admin') {
  header("Location: ../index.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="../assets/script.js"></script>
</head>
<body class="bg-black/50">
<div id="popup-modal" tabindex="-1" class=" overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white border border-slate-200 shadow-xl rounded-xl p-4 md:p-6">

            <a href="my_courses.php" class="absolute top-3 end-2.5 text-slate-500 bg-transparent hover:bg-slate-100 hover:text-slate-900 rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </a>

            <div class="p-4 md:p-5 text-center">

                <svg class="mx-auto mb-4 text-slate-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>

                <h3 class="mb-6 text-slate-700">
                    Are you sure you want to delete this product from your account?
                </h3>

                <div class="flex items-center space-x-4 justify-center">

                    <a href="delete_course.php?id=<?php echo $c_id; ?>&confirm=yes"
                        class="text-white bg-red-600 box-border border rounded border-transparent hover:bg-red-700 focus:ring-4 focus:ring-red-200 shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                        Yes, I'm sure
                    </a>

                    <a href="my_courses.php"
                        class="text-slate-700 bg-slate-100 box-border border rounded border-slate-300 hover:bg-slate-200 hover:text-slate-900 focus:ring-4 focus:ring-slate-200 shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                        No, cancel
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>