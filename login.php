<?php include("./components/header.php"); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    include("./includes/db.php");
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT email, password, role, profile_picture FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbEmail, $dbPassword, $role, $profile_picture);
        $stmt->fetch();
        if (password_verify($password, $dbPassword)) {

            $_SESSION['email'] = $dbEmail;
            $_SESSION['role'] = $role;
            $_SESSION['profile_picture'] = $profile_picture;

            if ($role === 'seller') {
                header("Location: /freelancer/seller/dashboard");
            } elseif ($role === 'buyer') {
                header("Location: /freelancer/buyer/dashboard");
            } elseif ($role === 'admin') {
                header("Location: /freelancer/admin/dashboard");
            }
            exit();
        } else {
            echo "<p class='text-white p-3 bg-red-500 transition-opacity duration-5000 ease-in-out'>Error: Wrong credentials.</p>";
        }
    } else {
        echo "<p class='text-white p-3 bg-red-500 transition-opacity duration-5000 ease-in-out'>Error: User with the provided email not found.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<section class="bg-gray-50 dark:bg-gray-800 border-t border-gray-700">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-900 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign in to your account
                </h1>
                <form class="space-y-4 md:space-y-6" action="?" method="POST">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign in</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Don’t have an account yet? <a href="/freelancer/signup" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>


<?php include("./components/footer.php"); ?>