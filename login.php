<?php
// 假設這是你的登錄邏輯，你可以根據需要進行修改
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // 檢查用戶名和密碼是否有效，這裡只是示例
    if ($username === "admin" && $password === "password") {
        // 登錄成功，將用戶信息保存到會話中
        session_start();
        $_SESSION["username"] = $username;

        // 跳轉到前一個頁面
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bin/login_styles.css">
    <link rel="stylesheet" href="bin/header_footer_styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login_process.php" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    <?php include 'footer.php'?>
</body>
</html>
