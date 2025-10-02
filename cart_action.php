<?php
session_start();
include '../includes/db_connection.php'; 
// === دالة لحساب الإجمالي الكلي للسلة ===
function calculate_cart_total() {
    $total = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            // الإجمالي هو السعر * الكمية لكل منتج
            $total += $item['price'] * $item['quantity'];
        }
    }
    // حفظ الإجمالي الكلي في الجلسة
    $_SESSION['cart_total'] = $total;
}
// ======================================


// الخطوة 3: معالجة طلب إضافة منتج (Add to Cart)
if (isset($_POST['action']) && $_POST['action'] == 'add' && isset($_POST['product_id'])) {
    
    // تنظيف البيانات الواردة
    $product_id = intval($_POST['product_id']);
    $product_name = htmlspecialchars($_POST['product_name']);
    $product_price = (float)$_POST['product_price'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    // تهيئة مصفوفة السلة إذا لم تكن موجودة
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // منطق إضافة/تحديث الكمية:
    if (array_key_exists($product_id, $_SESSION['cart'])) {
        // إذا كان المنتج موجودًا: نزيد الكمية فقط
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // إذا لم يكن موجودًا: نضيف المنتج كعنصر جديد
        $_SESSION['cart'][$product_id] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $quantity,
        ];
    }
    
    // إعادة حساب الإجمالي الكلي للسلة بعد كل إضافة
    calculate_cart_total();

    // الخطوة 4: إعادة توجيه المستخدم لصفحة المنتجات
    header('Location: web.php'); 
    exit();
}

?>