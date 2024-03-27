<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Nhân viên</title>
    <style>
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Thêm Nhân viên</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="ma_nv">Mã Nhân viên:</label>
        <input type="text" id="ma_nv" name="ma_nv" required>

        <label for="ten_nv">Tên Nhân viên:</label>
        <input type="text" id="ten_nv" name="ten_nv" required>

        <label for="phai">Phái:</label>
        <select id="phai" name="phai">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>

        <label for="noi_sinh">Nơi Sinh:</label>
        <input type="text" id="noi_sinh" name="noi_sinh" required>

        <label for="ma_phong">Mã Phòng:</label>
        <input type="text" id="ma_phong" name="ma_phong" required>

        <label for="luong">Lương:</label>
        <input type="text" id="luong" name="luong" required>

        <input type="submit" name="submit" value="Thêm Nhân viên">
    </form>

    <?php
    // Kết nối đến cơ sở dữ liệu
    $conn = new mysqli('localhost', 'root', '', 'ktgiuaky');

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Xử lý dữ liệu khi nút "Thêm Nhân viên" được nhấn
    if (isset($_POST['submit'])) {
        $ma_nv = $_POST['ma_nv'];
        $ten_nv = $_POST['ten_nv'];
        $phai = $_POST['phai'];
        $noi_sinh = $_POST['noi_sinh'];
        $ma_phong = $_POST['ma_phong'];
        $luong = $_POST['luong'];

        // Query thêm nhân viên vào cơ sở dữ liệu
        $sql = "INSERT INTO nhanvien (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) 
                VALUES ('$ma_nv', '$ten_nv', '$phai', '$noi_sinh', '$ma_phong', '$luong')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='text-align: center; color: green;'>Thêm nhân viên thành công</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>Lỗi: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }

    // Đóng kết nối
    $conn->close();
    ?>
</body>
</html>
