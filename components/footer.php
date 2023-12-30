</main>
<footer class="text-center w-full bg-gray-900 p-4 text-white border-t border-gray-700">
    <p>&copy; Copyrights 2023. All rights reserved. Freelancer</p>
</footer>
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var button = document.getElementById("user-menu-button");
        var menu = document.querySelector(".absolute.right-0");

        button?.addEventListener("click", function() {
            menu.classList.toggle("hidden");
        });

        document.addEventListener("click", function(event) {
            if (!button?.contains(event.target) && !menu?.contains(event.target)) {
                menu?.classList.add("hidden");
            }
        });
    });
</script>