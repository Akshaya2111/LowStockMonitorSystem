<?php
include '../includes/db.php';
include '../templates/header.php';
include '../templates/sidebar.php';
?>

<div class="content-wrapper" style="padding: 20px;">
    <h2>Stock Reports</h2>

    <?php
    $low = [];
    $ok = [];
    $high = [];

    try {
        $stmt = $pdo->query("SELECT * FROM sub_products");
        $products = $stmt->fetchAll();

        foreach ($products as $product) {
            if ($product['stock_quantity'] < $product['min_stock_level']) {
                $low[] = $product;
            } elseif ($product['stock_quantity'] > $product['max_stock_level']) {
                $high[] = $product;
            } else {
                $ok[] = $product;
            }
        }
    } catch (PDOException $e) {
        die("Error fetching stock: " . $e->getMessage());
    }
    ?>

    <table border="1" cellpadding="10" cellspacing="0" style="margin-bottom: 30px;">
        <tr>
            <th>Status</th>
            <th>Number of Products</th>
        </tr>
        <tr>
            <td style="color:red;">Low Stock</td>
            <td><?= count($low); ?></td>
        </tr>
        <tr>
            <td style="color:green;">Stock OK</td>
            <td><?= count($ok); ?></td>
        </tr>
        <tr>
            <td style="color:orange;">High Stock</td>
            <td><?= count($high); ?></td>
        </tr>
    </table>

    <?php
    function render_table($products, $title, $color) {
        if (count($products) > 0) {
            echo "<h3 style='color: $color;'>$title</h3>";
            echo "<table border='1' cellpadding='10' cellspacing='0' style='margin-bottom: 30px; width: 100%;'>
                    <tr>
                        <th>Product Description</th>
                        <th>Item Code</th>
                        <th>Stock Quantity</th>
                        <th>RTA</th>
                        <th>RTA and WIP</th>
                    </tr>";
            foreach ($products as $p) {
                echo "<tr>
                        <td>" . htmlspecialchars($p['product_description']) . "</td>
                        <td>" . htmlspecialchars(isset($p['item_code']) ? $p['item_code'] : '-') . "</td>
                        <td>" . $p['stock_quantity'] . "</td>
                        <td>" . $p['min_stock_level'] . "</td>
                        <td>" . $p['max_stock_level'] . "</td>
                      </tr>";
            }
            echo "</table>";
        }
    }

    render_table($low, "Low Stock Products", "red");
    render_table($ok, "Stock OK Products", "green");
    render_table($high, "High Stock Products", "orange");
    ?>
</div>

<?php include '../templates/footer.php'; ?>