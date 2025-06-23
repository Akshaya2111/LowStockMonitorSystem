<?php
include '../includes/db.php';
include '../templates/header.php';
include '../templates/sidebar.php';

// Check if category ID is passed and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='content-wrapper' style='padding:20px;'><h2>Category not specified.</h2></div>";
    include '../templates/footer.php';
    exit;
}

$categoryId = (int) $_GET['id'];

try {
    // Get category name
    $stmtCat = $pdo->prepare("SELECT name FROM main_products WHERE id = ?");
    $stmtCat->execute([$categoryId]);
    $category = $stmtCat->fetch();

    if (!$category) {
        echo "<div class='content-wrapper' style='padding:20px;'><h2>Category not found.</h2></div>";
        include '../templates/footer.php';
        exit;
    }

    $categoryName = $category['name'];

    // Get sub-products for the category
    $stmtProd = $pdo->prepare("
        SELECT product_description, item_code, stock_quantity, min_stock_level, max_stock_level
        FROM sub_products
        WHERE category_id = ?
        ORDER BY product_description
    ");
    $stmtProd->execute([$categoryId]);
    $products = $stmtProd->fetchAll();

} catch (PDOException $e) {
    echo "<div class='content-wrapper' style='padding:20px;'><h2>Error: " . $e->getMessage() . "</h2></div>";
    include '../templates/footer.php';
    exit;
}
?>

<div class="content-wrapper" style="padding: 20px;">
    <h1 style="color:#5c4c9d;"><?= htmlspecialchars($categoryName); ?></h1>

    <?php if (count($products) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead style="background-color: #e6e6fa;">
                <tr>
                    <th>Product Description</th>
                    <th>Item Code</th>
                    <th>Stock Quantity</th>
                    <th>RTA</th>
                    <th>RTA and WIP</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['product_description']); ?></td>
                        <td><?= isset($row['item_code']) ? htmlspecialchars($row['item_code']) : '-'; ?></td>
                        <td><?= $row['stock_quantity']; ?></td>
                        <td><?= $row['min_stock_level']; ?></td>
                        <td><?= $row['max_stock_level']; ?></td>
                        <td>
                            <?php
                            if ($row['stock_quantity'] < $row['min_stock_level']) {
                                echo "<span style='color:red;'>Low</span>";
                            } elseif ($row['stock_quantity'] > $row['max_stock_level']) {
                                echo "<span style='color:orange;'>High</span>";
                            } else {
                                echo "<span style='color:green;'>OK</span>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No products found in this category.</p>
    <?php endif; ?>

    <br><br>
    <a href= "dashboard.php" style="background:#6c63ff; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;"> Back to Dashboard</a>
</div>

