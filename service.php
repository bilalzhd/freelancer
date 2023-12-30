<?php include("./components/header.php");
include("./includes/db.php"); 
include("./includes/functions.php"); 
$loggedIn = isset($_SESSION['role']) && isset($_SESSION['email']);
if(!$loggedIn) {
    header("Location: ./login");
}
?>
<div class="text-white p-2 flex justify-between text-center text-2xl bg-green-500 hidden">
    <span id="alert"></span>
    <button id="remove" class="cursor-pointer border rounded-full px-2">X</button>
</div>
<div class="container mx-auto my-8 text-white flex flex-col items-center">
    <?php
    $id = base64_decode($_GET['service']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT title, description, pricing, picture_path FROM services WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($title, $description, $pricing, $picturePath);
    // Fetch service details
    if ($stmt->fetch()) {
        $picturePath = correctUrl($picturePath);
    ?>
        <div class="flex items-center justify-center">
            <img src="<?php echo $picturePath; ?>" alt="<?php echo $title; ?>" class="w-64 h-64 object-cover rounded-lg">
        </div>
        <h1 class="text-3xl font-bold mt-4"><?php echo $title; ?></h1>
        <p class="text-gray-200 mt-2"><?php echo $description; ?></p>
        <p class="text-blue-700 font-bold mt-4">$<?php echo $pricing; ?>/hour</p>
        <a href="hire?service=<?php echo base64_encode($id) ?>"><button id="hire-me" class="mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-transparent dark:border dark:border-[#FBDDD0] dark:hover:border-blue-700 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send Proposal</button></a>
    <?php
    } else {
        echo "<p>Service not found.</p>";
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
    ?>
</div>

<?php include("./components/footer.php"); ?>
<!-- <script>
    const action = document.getElementById("hire-me");
    action.addEventListener("click", function() {
        if(confirm("Do you really want to hire this person?")) {
            document.getElementById("alert").parentElement.classList.remove("hidden")
            document.getElementById("alert").innerHTML = "Your order has been recieved."
        }
    })
    const remove = document.getElementById("remove")
    remove.addEventListener("click", function() {
        document.getElementById("alert").parentElement.classList.add("hidden");
        document.getElementById("alert").innerHTML = ""
    })
</script> -->