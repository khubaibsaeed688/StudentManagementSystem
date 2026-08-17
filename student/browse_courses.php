<?php
session_start();
include "../config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
if ($_SESSION['role'] !== 'student') {
  header("Location: ../index.php");
  exit();
}

$sql = "SELECT * FROM `courses`
         JOIN users ON courses.teacherID = users.user_id";
$result = mysqli_query($conn, $sql);

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
                    <h1 class="text-xl text-slate-900 font-bold dark:text-slate-50">Browse Courses</h1>
                </div>
                <div class="flex justify-between pb-4">
                    <div class="flex flex-col gap-1">
                        <!-- Search Box -->
                                    <form role="search" id="searchBox"
                                        class="flex items-center gap-2.5 mt-4 px-3 py-2.5 rounded-md bg-white dark:bg-neutral-800 outline-1 -outline-offset-1 outline-slate-300 dark:outline-neutral-700 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904"
                                            class="size-4 fill-slate-400" aria-hidden="true">
                                            <path
                                                d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z">
                                            </path>
                                        </svg>
                                        <input type="search" placeholder="Search..."
                                            class="text-sm text-slate-900 dark:text-slate-50 w-full outline-none bg-transparent" />
                                    </form>
                    </div>
                    <button type="button"
                        class="h-10 whitespace-nowrap inline-flex items-center gap-2 text-black bg-gray-50 border border-transparent hover:bg-gray-100 focus:ring-4 focus:ring-blue-300 shadow-sm font-medium text-sm px-4 py-1.5 rounded-lg focus:outline-none transition-colors">
                        All Teacher
                    </button>
                </div>
            </header>

         <div class="p-4 ">
            <div class="grid grid-cols-3 gap-4 my-2">
               <?php
               if (mysqli_num_rows($result) > 0) {
               while ($row  = mysqli_fetch_assoc($result)){ ?>
               <div
                  class="w-full max-w-[400px] rounded-xl border border-slate-100 bg-white p-4 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
                  <div class="flex items-center gap-4 border-b border-black/10 pb-6 mb-2 ">
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
                        <h3 class="mt-1 text-xl font-bold text-slate-800">
                           <?php echo $row['courseName']; ?>
                        </h3>
                        
                        <p class="mt-1 text-xs font-medium text-slate-400">
                           <?php echo $row['username']; ?>
                        </p>

                        <p class="mt-2 text-xs font-medium text-slate-400">
                           28 Students
                        </p>
                     </div>

                  </div>
               
                  <!-- Buttons -->
                  <div class="mt-5 flex gap-3">
                      <!-- Edit -->
                      <a href="#"
                          class="flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-100 bg-white py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50">
                          View Details
                      </a>
                      <!-- Students -->
                      <a href="enroll.php?id=<?php echo $row['courseID']; ?>"
                          class="flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-100 bg-violet-600 py-2.5 text-sm font-medium text-slate-100 shadow-sm transition hover:bg-violet-500">
                          Enroll
                      </a>
                  </div>

               </div>
               <?php 
                    }
                }else {
                    echo "0 Result";
                }
                ?>
               
            </div>
         </div>
</body>

</html>