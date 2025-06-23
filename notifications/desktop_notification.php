<?php
include '../includes/db.php'; // Your PDO $pdo connection

$low = [];
try {
    $stmt = $pdo->query("SELECT * FROM sub_products");
    $products = $stmt->fetchAll();
    foreach ($products as $product) {
        if ($product['stock_quantity'] < $product['min_stock_level']) {
            $low[] = $product;
        }
    }
} catch (PDOException $e) {
    die("Error fetching stock: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Low Stock Alert</title>
</head>
<body>
    <h2>Low Stock Notification</h2>
    <?php if (count($low) > 0): ?>
        <p style="color:red"><strong><?= count($low) ?> low stock product<?= count($low) > 1 ? 's' : '' ?> found.</strong></p>
    <?php else: ?>
        <p style="color:green">All stock levels are normal.</p>
    <?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    function showNotification() {
        <?php if(count($low) > 0): ?>
        let bodyText = "";
        <?php foreach($low as $item): ?>
        bodyText += "<?= addslashes($item['product_description']) ?> (<?= addslashes($item['item_code']) ?>): Qty <?= $item['stock_quantity'] ?>\n";
        <?php endforeach; ?>

        const notification = new Notification("🚨 Low Stock Alert (<?= count($low) ?> items)", {
            body: bodyText,
            icon: "https://cdn-icons-png.flaticon.com/512/1828/1828843.png"
        });

        setTimeout(() => notification.close(), 10000);
        <?php endif; ?>
    }

    if (!("Notification" in window)) {
        alert("This browser does not support desktop notifications.");
        return;
    }

    if (Notification.permission === "granted") {
        showNotification();
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                showNotification();
            }
        });
    }
});
</script>
</body>
</html>