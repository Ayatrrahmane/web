<?php
session_start();

// الاتصال بقاعدة البيانات
$dsn = "mysql:host=localhost;dbname=panier_db;charset=utf8";
$username = "root"; // غيّره حسب إعداداتك
$password = "";      // غيّره حسب إعداداتك

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

// قائمة المنتجات
$products = [
    1 => ["name" => "Bvlgari Splendida Tubereuse Mystique", "price" => 350, "image" => "chanel_no5.jpg"],
    2 => ["name" => "Lancome Tresor Midnight Rose", "price" => 400, "image" => "dior_jadore.jpg"],
    // أكمل بقية المنتجات حسب الكود السابق...
];

$session_id = session_id();

// عند إضافة منتج إلى السلة
if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    if (isset($products[$product_id])) {
        // تحقق إذا كان المنتج موجود بالفعل في السلة (نفس الجلسة)
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE session_id = ? AND product_id = ?");
        $stmt->execute([$session_id, $product_id]);
        $existing = $stmt->fetch();

        if ($existing) {
            // إذا موجود، زِد الكمية
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE id = ?");
            $stmt->execute([$existing['id']]);
        } else {
            // إذا غير موجود، أضفه
            $stmt = $pdo->prepare("INSERT INTO cart (session_id, product_id, name, price, image, quantity)
                                   VALUES (?, ?, ?, ?, ?, 1)");
            $p = $products[$product_id];
            $stmt->execute([$session_id, $product_id, $p['name'], $p['price'], $p['image']]);
        }
    }
}

// حذف عنصر من السلة
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    $stmt = $pdo->prepare("DELETE FROM cart WHERE session_id = ? AND product_id = ?");
    $stmt->execute([$session_id, $remove_id]);
}

// تفريغ السلة
if (isset($_POST['clear_cart'])) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE session_id = ?");
    $stmt->execute([$session_id]);
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سلة المشتريات</title>
    <style>
        body { font-family: Tahoma; background: #f0f0f0; padding: 20px; }
        .product, .cart { background: #fff; padding: 15px; margin-bottom: 20px; border: 1px solid #ccc; width: 300px; }
        button { padding: 5px 10px; background: #28a745; color: white; border: none; cursor: pointer; }
        a { color: red; text-decoration: none; }
    </style>
</head>
<body>

<h2>المنتجات المتوفرة</h2>
<?php foreach ($products as $id => $item): ?>
    <div class="product">
        <form method="POST">
            <img src="images/<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="100"><br>
            <strong><?= $item['name'] ?></strong><br>
            السعر: <?= $item['price'] ?> ريال<br>
            <input type="hidden" name="product_id" value="<?= $id ?>">
            <button type="submit">أضف إلى السلة</button>
        </form>
    </div>
<?php endforeach; ?>

<hr>

<h2>محتوى السلة</h2>
<div class="cart">
<?php
$stmt = $pdo->prepare("SELECT * FROM cart WHERE session_id = ?");
$stmt->execute([$session_id]);
$items = $stmt->fetchAll();

if ($items):
    $total = 0;
    echo "<ul>";
    foreach ($items as $item):
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
        ?>
        <li>
            <img src="images/<?= $item['image'] ?>" width="50" style="vertical-align: middle;">
            <?= $item['name'] ?> × <?= $item['quantity'] ?> = <?= $subtotal ?> ريال
            <a href="?remove=<?= $item['product_id'] ?>">حذف</a>
        </li>
    <?php endforeach;
    echo "</ul>";
    echo "<strong>المجموع: {$total} ريال</strong>";
    ?>
    <form method="POST" style="margin-top:10px;">
        <button type="submit" name="clear_cart" style="background: red;">تفريغ السلة</button>
    </form>
<?php else: ?>
    <p>السلة فارغة</p>
<?php endif; ?>
</div>

</body>
</html>
