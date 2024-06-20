<?php

function checkDiscount($purchaseValue){
    if (!is_numeric($purchaseValue)) {
        return "Invalid input: The input must be a number.";
    }

    if ($purchaseValue >= 500){
        $discountedPrice = $purchaseValue * 0.9; // 10% discount
        return "Purchase Value is " . $purchaseValue . ", discount is 10%. Price after discount is " . number_format($discountedPrice, 2) . ".";

    } else if ($purchaseValue < 500 && $purchaseValue >= 100) {
        $discountedPrice = $purchaseValue * 0.95; // 5% discount
        return "Purchase Value is " . $purchaseValue . ", discount is 5%. Price after discount is " . number_format($discountedPrice, 2) . ".";
        
    } else {
        return "Purchase Value is " . $purchaseValue . ", there are no discount.";
    }
}

// Example usage
echo checkDiscount(300); //Purchase Value is 300, discount is 5%. Price after discount is 285.00.
echo "\n";
echo checkDiscount(80);  //Purchase Value is 80, there are no discount.   
echo "\n";
echo checkDiscount(500); //Purchase Value is 500, discount is 10%. Price after discount is 450.00.
echo "\n";
echo checkDiscount("a"); //Invalid input: The input must be a number.   

?>