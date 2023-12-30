<?php
include("../components/header.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/basicModal/3.3.9/basicModal.min.css" integrity="sha512-OEhY0MiYKyDajG34fYyAttnZ3FeTm4XDAPodXy4/16+ut57fYFRbALa4/jscK+rLe4S1HIfyzyInp1AS/p5OzA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
include("../includes/db.php");
include("../includes/functions.php");
checkUserRole("admin");
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $name = $_POST['editName'];
    $phone = $_POST['editPhone'];
    $address = $_POST['editAddress'];
    $email = $_POST['editEmail'];
    $id = $_POST['editId'];
    $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, address = ?, email = ? WHERE id = '$id'");
    $stmt->bind_param("ssss", $name, $phone, $address, $email);
    if ($stmt->execute()) {
        echo "<p class='text-white bg-green-500 w-full p-2'>User updated successfully!</p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}
?>

<div class="container">

    <div class="md:p-6 max-w-4xl mx-auto">
        <div class="border-b border-gray-100 pb-10 mb-4 relative overflow-x-auto">
            <h2 class="text-white text-2xl mb-2">Sellers List</h2>
            <table class="w-full text-sm text-left border-r border-r-gray-500 border-l border-l-gray-500 rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Phone
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch sellers from the database
                    $sellerQuery = "SELECT * FROM users WHERE role='seller';";
                    $sellerResult = $conn->query($sellerQuery);
                    $sellersCount = $sellerResult->num_rows;
                    if ($sellersCount > 0) { ?>
                        <?php while ($seller = $sellerResult->fetch_assoc()) {
                        ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?php echo $seller['name']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $seller['email']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $seller['phone']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo substr($seller['address'], 0, 10) . "..."; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:text-[#0a0a0a] focus:bg-[#FBDDD0] focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-transparent dark:border-2 dark:border-[#FBDDD0] dark:hover:bg-[#FBDDD0] dark:hover:text-black dark:focus:ring-blue-800" onclick='openEditModal("<?php echo $seller['id'] ?>","<?php echo $seller['name']; ?>", "<?php echo $seller['email']; ?>", "<?php echo $seller['phone']; ?>", "<?php echo $seller['address'] ?>")'>Edit</button>
                                    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-transparent dark:border-2 dark:border-[#FBDDD0] dark:hover:bg-[#FBDDD0] dark:hover:text-black dark:focus:ring-blue-800" onclick="openDeleteModal('<?php echo $seller['id']; ?>')">Delete</button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="text-center py-2">No sellers found</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="relative overflow-x-auto">
            <h2 class="text-white text-2xl mb-2">Buyers List</h2>
            <table class="border-r border-r-gray-500 border-l border-l-gray-500 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Buyer Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Phone
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch buyers from the database
                    $buyerQuery = "SELECT * FROM users WHERE role='buyer'";
                    $buyerResult = $conn->query($buyerQuery);
                    $buyersCount = $buyerResult->num_rows;
                    if ($buyersCount > 0) { ?>
                        <?php while ($buyer = $buyerResult->fetch_assoc()) {
                        ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?php echo $buyer['name']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $buyer['email']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $buyer['phone']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo substr($buyer['address'], 0, 100); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:text-[#0a0a0a] focus:bg-[#FBDDD0] focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-transparent dark:border-2 dark:border-[#FBDDD0] dark:hover:bg-[#FBDDD0] dark:hover:text-black dark:focus:ring-blue-800" onclick='openEditModal("<?php echo $buyer['id'] ?>","<?php echo $buyer['name']; ?>", "<?php echo $buyer['email']; ?>", "<?php echo $buyer['phone']; ?>", "<?php echo $buyer['address'] ?>")'>Edit</button>
                                    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-transparent dark:border-2 dark:border-[#FBDDD0] dark:hover:bg-[#FBDDD0] dark:hover:text-black dark:focus:ring-blue-800" onclick="openDeleteModal('<?php echo $buyer['id']; ?>')">Delete</button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="text-center py-2">No buyers found</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div id="editModal" class="hidden fixed inset-0 z-50 overflow-auto bg-black bg-opacity-30">
    <div class="flex items-center justify-center min-h-screen">
        <div class="dark:bg-gray-700 bg-white w-full max-w-md p-6 rounded-lg">
            <h2 class="dark:text-white text-2xl font-semibold mb-4">Edit Seller</h2>
            <form id="editForm" class="space-y-4" method="POST" action="">
                <input type="hidden" name="editId" id="editId">
                <label for="editName" class="block text-sm font-medium dark:text-white text-gray-700">Name:</label>
                <input type="text" id="editName" name="editName" class="w-full border p-2 rounded-md" required>
                <label for="editEmail" class="block text-sm font-medium dark:text-white text-gray-700">Email:</label>
                <input type="text" id="editEmail" name="editEmail" class="w-full border p-2 rounded-md" required>
                <label for="editEmail" class="block text-sm font-medium dark:text-white text-gray-700">Phone:</label>
                <input type="text" id="editPhone" name="editPhone" class="w-full border p-2 rounded-md" required>
                <label for="editEmail" class="block text-sm font-medium dark:text-white text-gray-700">Address:</label>
                <textarea id="editAddress" name="editAddress" class="w-full border p-2 rounded-md" required></textarea>

                <!-- Add other fields as needed -->

                <div class="flex justify-end">
                    <button type="submit" name="update_user" onclick="updateSeller()" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update</button>
                    <button type="button" onclick="closeEditModal()" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-30 hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white w-full max-w-md p-6 rounded-lg">
            <h2 class="text-2xl font-semibold mb-4">Confirm Deletion</h2>
            <p class="text-gray-700 mb-4">Are you sure you want to delete this user?</p>
            <div class="flex justify-end">
                <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-500 text-white rounded-md">Delete</button>
                <button type="button" onclick="closeDeleteModal()" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Variables to store the edited values
    let editedName = '';
    let editedEmail = '';

    // Function to open the edit modal with seller data
    function openEditModal(id, name, email, phone, address) {
        editedName = name;
        editedEmail = email;

        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editAddress').value = address;
        document.getElementById('editPhone').value = phone;
        document.getElementById('editId').value = id;
        // Set other fields as needed

        // Show the modal
        document.getElementById('editModal').classList.remove('hidden');
    }

    // Function to close the edit modal
    function closeEditModal() {
        // Hide the modal
        document.getElementById('editModal').classList.add('hidden');
    }

    // Function to handle the update operation
    function updateSeller() {
        // Get values from the modal form fields
        editedName = document.getElementById('editName').value;
        editedEmail = document.getElementById('editEmail').value;
        // Get other values as needed

        // Perform the update operation (you may use AJAX to send the data to the server)

        // Update the UI with the new values (replace this with your actual logic)
        document.getElementById('sellerName').innerText = editedName;
        document.getElementById('sellerEmail').innerText = editedEmail;

        // Close the modal
        closeEditModal();
    }
</script>

<script>
    let userToDelete = '';

    // Function to open the delete confirmation modal
    function openDeleteModal(name) {
        userToDelete = name;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        userToDelete = '';
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function confirmDelete() {
        // Make an AJAX request to delete_user.php
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../includes/deleteUser.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Delete the user from the UI (replace this with your actual logic)
                    window.location.reload();
                } else {
                    console.error(response.error);
                }
            } else {
                console.error('AJAX request failed');
            }

            // Close the delete confirmation modal
            closeDeleteModal();
        };

        // Send the request with the user's name
        const params = 'nameToDelete=' + encodeURIComponent(userToDelete);
        xhr.send(params);
    }
</script>

<?php

include("../components/footer.php");
?>