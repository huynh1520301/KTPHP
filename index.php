<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Nhân viên</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Danh sách Nhân viên</h1>
    <?php
    // Kết nối đến cơ sở dữ liệu
    $conn = new mysqli('localhost', 'root', '', 'ktgiuaky');

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Xác định số lượng bản ghi trên mỗi trang
    $records_per_page = 5;

    // Xác định trang hiện tại
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Tính toán vị trí bắt đầu
    $start_from = ($current_page - 1) * $records_per_page;

    // Truy vấn lấy dữ liệu từ bảng nhanvien với giới hạn
    $sql = "SELECT Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong FROM nhanvien LIMIT $start_from, $records_per_page";
    $result = $conn->query($sql);

    // Hiển thị dữ liệu nhân viên
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Ma_NV</th><th>Ten_NV</th><th>Phai</th><th>Noi_Sinh</th><th>Ma_Phong</th><th>Luong</th></tr>";
        
        // Xuất dữ liệu của mỗi hàng
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Ma_NV"]. "</td>";
            echo "<td>" . $row["Ten_NV"]. "</td>";
            echo "<td>";
            if ($row["Phai"] === "NU") {
                echo "<img src='img/woman.jpg' alt='Woman' width='50px' height='50px' />";
            } else {
                echo "<img src='img/man.jpg' alt='Man' width='50px' height='50px' />";
            }
            echo "</td>";
            echo "<td>" . $row["Noi_Sinh"]. "</td>";
            echo "<td>" . $row["Ma_Phong"]. "</td>";
            echo "<td>" . $row["Luong"]. "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 kết quả";
    }

    // Phân trang
    $sql = "SELECT COUNT(Ma_NV) AS total FROM nhanvien";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_pages = ceil($row["total"] / $records_per_page);

    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='index.php?page=".$i."'>".$i."</a> ";
    }

    // Đóng kết nối
    $conn->close();
    ?>
</body>
</html>
