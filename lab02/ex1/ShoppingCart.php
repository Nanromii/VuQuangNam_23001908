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

    private static function padText(string $text, int $width): string
    {
        $length = mb_strlen($text, 'UTF-8');

        // Nếu nội dung dài hơn kích thước ô thì cắt bớt
        if ($length > $width) {
            $text = mb_substr($text, 0, $width - 3, 'UTF-8') . '...';
            $length = mb_strlen($text, 'UTF-8');
        }

        return $text . str_repeat(' ', $width - $length);
    }

    public function displayCart(): string
    {
        if (empty($this->items)) {
            return "Giỏ hàng hiện đang trống.\nTổng tiền: 0 VNĐ\n";
        }

        // Độ rộng từng cột
        $sttWidth = 5;
        $nameWidth = 25;
        $priceWidth = 18;
        $quantityWidth = 12;
        $totalWidth = 20;

        $separator =
            '+' . str_repeat('-', $sttWidth + 2) .
            '+' . str_repeat('-', $nameWidth + 2) .
            '+' . str_repeat('-', $priceWidth + 2) .
            '+' . str_repeat('-', $quantityWidth + 2) .
            '+' . str_repeat('-', $totalWidth + 2) .
            "+\n";

        $output = $separator;

        $output .=
            '| ' . self::padText('STT', $sttWidth) .
            ' | ' . self::padText('Tên sản phẩm', $nameWidth) .
            ' | ' . self::padText('Đơn giá', $priceWidth) .
            ' | ' . self::padText('Số lượng', $quantityWidth) .
            ' | ' . self::padText('Thành tiền', $totalWidth) .
            " |\n";

        $output .= $separator;

        foreach ($this->items as $index => $item) {
            $output .=
                '| ' . self::padText((string) ($index + 1), $sttWidth) .
                ' | ' . self::padText($item->getName(), $nameWidth) .
                ' | ' . self::padText(
                    self::formatCurrency($item->getPrice()),
                    $priceWidth
                ) .
                ' | ' . self::padText(
                    (string) $item->getQuantity(),
                    $quantityWidth
                ) .
                ' | ' . self::padText(
                    self::formatCurrency($item->getTotal()),
                    $totalWidth
                ) .
                " |\n";
        }

        $output .= $separator;

        $output .= 'Tổng tiền: '
            . self::formatCurrency($this->calculateTotal())
            . "\n";

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
