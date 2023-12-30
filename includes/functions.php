<?php
function checkUserRole($allowedRole, $redirectPath = "Location: ../")
{
    if (isset($_SESSION['email']) && isset($_SESSION['role'])) {
        $userRole = $_SESSION['role'];
        if ($userRole !== $allowedRole) {
            switch ($userRole) {
                case 'admin':
                    echo "<script>window.location.href = '../admin/dashboard'</script>";
                    break;
                case 'seller':
                    echo "<script>window.location.href = '../seller/dashboard'</script>";
                    break;
                case 'buyer':
                    echo "<script>window.location.href = '../buyer/dashboard'</script>";
                    break;
                default:
                    echo "<script>window.location.href = '../'</script>";
                    break;
            }
            exit();
        }
    } else {
        echo "<script>window.location.href = '../'</script>";
        exit();
    }
}
function correctUrl($string)
{
    return strpos($string, '../') === 0 ? substr($string, 3) : $string;
}
