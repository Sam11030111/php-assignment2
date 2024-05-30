<?php

/*******w******** 
    
    Name: Hung-Sheng Lee
    Date: May 22th, 2024
    Description:

****************/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="thankyou.css">
    <title>Thanks for your order!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->

    <!-- full name -->
    <?php $fullName = trim(filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING)); ?>
    <!-- address -->
    <?php $address = trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING)); ?>
    <!-- city -->
    <?php $city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING)); ?>
    <!-- province -->
    <?php $province = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_STRING); ?>
    <!-- postal code -->
    <?php $postalCodePattern = '/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/'; ?>
    <?php $postalCode = filter_input(INPUT_POST, 'postal', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$postalCodePattern))); ?>
    <!-- email -->
    <?php $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL) ?>
    <!-- quantity -->
    <?php 
        $quantity1 = filter_input(INPUT_POST, 'qty1', FILTER_VALIDATE_INT); 
        $quantity2 = filter_input(INPUT_POST, 'qty2', FILTER_VALIDATE_INT); 
        $quantity3 = filter_input(INPUT_POST, 'qty3', FILTER_VALIDATE_INT); 
        $quantity4 = filter_input(INPUT_POST, 'qty4', FILTER_VALIDATE_INT); 
        $quantity5 = filter_input(INPUT_POST, 'qty5', FILTER_VALIDATE_INT);
    ?>
    <?php $quantityFields = [
        $quantity1 => ['productName' => 'iMac', 'price' => 1899.99],
        $quantity2 => ['productName' => 'Razer Mouse', 'price' => 79.99],
        $quantity3 => ['productName' => 'WD HDD', 'price' => 179.99],
        $quantity4 => ['productName' => 'Nexus', 'price' => 249.99],
        $quantity5 => ['productName' => 'Drums', 'price' => 119.99],
    ] ?>
    <?php
        $totalSum = 0;
        if ($quantity1 >= 0 && $quantity2 >= 0 && $quantity3 >= 0 && $quantity4 >= 0 && $quantity5 >= 0) {
            foreach ($quantityFields as $quantity => $details) {
                $totalSum += $quantity * $details['price'];
            }
        }
    ?>

    <!-- credit card number -->
    <?php $creditCardPattern = '/^\d{10}$/'; ?>
    <?php $creditCardNumber = filter_input(INPUT_POST, 'cardnumber', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$creditCardPattern))); ?>
    <!-- credit card month & year -->
    <?php $currentMonth = date("n"); // n returns the month without leading zeros (1 to 12) ?>
    <?php $currentYear = date("Y"); ?>
    <?php $month = filter_input(INPUT_POST, 'month', FILTER_VALIDATE_INT); ?>
    <?php $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT); ?>
    <!-- card type -->
    <?php $cardType = filter_input(INPUT_POST, 'cardtype', FILTER_SANITIZE_STRING); ?>
    <!-- card name -->
    <?php $cardName = trim(filter_input(INPUT_POST, 'cardname', FILTER_SANITIZE_STRING)); ?>


    <div class="invoice">
        <?php if($fullName): ?>
            <h2><?= "Thanks for your order $fullName." ?></h2>
        <?php else: ?>
            <h2>❌Invalid full name.</h2>
        <?php endif ?>

        <h3><?= "Here's a summary of your order:" ?></h3>

        <table>
            <tbody>
                <tr>
                    <td colspan="4">
                        <h3>Address Information</h3>
                    </td>
                </tr>
                <tr>
                    <td class="alignright">
                        <span class="bold">Address:</span>
                    </td>
                    <td>
                        <?php if($address): ?>
                            <?= $address ?>
                        <?php else: ?>
                            <?= "❌Invalid address." ?>
                        <?php endif ?>
                    </td>
                    <td class="alignright">
                        <span class="bold">City:</span>
                    </td>
                    <td>
                        <?php if($city): ?>
                            <?= $city ?>
                        <?php else: ?>
                            <?= "❌Invalid city." ?>
                        <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <td class="alignright">
                        <span class="bold">Province:</span>
                    </td>
                    <td>
                        <?php if($province): ?>
                            <?= $province ?>
                        <?php else: ?>
                            <?= "❌Invalid province." ?>
                        <?php endif ?>
                    </td>
                    <td class="alignright">
                        <span class="bold">Postal Code:</span>
                    </td>
                    <td>
                        <?php if($postalCode): ?>
                            <?= $postalCode ?>
                        <?php else: ?>
                            <?= "❌Invalid postal code." ?>
                        <?php endif ?>
                    </td>
                </tr>
                <tr>
                    <td class="alignright" colspan="2">
                        <span class="bold">Email:</span>
                    </td>
                    <td colspan="2">
                        <?php if($email): ?>
                            <?= $email ?>
                        <?php else: ?>
                            <?= "❌Invalid email." ?>
                        <?php endif ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>
                <tr>
                    <td colspan="3">
                        <h3>Order Information</h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="bold">Quantity</span>
                    </td>
                    <td>
                        <span class="bold">Description</span>
                    </td>
                    <td>
                        <span class="bold">Cost</span>
                    </td>
                </tr>
                <?php if ((empty($quantity1) && (empty($quantity2)) && (empty($quantity3)) && (empty($quantity4)) && (empty($quantity5))) || ($quantity1 < 0) || ($quantity2 < 0) || ($quantity3 < 0) || ($quantity4 < 0) || ($quantity5 < 0)):?>
                    <td colspan="3">
                        <span>❌Invalid quantity.</span>
                    </td>
                <?php else: ?>
                    <?php foreach ($quantityFields as $field => $detail): ?>
                        <?php if ($field !== 0): ?>
                            <tr>
                                <td><?= $field ?></td>
                                <td><?= $detail['productName'] ?></td>
                                <td class="alignright"><?= $field * $detail['price'] ?></td>
                            </tr>
                        <?php endif ?>  
                    <?php endforeach; ?>
                <?php endif ?>    
                <tr>
                    <td class="alignright" colspan="2">
                        <span class="bold">Totals</span>
                    </td>
                    <td class="alignright">
                        <span class="bold"><?= "$ " . $totalSum ?></span>
                    </td>
                </tr>                
            </tbody>
        </table>

        <?php if ($creditCardNumber): ?>
            <p>$creditCardNumber</p>
            <p><?= "✅Credit card number: " . $creditCardNumber ?></p>
        <?php else: ?>
            <p>❌Invalid card number.</p>
        <?php endif ?> 

        <?php if ($month && $year): ?>
            <?php if ($year > $currentYear || ($year == $currentYear && $month > $currentMonth)): ?>
                <p><?= "✅Expire year: " . $year ?></p>
                <p><?= "✅Expire month: " . $month ?></p>
            <?php else: ?>
                <p>❌Invalid card expiration date.</p>
            <?php endif ?> 
        <?php else: ?>
            <p>❌Invalid card expiration date.</p>
        <?php endif ?> 

        <?php if ($cardType): ?>
            <p><?= "✅Card type: " . $cardType ?></p>
        <?php else: ?>
            <p>❌Invalid card type.</p>
        <?php endif ?> 

        <?php if ($cardName): ?>
            <p><?= "✅Card name: " . $cardName ?></p>
        <?php else: ?>
            <p>❌Invalid card name.</p>
        <?php endif ?> 
    </div>
</body>
</html>