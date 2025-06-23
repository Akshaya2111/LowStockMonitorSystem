<?php
include '../includes/db.php';
include '../templates/header.php';
include '../templates/sidebar.php';

$message = '';

// Fetch categories from main_products
try {
    $categories_stmt = $pdo->query("SELECT id, name FROM main_products ORDER BY name");
    $categories = $categories_stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching categories: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = intval($_POST['category_id']);
    $item_code = trim($_POST['item_code']);
    $description = trim($_POST['product_description']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $rta = intval($_POST['min_stock_level']);
    $rta_wip = intval($_POST['max_stock_level']);

    if ($category_id && $description) {
        try {
            $stmt = $pdo->prepare("INSERT INTO sub_products (category_id, product_description, item_code, stock_quantity, min_stock_level, max_stock_level)
                                   VALUES (:category_id, :description, :item_code, :stock_quantity, :rta, :rta_wip)");
            $stmt->execute([
                ':category_id' => $category_id,
                ':description' => $description,
                ':item_code' => $item_code,
                ':stock_quantity' => $stock_quantity,
                ':rta' => $rta,
                ':rta_wip' => $rta_wip
            ]);
            $message = "✅ Product added successfully!";
        } catch (PDOException $e) {
            $message = "❌ Insert error: " . $e->getMessage();
        }
    } else {
        $message = "⚠️ Please fill in all required fields.";
    }
}
?>

<div class="content-wrapper" style="padding: 20px;">
    <h1>Add New Product</h1>

    <?php if ($message): ?>
        <p style="color: <?= str_contains($message, 'successfully') ? 'green' : 'red'; ?>;">
            <?= htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="add_product.php" style="max-width: 600px;">
        <label><strong>Category (from main_products):</strong></label>
        <select name="category_id" required>
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $row): ?>
                <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['name']); ?></option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <label><strong>Item Code:</strong></label>
        <input type="text" name="item_code" style="width: 100%;" required>

        <br><br>

        <label><strong>Product Description:</strong></label>
        <input type="text" name="product_description" style="width: 100%;" required>

        <br><br>

        <label><strong>Stock Quantity:</strong></label>
        <input type="number" name="stock_quantity" value="0" min="0" required style="width: 100%;">

        <br><br>

        <label><strong>RTA (Min Stock):</strong></label>
        <input type="number" name="min_stock_level" value="10" min="0" required style="width: 100%;">

        <br><br>

        <label><strong>RTA and WIP (Max Stock):</strong></label>
        <input type="number" name="max_stock_level" value="100" min="1" required style="width: 100%;">

        <br><br>

        <button type="submit" style="background-color: #8a2be2; color: white; padding: 10px 20px; border: none;">
            Add Product
        </button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
