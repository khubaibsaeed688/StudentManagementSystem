<?php
session_start();
include "../config/db_connect.php";

$user_id = $_GET['id'];

$sql = "SELECT  `user_id`, `username`, `email`, `password`, `phone`, `role` 
        FROM `users` WHERE user_id = '$user_id' ";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE `users` 
                SET `username` = '$username',
                `email` = '$email',
                `password` = '$hashed_password',
                `phone` = '$phone',
                `role` = '$role' 
                WHERE `users`.`user_id` = $user_id";
            
            if (mysqli_query($conn, $sql)) {
                header("Location: manage_users.php");
                exit();
            }else {
                echo "Error: " . mysqli_error($conn);
            }
    }
}

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
<body class="bg-black/50">

<div class="hs-overlay size-full fixed top-0 inset-s-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none">
  <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-100 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center">
    <div class="w-full flex flex-col bg-white border border-slate-200 shadow-xl rounded-xl pointer-events-auto">
      <div class="flex justify-between items-center py-3 px-4 border-b border-slate-200 ">
        <h3 id="hs-scale-animation-modal-label" class="font-semibold text-foreground">
          Edit User
        </h3>
        <a href="manage_users.php" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full bg-white border border-surface-line text-surface-foreground hover:bg-slate-100 focus:outline-hidden focus:bg-surface-focus disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" data-hs-overlay="#hs-scale-animation-modal">
          <span class="sr-only">Close</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </a>
      </div>
      <div class="p-4 overflow-y-auto">
        <form class="space-y-4 md:space-y-6" action="edit_user.php?id=<?php echo $user_id; ?>" method="post">
            <div>
                <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full Name</label>
                <input value="<?php echo $row['username']; ?>" type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="full name" required="">
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input value="<?php echo $row['email']; ?>" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input value="<?php echo $row['password']; ?>" type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
            </div>
            <div>
                <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                <input value="<?php echo $row['password']; ?>" type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
            </div>
            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">P.Number</label>
                <input value="<?php echo $row['phone']; ?>" type="tel" name="phone" id="phone" placeholder="+1 (555) 000-0000" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
            </div>
            <div>
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                <select value="<?php echo $row['role']; ?>" name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student" selected>Student</option>                
                </select>
            </div>
            <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-[#93c5fd] dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                </div>
                <div class="ml-3 text-sm">
                  <label for="terms" class="font-light text-gray-500 dark:text-gray-300">I accept the <a class="font-medium text-[#2563eb] hover:underline dark:text-primary-500" href="#">Terms and Conditions</a></label>
                </div>
            </div>
            <button type="submit" class="w-full text-white bg-[#2563eb] hover:bg-[#1d4ed8] focus:ring-4 focus:outline-none focus:ring-[#93c5fd] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Edit User</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>