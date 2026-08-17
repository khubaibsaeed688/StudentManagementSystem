<?php
session_start();
include "../config/db_connect.php";

$sql = "SELECT * FROM `courses`
JOIN users ON courses.teacherID = users.user_id";
$result = mysqli_query($conn, $sql);

if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit();
}
if ($_SESSION['role'] !== 'admin') {
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
                    <h1 class="text-xl text-slate-900 font-bold dark:text-slate-50">Manage Courses</h1>
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
                        class="h-10 whitespace-nowrap inline-flex items-center gap-2 text-white bg-blue-600 border border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-sm font-medium text-sm px-4 py-1.5 rounded-lg focus:outline-none transition-colors">
            
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
            
                        Add Course
                    </button>
                </div>
            </header>

           <!-- Table -->
      <div class="min-w-full px-6 py-4">
        <div
          class="border border-slate-200 rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] overflow-x-auto [&::-webkit-scrollbar]:h-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-scrollbar-track [&::-webkit-scrollbar-thumb]:bg-scrollbar-thumb">
          <table class="min-w-full divide-y divide-slate-100">
            <thead>
              <tr>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">#</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Course Title</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Teacher</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Students</th>
                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
              <?php
              $s_no = 1; 
              if (mysqli_num_rows($result) > 0) {
              while ($row  = mysqli_fetch_assoc($result)){ ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $s_no; ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $row['courseName']; ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $row['username']; ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo "20" ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                  <a href="#"
                    class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-[#BB4D00]-focus disabled:opacity-50 disabled:pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </a>
                  <a href="#"
                    class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-amber-500 hover:text-amber-700 focus:outline-hidden focus:text-[#BB4D00]-focus disabled:opacity-50 disabled:pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                  </a>
                  <a href="#"
                    class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg text-red-600 hover:text-red-800 focus:outline-hidden focus:text-[#BB4D00]-focus disabled:opacity-50 disabled:pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"/>
                    </svg>
                  </a>
                </td>
              </tr>
            </tbody>
          <?php $s_no = $s_no + 1;
              }
          }else {
              echo "0 Result";
          }
          ?>
          </table>
        </div>
      </div>
      <!-- End Table -->

    </main>

    </div>

</body>

</html>