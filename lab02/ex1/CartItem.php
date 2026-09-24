<?php

declare(strict_types=1);

/**
 * Đại diện cho một sản phẩm trong giỏ hàng.
 */
class CartItem
{
    private string $name;
    private float $price;
    private int $quantity;

    /**
     * @throws InvalidArgumentException Khi dữ liệu sản phẩm không hợp lệ.
     */
    public function __construct($name, $price, $quantity)
    {
        $name = is_string($name) ? trim($name) : '';

        if ($name === '') {
            throw new InvalidArgumentException('Tên sản phẩm không được để trống.');
        }

        if (!is_numeric($price) || (float) $price <= 0) {
            throw new InvalidArgumentException('Đơn giá sản phẩm phải lớn hơn 0.');
        }

        if (filter_var($quantity, FILTER_VALIDATE_INT) === false || (int) $quantity <= 0) {
            throw new InvalidArgumentException('Số lượng sản phẩm phải là số nguyên lớn hơn 0.');
        }

        $this->name = $name;
        $this->price = (float) $price;
        $this->quantity = (int) $quantity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Trả về thành tiền của sản phẩm: price × quantity.
     */
    public function getTotal(): float
    {
        return $this->price * $this->quantity;
    }
}
