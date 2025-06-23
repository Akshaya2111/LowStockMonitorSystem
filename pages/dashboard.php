<?php  
include '../includes/db.php';  
include '../templates/header.php';  
include '../templates/sidebar.php';  
?>

<div class="content-wrapper" style="text-align:center; padding:20px;">
    <img src="../images/logo.jpg" alt="Company Logo" style="width:200px;"><br><br>
    <h1 style="color:#5c4c9d;">Bezares Alpha Drives India Pvt. Ltd.</h1>
    <h2>Stock Alert Dashboard</h2>

    <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:20px; margin-top:30px;">
        <?php
        try {
            $stmt = $pdo->query("SELECT id, name FROM main_products");
            while ($cat = $stmt->fetch()) {
                ?>
                <a href="category_products.php?id=<?= $cat['id'] ?>" 
                   style="background:#b19cd9; color:white; padding:30px 50px; font-size:20px; border-radius:10px; text-decoration:none; box-shadow:0 4px 8px rgba(0,0,0,0.2);">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
                <?php
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error fetching categories: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
