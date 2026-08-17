<?php
session_start();
include "../config/db_connect.php";

$t_id = $_SESSION['user_id'];

$sql = "SELECT * FROM `courses` WHERE teacherID = $t_id ";
$result = mysqli_query($conn, $sql);

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

<body>

    <div class="w-full flex ">

        <?php include "sidebar.php"; ?>

        <main class="ml-[18%] w-[82%] min-h-screen">

            <!-- header -->
            <header
                class="flex py-2 sticky top-0 w-full bg-white  px-6 dark:border-neutral-700 dark:bg-neutral-900 min-h-[68px] z-20"
                aria-label="header">
                <div class="flex flex-wrap items-center gap-4 w-full">
                    <h1 class="text-xl text-slate-900 font-bold dark:text-slate-50">My Courses</h1>
                </div>
                <a href="add_course.php"
                    class="w-40 h-10 whitespace-nowrap mt-6 inline-flex items-center gap-2 text-white bg-green-600 border border-transparent hover:bg-green-700 focus:ring-4 focus:ring-blue-300 shadow-sm font-medium text-sm px-4 py-1.5 rounded-lg focus:outline-none transition-colors">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>

                    Add Course
                </a>
            </header>
                <!-- edit_course.php?id=<?php echo $row['courseID'] ?> -->
                <!-- delete_course.php?id=<?php echo $row['courseID'] ?> -->
            <div class="p-4">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <?php
                     if (mysqli_num_rows($result) > 0) {
                     while ($row = mysqli_fetch_assoc($result)){ ?>
                    <div
                        class="w-full max-w-[400px] rounded-xl border border-slate-100 bg-white p-4 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">

                        <!-- Course Info -->
                        <div class="flex items-center gap-4">

                            <!-- Course Icon -->
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl bg-orange-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 3h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6M9 11h6M9 15h3" />
                                </svg>
                            </div>

                            <!-- Course Details -->
                            <div>
                                <h3 class="text-base font-semibold text-slate-800">
                                    <?php echo $row['courseName']; ?>
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    30 Students
                                </p>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="mt-5 flex gap-3">

                            <!-- Edit -->
                            <a href="edit_course.php?id=<?php echo $row['courseID'] ?>"
                                class="flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-100 bg-white py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 3.5a2.121 2.121 0 0 1 3 3L8 18l-4 1 1-4L16.5 3.5Z" />
                                </svg>

                                Edit
                            </a>

                            <!-- Students -->
                            <a href="#"
                                class="flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-100 bg-white py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>

                                Students
                            </a>

                        </div>

                    </div>
                    <?php } ?>
                </div>
                <?php }else {echo '
                <div class="w-250 h-100 flex items-center justify-center">
                    <div class="max-w-md flex flex-col mx-auto text-center">
                      <svg
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="mx-auto size-20 text-gray-400"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"
                        />
                      </svg>
                    
                      <h2 class="mt-6 text-2xl font-bold text-gray-900">No Course Found</h2>
                    
                      <p class="mt-4 text-pretty text-gray-700">
                        Get started by creating your first item. It only takes a few seconds.
                      </p>
                    
                      <a href = "add_course.php"
                        type="button"
                        class="mt-6 block w-full rounded-lg bg-indigo-600 px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-indigo-700"
                      >
                        Add Course
                      </a>
                    </div>
                </div>';
                } ?>
            </div>
        </main> 
    </div>       

</body>

</html>