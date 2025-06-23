<?php
include '../includes/db.php';
include '../templates/header.php';
include '../templates/sidebar.php';

$categories = $pdo->query("SELECT * FROM main_products")->fetchAll();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_code = $_POST['item_code'];

    $product_stmt = $pdo->prepare("SELECT * FROM sub_products WHERE item_code = :item_code");
    $product_stmt->execute([':item_code' => $item_code]);
    $product = $product_stmt->fetch();

    if ($product) {
        // Auto reduce stock by 1 and update other fields
        $new_stock = intval($_POST['stock_quantity']) - 1;
        $min_stock = intval($_POST['min_stock_level']);
        $max_stock = intval($_POST['max_stock_level']);

        $update_stmt = $pdo->prepare("UPDATE sub_products SET stock_quantity = :stock, min_stock_level = :min, max_stock_level = :max WHERE item_code = :item_code");
        $update_stmt->execute([
            ':stock' => $new_stock,
            ':min' => $min_stock,
            ':max' => $max_stock,
            ':item_code' => $item_code
        ]);

        $message = "Product updated successfully!";
    } else {
        $message = "Item code not found.";
    }
}
?>

<div class="content-wrapper" style="padding: 20px;">
    <h1>Update Product</h1>
    <?php if ($message): ?>
        <p style="color: <?= strpos($message, 'success') ? 'green' : 'red'; ?>"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Category (optional for filtering):</label>
        <select name="category_id">
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['name']); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Item Code:</label>
        <input type="text" name="item_code" required><br><br>

        <label>Stock Quantity:</label>
        <input type="number" name="stock_quantity" required><br><br>

        <label>RTA (Min Stock):</label>
        <input type="number" name="min_stock_level" required><br><br>

        <label>RTA and WIP (Max Stock):</label>
        <input type="number" name="max_stock_level" required><br><br>

        <button type="submit" style="background-color: #6a0dad; color: white; padding: 6px 12px;">Update Product</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>