<?php
session_start();
include "../config/db_connect.php";

$s_id = $_SESSION['user_id'];
$sql = "SELECT * FROM `enrollments` 
JOIN courses ON enrollments.courseID = courses.courseID
JOIN users ON courses.teacherID = users.user_id
WHERE enrollments.studentID = $s_id";

$result = mysqli_query($conn, $sql);

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

   <div class="w-full flex ">

      <?php include "sidebar.php"; ?>

      <main class="ml-[18%] w-[82%] min-h-screen">

          <!-- header -->
            <header
                class=" py-6 sticky top-0 w-full bg-white  px-6 dark:border-neutral-700 dark:bg-neutral-900 min-h-[68px] z-20"
                aria-label="header">
                <div class="flex flex-wrap items-center gap-4 w-full">
                    <h1 class="text-xl text-slate-900 font-bold dark:text-slate-50">My Courses</h1>
                </div>
            </header>

         <div class="p-4 ">
            <div class="flex flex-col gap-4 my-2">
                <?php
                     if (mysqli_num_rows($result) > 0) {
                     while ($row = mysqli_fetch_assoc($result)){ ?>
               <div
                  class="w-full flex justify-between rounded-xl border border-slate-300 bg-white p-4 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
                  <div class="w-[30%] flex items-center gap-4">
                     <!-- Icon -->
                     <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-fuchsia-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-fuchsia-500" fill="none"
                           viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                           <rect x="5" y="5" width="14" height="14" rx="2" />
                           <path stroke-linecap="round" d="M9 9h6M9 12h6M9 15h3" />

                        </svg>
                     </div>

                     <!-- Content -->
                     <div>
                        <h3 class="whitespace-nowrap mt-1 text-xl font-bold text-slate-800">
                           <?php echo ucfirst($row['courseName']); ?>
                        </h3>
                        
                        <p class="mt-1 text-xs font-medium text-slate-400">
                           <?php echo ucfirst($row['username']); ?>
                        </p>
                     </div>

                  </div>

                  <div class="w-50 flex flex-col  gap-3">
                    <p class="text-sm font-medium text-slate-600">Progress</p>
                    <div class="w-full bg-green-300 rounded-full h-1.5">
                        <div class="bg-green-700 h-1.5 rounded-full" style="width: 45%"></div>
                    </div>
                  </div>

                  <div class="flex gap-2 mr-3">
                    <a href="#"
                        class="h-10 w-25 flex flex-1 items-center justify-center gap-2 rounded-2xl border border-violet-600 bg-white py-2.5 text-sm font-medium text-violet-600 shadow-sm transition hover:bg-slate-100">
                        View
                    </a>
                    <a href="unenroll.php?id=<?php echo $row['enrollmentID']; ?>"
                       class="h-10 w-25 flex flex-1 items-center justify-center gap-2 rounded-2xl border border-red-600 bg-white py-2.5 text-sm font-medium text-red-600 shadow-sm transition hover:text-red-700">
                       unenroll
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
                    
                      <a href = "browse_courses.php"
                        type="button"
                        class="mt-6 block w-full rounded-lg bg-indigo-600 px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-indigo-700"
                      >
                        Enroll Course
                      </a>
                    </div>
                </div>';
                } ?>
         </div>
</body>

</html>