<?php include("../components/header.php");
include("../includes/db.php"); ?>
<?php
include("../includes/functions.php");
checkUserRole("admin"); 
$email = $_SESSION['email'];
?>


<div class="relative overflow-x-auto max-w-5xl mx-auto p-4">
    <h2 class="text-white text-2xl mb-2">Proposals</h2>
    <table class="border-r border-r-gray-500 border-l border-l-gray-500 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Buyer Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Seller Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Requirements
                </th>
                <th scope="col" class="px-6 py-3">
                    Budget
                </th>
                <th scope="col" class="px-6 py-3">
                    Deadline
                </th>
                <th scope="col" class="px-6 py-3">
                    Time
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch buyers from the database
            $proposalsQuery = "SELECT * FROM proposals";
            $proposals = $conn->query($proposalsQuery);

            while ($proposal = $proposals->fetch_assoc()) {
            ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?php echo $proposal['buyer_id']; ?>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?php echo $proposal['seller_id']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $proposal['requirements']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $proposal['budget']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $proposal['deadline']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $proposal['timestamp']; ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php include("../components/footer.php"); ?>