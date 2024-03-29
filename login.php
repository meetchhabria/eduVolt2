<?php
session_start();

// Check if form is submitted for login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Establish connection to MySQL database
    $conn = new mysqli('localhost', 'root', '', 'udemy_platform');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user data from database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) { // Verify password
            $_SESSION['username'] = $username;
            echo "Login successful";
            // Redirect to home page or any other page after successful login
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<div>
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" name="login" value="Login">
        <button id="metamask-login">Login with MetaMask</button>
    </form>
    <p>Don't have an account? <a href="register.php">Sign Up here</a></p>
</div>
<script>
// Check if MetaMask is installed
if (typeof window.ethereum !== 'undefined') {
    console.log('MetaMask is installed!');
    
    // Add event listener to login button
    document.getElementById('metamask-login').addEventListener('click', async function() {
        try {
            // Request access to the user's MetaMask accounts
            const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
            // Log the Ethereum address
            console.log('Connected Ethereum address:', accounts[0]);
            // Redirect to a backend endpoint to handle the login with Ethereum address
            window.location.href = 'index.php?ethereumAddress=' + accounts[0];
        } catch (error) {
            console.error(error);
            alert('Failed to connect to MetaMask. Please make sure MetaMask is installed and logged in.');
        }
    });
} else {
    console.log('MetaMask is not installed.');
    // Disable the button or provide alternative login method if MetaMask is not installed
    document.getElementById('metamask-login').disabled = true;
}
</script>

</body>
</html>
