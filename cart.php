<?php
// الخطوة 1: بدء الجلسة
session_start();

// الخطوة 2: تضمين ملف الاتصال (إذا كنت تريد جلب أي بيانات إضافية)
include '../includes/db_connection.php'; 

// دالة لحساب الإجمالي الكلي (للتأكد من أن الإجمالي محدث)
function calculate_cart_total() {
    $total = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    $_SESSION['cart_total'] = $total;
}

calculate_cart_total(); // تحديث الإجمالي عند كل زيارة للصفحة
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        .checkout-container { text-align: center; margin-top: 20px; }
        .btn-primary { 
            padding: 10px 20px; 
            background-color: #007bff; 
            color: white; 
            border: none; 
            cursor: pointer; 
            border-radius: 5px; 
        }
    </style>
</head>
<body>

    <h1>Shopping Cart</h1>

    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 2) ?> Baht</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'] * $item['quantity'], 2) ?> Baht</td>
                        </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Total:</td>
                    <td><?= number_format($_SESSION['cart_total'], 2) ?> Baht</td>
                </tr>
            </tfoot>
        </table>

        <div class="checkout-container">
            <h3>Total Amount: <?= number_format($_SESSION['cart_total'], 2) ?> Baht</h3>
            
            <form method="post" action="checkout_process.php">
                <input type="hidden" name="complete_order" value="1"> 
                
                <button type="submit" class="btn-primary">Proceed to Checkout & Place Order</button>
            </form>
        </div>

    <?php else: ?>
        <p style="text-align: center;">Your cart is empty. Please add some products!</p>
    <?php endif; ?>

</body>
</html>