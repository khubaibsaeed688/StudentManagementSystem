<?php
session_start();
include "../config/db_connect.php";

$t_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseName = $_POST['courseName'];
    $teacherID = $_POST['teacherID'];
    $creditHour = $_POST['creditHour'];

        $sql = "INSERT INTO `courses`(`courseName`, `teacherID`, `creditHour`) 
                VALUES ('$courseName', '$teacherID', '$creditHour')";
            
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
if ($_SESSION['role'] !== 'teacher') {
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

<div class="hs-overlay size-full fixed top-0 inset-s-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none">
  <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-100 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center">
    <div class="w-full flex flex-col bg-white border border-slate-200 shadow-xl rounded-xl pointer-events-auto">
      <div class="flex justify-between items-center py-3 px-4 border-b border-slate-200 ">
        <h3 id="hs-scale-animation-modal-label" class="font-semibold text-foreground">
          Add Course
        </h3>
        <a href="my_courses.php" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full bg-white border border-surface-line text-surface-foreground hover:bg-slate-100 focus:outline-hidden focus:bg-surface-focus disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" data-hs-overlay="#hs-scale-animation-modal">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </a>
      </div>
      <div class="p-4 overflow-y-auto">
        <form class="space-y-4 md:space-y-6" action="add_course.php" method="post">
            <div>
                <label for="courseName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course Name </label>
                <input type="text" name="courseName" id="courseName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="course name" required="">
            </div>
            <div>
                <label for="teacherID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teacher ID</label>
                <select value="<?php echo $t_id; ?>" name="teacherID" id="teacherID" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="<?php echo $t_id; ?>" selected><?php echo $username; ?></option>                
                </select>
            </div>
            <div>
                <label for="creditHour" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Credit Hour</label>
                <input type="number" name="creditHour" id="creditHour" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="credit hour" required="">
            </div>
            <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-[#93c5fd] dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                </div>
                <div class="ml-3 text-sm">
                  <label for="terms" class="font-light text-gray-500 dark:text-gray-300">I accept the <a class="font-medium text-[#2563eb] hover:underline dark:text-primary-500" href="#">Terms and Conditions</a></label>
                </div>
            </div>
            <button type="submit" class="w-full text-white bg-[#2563eb] hover:bg-[#1d4ed8] focus:ring-4 focus:outline-none focus:ring-[#93c5fd] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Add Course</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>