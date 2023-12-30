<?php include("../components/header.php");
include("../includes/db.php"); ?>
<?php
include("../includes/functions.php");
checkUserRole("seller");
$email = $_SESSION['email'];
$userQuery = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($userQuery);
$user = $result->fetch_assoc();

?>

<section class="bg-gray-50 dark:bg-gray-900 border-t border-gray-700 py-6">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Your Profile
                </h1>
                    <div class="flex gap-2">
                        <div class="md:w-1/2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John Doe" required disabled value="<?php echo $user['name'] ?>">
                        </div>
                        <div class="md:w-1/2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required disabled value="<?php echo $user['email'] ?>">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="md:w-1/2">
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your role</label>
                            <input type="email" name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required disabled value="<?php echo ucfirst($user['role']) ?>">
                        </div>
                        <div class="md:w-1/2">
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                            <input type="text" placeholder="*135 street, A01 K1P*" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="address" id="address" required value="<?php echo ucfirst($user['address']) ?>" disabled></textarea>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="md:w-1/2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                            <input type="text" placeholder="xxxxxxxxxxxxx" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="phone" id="phone" required value="<?php echo ucfirst($user['phone']) ?>" disabled>
                        </div>
                        <div class="md:w-1/2">
                            <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                            <input type="text" placeholder="xxxxxxxxxxxxx" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="country" id="country" required value="<?php echo ucfirst($user['country']) ?>" disabled>
                        </div>
                    </div>
                    <div>
                        <label for="bio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bio</label>
                        <textarea class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="bio" id="bio" required disabled><?php echo $user['bio'] ?></textarea>
                    </div>
                    <div>
                        <label for="pic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Profile Picture
                        </label>
                        <div class="relative border-dashed border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 flex justify-center items-center">
                            <img src="<?= $user['profile_picture'] ?>" alt="Current Service Picture" class="mb-4 max-w-[150px] h-auto">
                        </div>
                    </div>
                    <a class="pt-4" href="./edit-profile"><button class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button></a>

            </div>
        </div>
    </div>
</section>


<?php include("../components/footer.php") ?>
<script>
    addPictureToInput("pic");
</script>