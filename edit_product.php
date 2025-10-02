<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "890890890f";
$dbname = "motorcycle_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM products WHERE id = $id";
  $result = $conn->query($sql);
  $product = $result->fetch_assoc();
}

if (isset($_POST['edit_product'])) {
  $image_url = $_POST['image_url'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  $sql = "UPDATE products SET image_url='$image_url', name='$name', description='$description', price='$price' WHERE id='$id'";
  $conn->query($sql);

  header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product</title>
</head>
<body>

  <h2>Edit Product</h2>

  <form method="POST">
    <input type="text" name="image_url" value="<?= $product['image_url'] ?>" required>
    <input type="text" name="name" value="<?= $product['name'] ?>" required>
    <textarea name="description" required><?= $product['description'] ?></textarea>
    <input type="number" name="price" value="<?= $product['price'] ?>" required>
    <button type="submit" name="edit_product">Update Product</button>
  </form>

</body>
</html>

<?php
$conn->close();
?>
