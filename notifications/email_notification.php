<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/PHPMailer/src/Exception.php';
require '../includes/PHPMailer/src/PHPMailer.php';
require '../includes/PHPMailer/src/SMTP.php';

include '../includes/db.php'; // Make sure your PDO $pdo is here

$mail = new PHPMailer(true);

try {
    // Fetch low stock products
    $low = [];
    $stmt = $pdo->query("SELECT * FROM sub_products");
    $products = $stmt->fetchAll();

    foreach ($products as $product) {
        if ($product['stock_quantity'] < $product['min_stock_level']) {
            $low[] = $product;
        }
    }

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'akshayabalu2111@gmail.com';
    $mail->Password = 'wchv pysx emnq ueuz';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('akshayabalu2111@gmail.com', 'Stock Alert');
    $mail->addAddress('akshayabalu2111@gmail.com');

    // Compose HTML body with low stock table
    $body = '<h2 style="color:#5A00A0;">Daily Stock Notification</h2>';
    $body .= '<p>This is a email notification for stock alert system.</p>';

    if (count($low) > 0) {
        $body .= '
        <div style="
            border: 2px solid #d93025; 
            background-color: #fbe9e7; 
            padding: 20px; 
            margin-top: 20px; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(217,48,37,0.3);
            font-family: Arial, sans-serif;
        ">
            <h3 style="
                color: #d93025; 
                margin-top: 0; 
                font-size: 22px; 
                font-weight: bold;
                display: flex; 
                align-items: center;
                gap: 10px;
            ">
                <span style="font-size: 28px;">🚨</span> Low Stock Products
            </h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px;">
                <thead>
                    <tr style="background-color: #f9c0bb; color: #7f1d1d;">
                        <th style="border: 1px solid #d93025; padding: 10px; text-align: left; border-radius: 8px 0 0 0;">Product Description</th>
                        <th style="border: 1px solid #d93025; padding: 10px; text-align: left;">Item Code</th>
                        <th style="border: 1px solid #d93025; padding: 10px; text-align: right; border-radius: 0 8px 0 0;">Stock Quantity</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($low as $item) {
            $body .= '<tr style="background-color: #fff4f3;">
                <td style="border: 1px solid #d93025; padding: 10px;">' . htmlspecialchars($item['product_description']) . '</td>
                <td style="border: 1px solid #d93025; padding: 10px;">' . htmlspecialchars($item['item_code']) . '</td>
                <td style="border: 1px solid #d93025; padding: 10px; text-align: right; font-weight: bold; color: #d93025;">' . $item['stock_quantity'] . '</td>
            </tr>';
        }
        $body .= '</tbody></table></div>';
    } else {
        $body .= '<p style="color: green; font-weight: bold;">No low stock products at the moment.</p>';
    }

    // Set email content
    $mail->isHTML(true);
    $mail->Subject = 'Daily Stock Notification';
    $mail->Body = $body;
    $mail->AltBody = 'Check your email client for the detailed stock notification.';

    $mail->send();

    // Show beautiful success UI
    echo '
    <style>
        .email-notification {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px 25px;
            background: linear-gradient(to bottom right, #f2f6ff, #e0e7ff);
            border-radius: 20px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            color: #2c3e50;
        }

        .email-notification .icon {
            font-size: 48px;
            background: white;
            color: #4a00e0;
            border-radius: 50%;
            padding: 12px;
            box-shadow: 0 2px 8px rgba(74, 0, 224, 0.3);
            margin-bottom: 20px;
            display: inline-block;
        }

        .email-notification h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #4a00e0;
        }

        .email-notification p {
            margin-top: 10px;
            font-size: 16px;
        }
    </style>

    <div class="email-notification">
        <h2>Email Sent Successfully!</h2>
        <p>Your daily stock notification has been delivered to your inbox.</p>
    </div>';
} catch (Exception $e) {
    echo "<p style='color: red;'>Email could not be sent. Error: {$mail->ErrorInfo}</p>";
}
?>