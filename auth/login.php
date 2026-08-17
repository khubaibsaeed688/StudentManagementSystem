<?php
session_start();

include "../config/db_connect.php";

$showError = '
        <div id="errorAlert" class="flex items-center justify-between max-w-md p-4 mx-auto mt-5 text-red-800 bg-red-100 border border-red-300 rounded-lg shadow">
            <div>
                <h3 class="font-semibold">Error!</h3>
                <p class="text-sm">Invalid email or password.</p>
            </div>
        
            <button
                onclick="document.getElementById(\'errorAlert\').style.display=\'none\'"
                class="ml-4 text-red-700 hover:text-red-900 text-xl font-bold"
            >
                &times;
            </button>
        </div>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $useremail = $_POST['email'];
    $userpassword = $_POST['password'];

    $sql = "SELECT `user_id`, `username`, `password`, `role` FROM `users` WHERE email = '$useremail'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($userpassword, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
        

            if ($_SESSION['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
                exit;
            }
    
            elseif ($_SESSION['role'] === 'teacher') {
                header("Location: ../teacher/dashboard.php");
                exit;
            }
    
            elseif ($_SESSION['role'] === 'student') {
                header("Location: ../student/dashboard.php");
                exit;
            }
    
            else {
                echo "Not valid" ;
            }
        }
    }else {
      echo $showError;
    }

}

if (isset($_SESSION['user_id'])) {
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
</head>
<body>
    
    <section class="bg-gray-50 dark:bg-gray-900">
      <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
          <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
              <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
              Flowbite    
          </a>
          <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
              <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                  <div class="space-y-2">
                    <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Welcome Back  👋
                    </h1>
                    <p class="text-sm text-center leading-tight tracking-tight text-gray-900 md:text-sm dark:text-white">
                        Login to your account
                    </p>
                  </div>
                  <form class="space-y-4 md:space-y-6" action="login.php" method="post">
                      <div>
                          <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                          <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                      </div>
                      <div>
                          <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                          <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                      </div>
                      <div class="flex items-start">
                          <div class="flex items-center h-5">
                            <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-[#93c5fd] dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="terms" class="font-light text-gray-500 dark:text-gray-300">I accept the <a class="font-medium text-[#2563eb] hover:underline dark:text-primary-500" href="#">Terms and Conditions</a></label>
                          </div>
                      </div>
                      <button type="submit" class="w-full text-white bg-[#2563eb] hover:bg-[#1d4ed8] focus:ring-4 focus:outline-none focus:ring-[#93c5fd] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Login</button>
                      <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                          Don't have an account? <a href="signup.php" class="font-medium text-[#2563eb] hover:underline dark:text-primary-500">sign up here</a>
                      </p>
                  </form>
              </div>
          </div>
      </div>
    </section>

<script>
    setTimeout(() => {
        const alert = document.getElementById("alert");
        if (alert) {
            alert.style.display = "none";
        }
    }, 3000);
</script>
</body>
</html>