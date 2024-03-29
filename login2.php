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
    <!-- Button to trigger MetaMask login -->
    <button id="metamask-login">Login with MetaMask</button>
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
            alert('Failed to connect to MetaMask. Please make sure MetaMask is installed and unlocked.');
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
