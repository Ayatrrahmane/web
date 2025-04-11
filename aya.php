<?php
session_start();
$products=[ 
    1 => ["name" => " Bvlgari Splendida Tubereuse Mystique", "price" => 350, "image" => "chanel_no5.jpg"],
    2 => ["name" => " Lancome Tresor Midnight Rose", "price" => 400, "image" => "dior_jadore.jpg"],
    3 => ["name" => " Dolce & Gabbana Pour Femme Intense", "price" => 380, "image" => "gucci_bloom.jpg"],
    4 => ["name" => " Givenchy L'interdit Rouge", "price" => 390, "image" => "chanel_no5.jpg"],
    5 => ["name" => " Doir Addict ", "price" => 500, "image" => "dior_jadore.jpg"],
    6 => ["name" => " Tom Ford Velvet Orchid", "price" => 480, "image" => "gucci_bloom.jpg"],
    7 => ["name" => " Swiss Arabian Layali ", "price" => 650, "image" => "chanel_no5.jpg"],
    8 => ["name" => " Doir Hypnotic Poison", "price" => 460, "image" => "dior_jadore.jpg"],
    9 => ["name" => " Guerlain Shalimar", "price" => 300, "image" => "gucci_bloom.jpg"],
   10 => ["name" => "Mugler Alien Essence Absolue", "price" => 600, "image" => "dior_jadore.jpg"],
   11 => ["name" => " Amouage Honour Woman", "price" => 360, "image" => "gucci_bloom.jpg"],
   12 => ["name" => " Mainson Francis Kurkdijan Oud Satin Mood", "price" => 370, "image" => "chanel_no5.jpg"],
   13 => ["name" => " Guerlain Santal Royal ", "price" => 200, "image" => "dior_jadore.jpg"],

   14 => ["name" => " Valentino Voce Viva Intensa ", "price" => 380, "image" => "gucci_bloom.jpg"],
   15 => ["name" => " Kilian Love Don't Be shy ", "price" => 400, "image" => "dior_jadore.jpg"],
   16 => ["name" => " Gucci Flora Gorgeous Jasmine  ", "price" => 600, "image" => "dior_jadore.jpg"], 
   17 => ["name" => " YSL Libre Intense ", "price" => 500, "image" => "dior_jadore.jpg"],   
   18 => ["name" => " Maison Francis Kurkdijan Baccarat Rouge 540 ", "price" => 450, "image" => "dior_jadore.jpg"],
   19 => ["name" => " Partums de Marly Delina  ", "price" => 250, "image" => "dior_jadore.jpg"],

   20 => ["name" => " Victorias Secret Bombshell", "price" => 290, "image" => "dior_jadore.jpg"],
   21 => ["name" => " Juliette Has a Gun Pear Lnc  ", "price" => 320, "image" => "dior_jadore.jpg"],
   22 => ["name" => " Nina Ricci Nina ", "price" => 340, "image" => "dior_jadore.jpg"],
   23 => ["name" => " Jimmy Choo Illicit ", "price" => 440, "image" => "dior_jadore.jpg"],
   24 => ["name" => " Escada Cherey In Japan ", "price" => 450, "image" => "dior_jadore.jpg"],
   25 => ["name" => " Giorgio Armani My Way ", "price" => 460, "image" => "dior_jadore.jpg"],
   26 => ["name" => " Marc Jacobs Daisy Eau So Fresh  ", "price" => 600, "image" => "dior_jadore.jpg"],
   27 => ["name" => " Dolce &Gabbana Light Blue ", "price" => 500, "image" => "dior_jadore.jpg"],

   28 => ["name" => "Lancome Idole", "price" => 700, "image" => "dior_jadore.jpg"],
   29 => ["name" => "Elie Saab Le Parfum", "price" => 520, "image" => "dior_jadore.jpg"],
   30 => ["name" => "Byredo Blanche ", "price" => 630, "image" => "dior_jadore.jpg"],
   31 => ["name" => "Narciso Rodriguez For Her", "price" => 320, "image" => "dior_jadore.jpg"],
   32 => ["name" => "Michael Kors Gorgeous", "price" => 650, "image" => "dior_jadore.jpg"],
   33 => ["name" => "Diptyque Eau Rose", "price" => 420, "image" => "dior_jadore.jpg"],
   34 => ["name" => "Hermes Jour d'Hermes", "price" => 440, "image" => "dior_jadore.jpg"],
   35 => ["name" => "Bvlgari Rose Goldea", "price" => 430, "image" => "dior_jadore.jpg"],

]; 

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']); 
    if (isset($products[$product_id])) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++; 
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $products[$product_id]['name'],
                'price' => $products[$product_id]['price'],
                'image' => $products[$product_id]['image'],
                'quantity' => 1
            ];
        }
    }
}

if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
}

if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <style>
        body { font-family: Tahoma; background: #f0f0f0; padding: 20px; }
        .product, .cart { background: #fff; padding: 15px; margin-bottom: 20px; border: 1px solid #ccc; width: 300px; }
        button { padding: 5px 10px; background: #28a745; color: white; border: none; cursor: pointer; }
        a { color: red; text-decoration: none; }
    </style>
</head>
<body>

<h2>Produits disponibles </h2>
<?php foreach ($products as $id => $item): ?>
    <div class="product">
        <form method="POST">
            <img src="images/<?= $item['image'] ?>" alt="<?= $item['name'] ">
            <strong><?= $item['name'] ?></strong><br>
         prix :<?= $item['price'] ?>riyal <br>
            <input type="hidden" name="product_id" value="<?= $id ?>">
            <button type="submit"> Ajouter au panier</button>
        </form>
    </div>
<?php endforeach;?>
</div>

<hr>

<h2>Contenu du panier</h2>
<div class="cart">
<?php if (!empty($_SESSION['cart'])): ?>
    <ul>
    <?php $total = 0; ?>
    <?php foreach ($_SESSION['cart'] as $id => $item): 
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
        <li>
            <img src="images/<?= $item['image'] ?>" width="50" style="vertical-align: middle;">
            <?= $item['name'] ?>x <?= $item['quantity'] ?> = <?= $subtotal ?> riyal
            <a class="remove-btn" href="?remove=<?= $id ?>">suppression</a>
        </li>
    <?php endforeach; ?>
    </ul>
    <strong>total: <?= $total ?>riyal </strong>
  <form method="POST" style="margin-top:10px;">
        <button type="submit" name="clear_cart" style="background: red;">تفريغ السلة</button>
  </form>
<?php else: ?>
    <p>Le panier est vide</p>
<?php endif; ?>
</div>

</body>
</html> 
