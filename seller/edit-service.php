<?php
include("../includes/db.php");
include("../components/header.php");

// Check if the user has a service to edit
$buyerEmail = $_SESSION['email'];
$stmt = $conn->prepare("SELECT id, title, description, pricing, picture_path FROM services WHERE buyer_email = ?");
$stmt->bind_param("s", $buyerEmail);
$stmt->execute();
$stmt->bind_result($serviceId, $title, $description, $pricing, $picturePath);
$stmt->fetch();
$stmt->close();

// If the user has no service, redirect to the dashboard
if (!$serviceId) {
    header("Location: ./dashboard");
    exit();
}

// If the form is submitted, update the service
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTitle = $_POST['title'];
    $newDescription = $_POST['description'];
    $newPricing = $_POST['pricing'];

    // Handle service picture update
    $uploadDir = '../assets/images/service_pictures/';
    $newPictureName = basename($_FILES['new_picture']['name']);
    $newPicturePath = $uploadDir . $newPictureName;

    move_uploaded_file($_FILES['new_picture']['tmp_name'], $newPicturePath);

    // Update service details in the database
    $updateStmt = $conn->prepare("UPDATE services SET title = ?, description = ?, pricing = ?, picture_path = ? WHERE id = ?");
    $updateStmt->bind_param("ssdsi", $newTitle, $newDescription, $newPricing, $newPicturePath, $serviceId);

    if ($updateStmt->execute()) {
        header("Location: ./dashboard");
        exit();
    } else {
        echo "Error: " . $updateStmt->error;
    }

    $updateStmt->close();
}

?>

<section class="bg-gray-50 dark:bg-gray-900 border-t border-gray-700 py-6">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <form enctype="multipart/form-data" class="space-y-4 md:space-y-6" action="?" method="POST">
                    <!-- Display current service details in the form for editing -->
                    <input type="hidden" name="serviceId" value="<?= $serviceId ?>">
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Service Title</label>
                        <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= $title ?>" required>
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Service description</label>
                        <textarea name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required><?= $description ?></textarea>
                    </div>
                    <div>
                        <label for="pricing" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price (per hour)</label>
                        <input type="number" name="pricing" id="pricing" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required step="0.1" value="<?= $pricing ?>">
                    </div>
                    <div>
                        <!-- Display the old service picture -->
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current Service Picture</label>
                        <img src="<?= $picturePath ?>" alt="Current Service Picture" class="mb-4 w-full h-auto">
                    </div>
                    <div>
                        <label for="new_picture" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            New Service Picture
                        </label>
                        <div class="relative border-dashed border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 flex justify-center items-center">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M41.97 34.45C39.15 31.62 34.5 29 24 29s-15.15 2.62-17.97 5.45A2.008 2.008 0 0 0 5 37c0 1.1.9 2 2 2h34c1.1 0 2-.9 2-2a2.008 2.008 0 0 0-.03-2.55zM24 31c4.1 0 7.73 1.49 9.87 3.94C31.42 36.47 28.8 37 24 37s-7.42-.53-9.87-2.06C16.27 32.49 19.9 31 24 31zm-4-7h8v-4h-8v4zm0-8h8V7h-8v8zm-10 9c-.55 0-1 .45-1 1s.45 1 1 1h2v-2H8zm-4 4h12v-2H4v2z"></path>
                                </svg>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <label for="new_picture" class="cursor-pointer text-blue-500 hover:underline focus:outline-none focus:underline transition duration-150 ease-in-out">
                                        Select a file
                                    </label>
                                    or drag and drop
                                </div>
                            </div>
                            <input type="file" accept="image/*" class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" name="new_picture" id="new_picture">
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("../components/footer.php"); ?>
<script src="../assets/js/functions.js"></script>
<script>addPictureToInput("new_picture")</script>