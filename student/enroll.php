<?php
session_start();
include "../config/db_connect.php";

$courseID = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentID = $_SESSION['user_id'];
    $courseID = $_POST['courseID'];
    
    $sql = "INSERT INTO enrollments (studentID, courseID)
            VALUES ($studentID, $courseID)";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: my_courses.php?success=enrolled");
        exit();
    }else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
if ($_SESSION['role'] !== 'student') {
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
<body>
    <div id="modalOverlay"
    class="fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)]">

    <div role="dialog"
        aria-modal="true"
        aria-labelledby="modal-title"
        tabindex="-1"
        class="w-full max-w-md bg-white border border-slate-100 shadow-lg rounded-lg relative max-h-[95vh] overflow-y-auto outline-none p-4 md:p-6 dark:bg-neutral-800 dark:border-neutral-700">

        <!-- Close -->
        <a href="browse_courses.php"
            id="closeModal"
            aria-label="Close modal"
            class="flex items-center absolute top-6 right-6 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="size-3 cursor-pointer fill-slate-500 hover:fill-red-600 dark:fill-slate-400 dark:hover:fill-red-500"
                aria-hidden="true"
                viewBox="0 0 329.269 329">

                <path
                    d="M194.8 164.77 323.013 36.555c8.343-8.34 8.343-21.825 0-30.164-8.34-8.34-21.825-8.34-30.164 0L164.633 134.605 36.422 6.391c-8.344-8.34-21.824-8.34-30.164 0-8.344 8.34-8.344 21.824 0 30.164l128.21 128.215L6.259 292.984c-8.344 8.34-8.344 21.825 0 30.164a21.27 21.27 0 0 0 15.082 6.25c5.46 0 10.922-2.09 15.082-6.25l128.21-128.214 128.216 128.214a21.27 21.27 0 0 0 15.082 6.25c8.343-8.34 8.343-21.824 0-30.164zm0 0" />
            </svg>
        </a>

        <!-- Content -->
        <div>
            <h3 id="modal-title"
                class="text-slate-900 text-base font-semibold dark:text-slate-50">
                Enroll in this course?
            </h3>

            <p class="text-slate-600 text-sm mt-3 leading-relaxed dark:text-slate-400">
                Are you sure you want to enroll in this course?
                Once enrolled, the course will be added to your enrolled courses.
            </p>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 mt-6">

            <form action="enroll.php?id=<?php echo $courseID; ?>" method="POST">
                <input type="hidden" name="courseID"
                       value="<?php echo $courseID; ?>">
                <button type="submit"
                    id="confirmEnroll"
                    class="px-3.5 py-2 text-white text-sm font-semibold rounded-md cursor-pointer bg-blue-600 border border-blue-600 transition-colors hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                    Yes, Enroll
                </button>
            </form>

            <a href="browse_courses.php"
                id="cancelBtn"
                class="px-3.5 py-2 text-slate-900 text-sm font-semibold rounded-md cursor-pointer bg-white border border-slate-300 transition-colors hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 dark:text-slate-50 dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:border-neutral-600">
                No, Cancel
            </a>

        </div>
    </div>
</div>
</body>
</html>