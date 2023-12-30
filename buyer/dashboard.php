<?php
include("../components/header.php");
include("../includes/db.php");
include("../includes/functions.php");
checkUserRole("buyer");
$query = "SELECT * FROM services";
$result = $conn->query($query);

?>

<div class="container px-0 md:px-6 pb-10">
    <div class="py-10">
        <h2 class="text-white text-3xl text-center font-bold">Popular Services</h2>
    </div>
    <div class="flex flex-wrap gap-6 w-full">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $pricing = $row['pricing'];
                $picturePath = $row['picture_path'];
                $buyerEmail = $row['buyer_email']; ?>
                <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="p-8 rounded-t-lg w-full h-[300px] object-cover" src=".<?php echo substr($picturePath, 1); ?>" alt="product image" />
                    </a>
                    <div class="px-5 pb-5">
                        <a href="../service?service<?php echo $id ?>">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white"><?php echo $title; ?></h5>
                            <p class="text-white mb-6"><?php echo $description; ?></p>
                        </a>
                        <div class="flex items-center justify-between">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">$<?php echo $pricing; ?>/hour</span>

                            <a href="/freelancer/service?service=<?php echo base64_encode($id); ?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-transparent dark:border dark:border-[#FBDDD0] dark:hover:border-blue-700 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Hire Me</a>
                        </div>
                        <a href="#" class="mt-3 w-full bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                            <div class="w-full text-left rtl:text-right flex items-center gap-2">
                                <?php $image_query = "SELECT profile_picture FROM users WHERE email = '$buyerEmail'";
                                $image_result = $conn->query($image_query);
                                $img = $image_result->fetch_assoc();
                                $picture = $img['profile_picture'];
                                if (str_starts_with($picture, '..')) {
                                    $picture = substr($picture, 1);
                                }   ?>
                                <div class="w-8">
                                    <img class="rounded-full object-cover" src="<?php echo $img['profile_picture'] ?>" alt="">
                                </div>
                                <div class="-mt-1 font-sans text-sm font-semibold"><?php echo $buyerEmail ?></div>
                            </div>
                        </a>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p>No services available.</p>";
        }
        ?>
    </div>
</div>

<?php include("../components/footer.php"); ?>