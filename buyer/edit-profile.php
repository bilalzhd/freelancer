<?php include("../components/header.php");
include("../includes/db.php") ?>
<?php
$email = $_SESSION['email'];
$userQuery = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($userQuery);
$user = $result->fetch_assoc();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("../includes/db.php");

    // Extract form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $bio = $_POST['bio'];

    $picPath = '';

    // Check if a new profile picture is provided
    if (isset($_FILES['pic']) && $_FILES['pic']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/uploads/';
        $picName = basename($_FILES['pic']['name']);
        $picPath = $uploadDir . $picName;

        // Move the uploaded file
        move_uploaded_file($_FILES['pic']['tmp_name'], $picPath);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE users SET name = ?, address = ?, phone = ?, country = ?, bio = ?, profile_picture = ? WHERE email = ?");
    $stmt->bind_param("sssssss", $name, $address, $phone, $country, $bio, $picPath, $email);

    if ($stmt->execute()) {
        echo "<p class='text-white p-2'>User information updated successfully!</p>";
        $userQuery = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($userQuery);
        $user = $result->fetch_assoc();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>

<section class="bg-gray-50 dark:bg-gray-900 border-t border-gray-700 py-6">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Edit profile
                </h1>
                <form enctype="multipart/form-data" class="space-y-4 md:space-y-6" action="?" method="POST">
                    <div class="flex gap-2">
                        <div class="md:w-1/2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John Doe" required value="<?php echo $user['name'] ?>">
                        </div>
                        <div class="md:w-1/2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required value="<?php echo $user['email'] ?>">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="w-full">
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                            <textarea type="text" placeholder="*135 street, A01 K1P*" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="address" id="address" required><?php echo $user['address'] ?></textarea>
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                        <input type="text" placeholder="xxxxxxxxxxxxx" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="phone" id="phone" required value="<?php echo $user['phone'] ?>">
                    </div>
                    <div>
                        <label for="bio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bio</label>
                        <textarea placeholder="I am a software developer with expertise in Web development and designing using various frameworks " class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="bio" id="bio" required><?php echo $user['bio'] ?></textarea>
                    </div>
                    <div>
                        <label for="pic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Current Profile Picture
                        </label>
                        <div class="border-dashed border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 flex justify-center items-center">
                            <img src=".<?= $user['profile_picture'] ?>" alt="Current Service Picture" class="mb-4 max-w-[150px] h-auto">
                        </div>
                    </div>
                    <div>
                        <label for="pic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            New Profile Picture
                        </label>
                        <div class="relative border-dashed border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 flex justify-center items-center">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M41.97 34.45C39.15 31.62 34.5 29 24 29s-15.15 2.62-17.97 5.45A2.008 2.008 0 0 0 5 37c0 1.1.9 2 2 2h34c1.1 0 2-.9 2-2a2.008 2.008 0 0 0-.03-2.55zM24 31c4.1 0 7.73 1.49 9.87 3.94C31.42 36.47 28.8 37 24 37s-7.42-.53-9.87-2.06C16.27 32.49 19.9 31 24 31zm-4-7h8v-4h-8v4zm0-8h8V7h-8v8zm-10 9c-.55 0-1 .45-1 1s.45 1 1 1h2v-2H8zm-4 4h12v-2H4v2z"></path>
                                </svg>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <label for="pic" class="cursor-pointer text-blue-500 hover:underline focus:outline-none focus:underline transition duration-150 ease-in-out">
                                        Select a file
                                    </label>
                                    or drag and drop
                                </div>
                            </div>
                            <input type="file" accept="image/*" class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" name="pic" id="pic" value="<?php echo $user['profile_picture'] ?>" />
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</section>


<?php include("../components/footer.php") ?>
<script src="../assets/js/functions.js"></script>
<script>
    addPictureToInput("pic");
</script>