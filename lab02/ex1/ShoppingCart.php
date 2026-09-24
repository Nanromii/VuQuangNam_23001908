<?php

declare(strict_types=1);

require_once __DIR__ . '/CartItem.php';

/**
 * Quản lý danh sách các CartItem trong giỏ hàng.
 */
class ShoppingCart
{
    /** @var CartItem[] */
    private array $items = [];

    public function addItem(CartItem $item): void
    {
        $this->items[] = $item;
    }

    /**
     * Xóa sản phẩm đầu tiên khớp tên.
     *
     * @return bool true nếu xóa thành công, false nếu không tìm thấy.
     */
    public function removeItem($name): bool
    {
        $name = is_string($name) ? trim($name) : '';

        if ($name === '') {
            return false;
        }

        foreach ($this->items as $index => $item) {
            if (strcasecmp($item->getName(), $name) === 0) {
                array_splice($this->items, $index, 1);
                return true;
            }
        }

        return false;
    }

    /**
     * Tính tổng tiền bằng cách gọi getTotal() của từng CartItem.
     */
    public function calculateTotal(): float
    {
        $total = 0.0;

        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

    /**
     * Tạo chuỗi hiển thị toàn bộ giỏ hàng.
     */
    public function displayCart(): string
    {
        if (empty($this->items)) {
            return "Giỏ hàng hiện đang trống.\nTổng tiền: 0 VNĐ\n";
        }

        $output = sprintf(
            "%-4s | %-22s | %-14s | %-10s | %-16s\n",
            'STT',
            'Tên sản phẩm',
            'Đơn giá',
            'Số lượng',
            'Thành tiền'
        );
        $output .= str_repeat('-', 78) . "\n";

        foreach ($this->items as $index => $item) {
            $output .= sprintf(
                "%-4d | %-22s | %-14s | %-10d | %-16s\n",
                $index + 1,
                $item->getName(),
                self::formatCurrency($item->getPrice()),
                $item->getQuantity(),
                self::formatCurrency($item->getTotal())
            );
        }

        $output .= str_repeat('-', 78) . "\n";
        $output .= 'Tổng tiền: ' . self::formatCurrency($this->calculateTotal()) . "\n";

        return $output;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    private static function formatCurrency(float $amount): string
    {
        return number_format($amount, 0, ',', '.') . ' VNĐ';
    }
}
