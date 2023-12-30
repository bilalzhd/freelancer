<?php include("../components/header.php"); ?>
<?php
include("../includes/db.php");
$buyerEmail = $_SESSION['email'];

$result = $conn->query("SELECT * FROM services WHERE buyer_email = '$buyerEmail'");

$stmt = $conn->prepare("SELECT COUNT(*) FROM services WHERE buyer_email = ?");
$stmt->bind_param("s", $buyerEmail);
$stmt->execute();
$stmt->bind_result($serviceCount);
$stmt->fetch();
$stmt->close();

if ($serviceCount < 1) {
    echo "<script>window.location.href = './add-service'</script>";
    header("Location: ./add-service");
    exit();
}
include("../includes/functions.php");
checkUserRole("seller");
?>
<div class="container md:p-4 flex justify-center">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <img class="p-8 rounded-t-lg" src="<?php echo $row['picture_path'] ?>" alt="Service image" />
                </a>
                <div class="px-5 pb-5">
                    <a href="#">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white"><?php echo $row['title'] ?></h5>
                        <p class="text-white mb-6"><?php echo $row['description'] ?></p>
                    </a>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo $row['pricing'] ?>$/hour</span>
                        <a href="./edit-service" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-transparent dark:border dark:border-[#FBDDD0] dark:hover:border-blue-700 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</a>
                    </div>
                </div>
            </div>
    <?php }
    } else {
        echo "<a href='./add-service'><button type='button' class='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:border-2 dark:border-blue-600 dark:focus:ring-blue-800'>Add your service</button></a>";
    } ?>
</div>
<?php include("../components/footer.php"); ?>