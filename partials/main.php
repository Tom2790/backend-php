<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <script src="assets/js/script.js"></script>
</head>
<body>
    <h1>User Management</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Company</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $users = json_decode(file_get_contents('dataset/users.json'), true);
            foreach ($users as $user) {
                echo '<tr>';
                echo '<td>' . $user['name'] . '</td>';
                echo '<td>' . $user['username'] . '</td>';
                echo '<td>' . $user['email'] . '</td>';
                echo '<td>' . $user['address'] . '</td>';
                echo '<td>' . $user['phone'] . '</td>';
                echo '<td>' . $user['company'] . '</td>';
                echo '<td><button onclick="removeUser(\'' . $user['username'] . '\')">Remove</button></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <h2>Add User</h2>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>

        <label for="company">Company:</label>
        <input type="text" id="company" name="company" required><br>

        <input type="submit" value="Add User">
    </form>

    <?php
    if (isset($_POST['remove_username'])) {
        $removeUsername = $_POST['remove_username'];
        $filteredUsers = array_filter($users, function ($user) use ($removeUsername) {
            return $user['username'] !== $removeUsername;
        });
        file_put_contents('dataset/users.json', json_encode(array_values($filteredUsers), JSON_PRETTY_PRINT));
        header('Location: main.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newUser = array(
            'name' => $_POST['name'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'company' => $_POST['company']
        );

        $users[] = $newUser;
        file_put_contents('dataset/users.json', json_encode($users, JSON_PRETTY_PRINT));
        header('Location: main.php');
        exit;
    }
    ?>

    <script>
        function removeUser(username) {
            if (confirm('Are you sure you want to remove this user?')) {
                var form = document.createElement('form');
                form.method = 'post';
                form.action = '';
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_username';
                input.value = username;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>

