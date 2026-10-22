<?php
$name = "Vũ Quang Nam";
$score = 10.0;
$rank = "";

if ($score >= 8) {
    $rank = "Gioi";
} elseif ($score >= 6.5) {
    $rank = "Kha";
} elseif ($score >= 5) {
    $rank = "Trung binh";
} else {
    $rank = "Yeu";
}

echo "Ten hoc sinh: " . $name . "<br>";
echo "Diem: " . $score . "<br>";
echo "Xep loai: " . $rank;
?>