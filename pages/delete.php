<?php
include '../includes/db.php';
include '../templates/header.php';
include '../templates/sidebar.php';

$categories = $pdo->query("SELECT * FROM main_products")->fetchAll();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_code = $_POST['item_code'];

    // Check if product exists
    $check = $pdo->prepare("SELECT * FROM sub_products WHERE item_code = :item_code");
    $check->execute([':item_code' => $item_code]);
    $product = $check->fetch();

    if ($product) {
        // Delete the product
        $delete = $pdo->prepare("DELETE FROM sub_products WHERE item_code = :item_code");
        $delete->execute([':item_code' => $item_code]);
        $message = "Product deleted successfully!";
    } else {
        $message = "Item code not found.";
    }
}
?>

<div class="content-wrapper" style="padding: 20px;">
    <h1>Delete Product</h1>
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

        <button type="submit" style="background-color: #d11a2a; color: white; padding: 6px 12px;">Delete Product</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>