<?php include("./components/header.php");
include("./includes/db.php");
include("./includes/functions.php");
checkUserRole("buyer");
$id = base64_decode($_GET['service']);
$seller_email = mysqli_fetch_assoc(mysqli_query($conn, "SELECT buyer_email FROM services WHERE id = '$id'"))['buyer_email'];
$buyer_email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requirements = $_POST['requirements'] ?? '';
    $budget = $_POST['budget'] ?? '';
    $deadline = $_POST['deadline'] ?? '';

    $stmt = $conn->prepare("INSERT INTO proposals (seller_id, buyer_id, requirements, budget, deadline) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $seller_email, $buyer_email, $requirements, $budget, $deadline);

    if ($stmt->execute()) {
        echo "<p class='text-white bg-green-500 w-full p-2'>Proposal submitted successfully!</p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>
<div class="max-w-lg mx-auto bg-gray-700 px-4 py-6 mt-8 mb-4 rounded-lg">
    <form class="space-y-4 md:space-y-6" action="" method="POST">
        <div>
            <label for="requirements" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your requirements</label>
            <textarea name="requirements" id="requirements" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="I have a permalinks issue in my wordpress website which I want you to fix" required=""></textarea>
        </div>
        <div>
            <label for="budget" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Budget ($/hour)</label>
            <input type="number" min="0.1" step="0.1" name="budget" id="budget" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
        </div>
        <div>
            <label for="budget" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deadline</label>
            <input type="date" step="0.1" name="deadline" id="deadline" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
        </div>
        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send</button>
    </form>
</div>
<script>
    const deadline = document.getElementById("deadline");
    const date = new Date();
    let tdate = date.getDate();
    let month = date.getUTCMonth() + 1;
    if (tdate < 10) {
        tdate = "0" + tdate
    }
    if (month < 10) {
        month = "0" + month
    }
    let year = date.getUTCFullYear();
    let minDate = year + "-" + month + "-" + tdate;
    deadline.setAttribute("min", minDate);
</script>
<?php include("./components/footer.php"); ?>