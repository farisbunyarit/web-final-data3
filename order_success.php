<?php
// الخطوة 1: بدء الجلسة
session_start();

// الخطوة 2: تضمين ملف الاتصال (لأغراض العرض أو إذا احتجت للتحقق من قاعدة البيانات)
include '../includes/db_connection.php'; 

// الخطوة 3: الحصول على رقم الطلب من الـ URL (الـ Query String)
$order_id = isset($_GET['order']) ? intval($_GET['order']) : 0;

// التأكد من وجود رقم طلب صحيح
if ($order_id === 0) {
    // إذا لم يكن هناك رقم طلب، أعد التوجيه إلى الصفحة الرئيسية أو السلة
    header('Location: index.php'); // يمكنك تغييرها إلى cart.php
    exit();
}

// الخطوة 4: (اختياري) جلب تفاصيل الطلب من قاعدة البيانات للعرض
// هذا الجزء اختياري لكن يُفضل لتأكيد معلومات الطلب للمستخدم
$order_details = [];
$total_price = 0;

$sql = "SELECT t1.*, t2.product_id, t2.quantity, t2.price_at_order 
        FROM orders t1 
        JOIN order_items t2 ON t1.id = t2.order_id 
        WHERE t1.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // جلب الإجمالي من أول صف (لأن الإجمالي ثابت لكل عناصر الطلب)
    $first_row = $result->fetch_assoc();
    $total_price = $first_row['total_price'];
    
    // إعادة تعيين المؤشر وجلب جميع العناصر
    $result->data_seek(0); 
    while ($row = $result->fetch_assoc()) {
        $order_details[] = $row;
    }
} else {
    // إذا لم يتم العثور على الطلب
    $order_id = 0; 
}
$stmt->close();
$conn->close();

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Order Success</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .success-box { border: 1px solid #d4edda; background-color: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px auto; width: 60%; }
        .details-box { text-align: right; border: 1px solid #ddd; padding: 15px; margin-top: 30px; }
        .details-box p { margin: 5px 0; }
        .btn-home { 
            padding: 10px 20px; 
            background-color: #007bff; 
            color: white; 
            border: none; 
            cursor: pointer; 
            border-radius: 5px; 
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <?php if ($order_id > 0): ?>
        <div class="success-box">
            <h2>🎉 Order Confirmed Successfully!</h2>
            <p>Thank you for your order. Your order number is: **#<?= $order_id ?>**.</p>
        </div>

        <div class="details-box">
            <h3>Order Summary</h3>
            <p><strong>Total Paid:</strong> <?= number_format($total_price, 2) ?> Baht</p>
            <p><strong>Order Date:</strong> <?= $order_details[0]['order_date'] ?? 'N/A' ?></p>
            </div>

    <?php else: ?>
        <div class="success-box" style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">
            <h2>❌ Error</h2>
            <p>Order details could not be found. Please check your order history.</p>
        </div>
    <?php endif; ?>

    <a href="web.php" class="btn-home">Return to Products Page</a>

</body>
</html>