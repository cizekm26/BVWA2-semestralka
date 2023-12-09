<?php
// Include your database connection code or use an existing connection
include 'db/db_connect.php';

// Assuming the ID is passed through the URL
$user_id = $_GET['id'];

// Query to fetch user data based on user ID
$sql = "SELECT * FROM zamestnanci WHERE id = $user_id";  // Adjust the query based on your database structure

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch user data as an associative array
    $userData = $result->fetch_assoc();
} else {
    // Handle the case where no user data is found
    $userData = array();  // Empty array if no user found
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="output.css" rel="stylesheet">
    <title>Profil</title>
    <script src="js/script.js"></script>
</head>

<body class="bg-white">
    <?php include 'templates/header.php';?>

    <div class="md:mx-20 max-w-md mx-auto mt-5 sm:max-w-xl lg:max-w-full lg:px-5">
        <div class="px-4 sm:px-0">
            <h1 class="text-3xl font-semibold">Osobní údaje</h1>
        </div>
        <div class="bg-gray-100 rounded-md mt-5 grid lg:grid-cols-2 shadow">
            <div>
                <div class="bg-blue-500 p-5 lg:hidden rounded-t-md">
                    <img class="rounded-lg shadow-xl w-40 mx-auto" src="resources/img/profile.jpg">
                </div>
                <div class="mt-4 border-gray-100 md:m-5 sm:mx-auto">
                    <dl class="divide-y divide-blue-500">
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Jméno Příjmení</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0"><?php echo "{$userData['jmeno']} {$userData['prijmeni']}"; ?></dd>
                        </div>
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Email</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0"><?php echo "{$userData['email']}"; ?></dd>
                        </div>
                         <!--
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Telefon</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0">123456789</dd>
                        </div>
                        -->
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Pohlaví</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0"><?php echo "{$userData['pohlavi']}"; ?></dd>
                        </div>
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Login</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0"><?php echo "{$userData['login']}"; ?></dd>
                        </div>
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Role</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0"><?php echo "{$userData['role']}"; ?></dd>
                        </div>
                    </dl>
                    <div class="mt-5">
                    <a class="rounded-lg shadow-lg text-sm text-white bg-blue-500 px-4 py-3 uppercase font-semibold" href="edit.php?id=<?php echo $userData['id']; ?>">Upravit</a>
                     </div>
                </div>
            </div>
            <div class="hidden relative lg:block bg-blue-500 p-5 w-full h-full rounded-r-md">
                <img class="rounded-lg shadow-xl w-40" src="resources/img/profile.jpg">
            </div>
        </div>
</body>

</html>