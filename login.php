<?php
session_start();

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'ktgiuaky');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý đăng xuất
if (isset($_POST['logout'])) {
    // Xóa tất cả dữ liệu phiên
    $_SESSION = array();

    // Hủy phiên
    session_destroy();

    // Chuyển hướng người dùng về trang đăng nhập
    header("Location: login.php");
    exit;
}

// Xử lý đăng nhập khi form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn cơ sở dữ liệu để tìm người dùng
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Lưu thông tin người dùng vào session
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        
        // Chuyển hướng đến trang danh sách nhân viên
        header("Location: index.php");
        exit;
    } else {
        $login_error = "Tên đăng nhập hoặc mật khẩu không đúng";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <!-- Phần style giữ nguyên -->
</head>
<body>
    <?php
    if (!isset($_SESSION['loggedin'])) {
        // Nếu người dùng chưa đăng nhập, hiển thị form đăng nhập
    ?>
        <h2>Trang Đăng Nhập</h2>
        <?php if (isset($login_error)): ?>
            <p><?php echo $login_error; ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            Tên đăng nhập: <input type="text" name="username" required><br>
            Mật khẩu: <input type="password" name="password" required><br>
            <input type="submit" value="Đăng nhập">
        </form>
    <?php
    } else {
        // Nếu người dùng đã đăng nhập, hiển thị nút đăng xuất
    ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="submit" name="logout" value="Đăng xuất">
        </form>
    <?php
    }
    ?>

    <!-- Đóng kết nối -->
    <?php $conn->close(); ?>
</body>
</html>
