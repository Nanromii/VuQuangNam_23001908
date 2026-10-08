<?php
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function validProductInput($name, $price, $quantity)
{
    $errors = [];
    if ($name === '') {
        $errors[] = 'Tên sản phẩm không được để trống.';
    } elseif (mb_strlen($name, 'UTF-8') > 100) {
        $errors[] = 'Tên sản phẩm không được vượt quá 100 ký tự.';
    }

    if (filter_var($price, FILTER_VALIDATE_FLOAT) === false || !is_finite((float)$price) || (float)$price <= 0 || (float)$price > 99999999.99 || !preg_match('/^\d+(?:\.\d{1,2})?$/D', $price)) {
        $errors[] = 'Giá phải là số lớn hơn 0, tối đa 2 chữ số thập phân.';
    }
    if (filter_var($quantity, FILTER_VALIDATE_INT) === false || (int)$quantity < 0 || (int)$quantity > 2147483647) {
        $errors[] = 'Số lượng phải là số nguyên không âm.';
    }
    return $errors;
}

function productIdFromGet()
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false || $id === null ? null : $id;
}
