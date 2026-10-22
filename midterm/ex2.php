<?php
$prices = [10000, 25000, 15000, 50000, 30000];

function calculateTotal($prices) {
    $total = 0;
    foreach ($prices as $price) {
        $total += $price;
    }
    return $total;
}

function findMaxPrice($prices) {
    $maxPrice = $prices[0];
    for ($i = 1; $i < count($prices); $i++) {
        if ($maxPrice < $prices[$i]) {
            $maxPrice = $prices[$i];
        }
    }
    return $maxPrice;
}

$total = calculateTotal($prices);
$maxPrice = findMaxPrice($prices);

echo "Tong gia tri san pham: " . $total . "<br>";
echo "Gia san pham cao nhat: " . $maxPrice;
?>