<?php
include '../includes/db.php';
include '../templates/header.php';
include '../templates/sidebar.php';

try {
    $stmt = $pdo->query("
        SELECT s.id, s.product_description, s.item_code, m.name AS category,
               s.stock_quantity, s.min_stock_level, s.max_stock_level
        FROM sub_products s
        JOIN main_products m ON s.category_id = m.id
        ORDER BY m.name, s.product_description
    ");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching stock: " . $e->getMessage());
}
?>

<div class="content-wrapper" style="padding: 20px;">
    <h1>Manage Stock</h1>

    <?php if (count($products) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left;">
            <thead style="background-color: #e6e6fa;">
                <tr>
                    <th>Product Description</th>
                    <th>Item Code</th>
                    <th>Category</th>
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
                        <td><?= htmlspecialchars($row['category']); ?></td>
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
        <p>No products in stock.</p>
    <?php endif; ?>
</div>


