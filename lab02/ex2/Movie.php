<?php

declare(strict_types=1);

/**
 * Đại diện cho một bộ phim và trạng thái đặt vé của phim đó.
 */
class Movie
{
    private int $id;
    private string $title;
    private float $price;
    private int $totalSeats;
    private int $availableSeats;

    /**
     * @throws InvalidArgumentException Khi dữ liệu phim không hợp lệ.
     */
    public function __construct($id, $title, $price, $totalSeats)
    {
        $title = is_string($title) ? trim($title) : '';

        if (filter_var($id, FILTER_VALIDATE_INT) === false || (int) $id <= 0) {
            throw new InvalidArgumentException('Mã phim phải là số nguyên lớn hơn 0.');
        }

        if ($title === '') {
            throw new InvalidArgumentException('Tên phim không được để trống.');
        }

        if (!is_numeric($price) || (float) $price <= 0) {
            throw new InvalidArgumentException('Giá vé phải lớn hơn 0.');
        }

        if (filter_var($totalSeats, FILTER_VALIDATE_INT) === false || (int) $totalSeats <= 0) {
            throw new InvalidArgumentException('Tổng số ghế phải là số nguyên lớn hơn 0.');
        }

        $this->id = (int) $id;
        $this->title = $title;
        $this->price = (float) $price;
        $this->totalSeats = (int) $totalSeats;
        $this->availableSeats = $this->totalSeats;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getTotalSeats(): int
    {
        return $this->totalSeats;
    }

    public function getAvailableSeats(): int
    {
        return $this->availableSeats;
    }

    /**
     * Đặt vé và giảm số ghế còn lại.
     *
     * @throws InvalidArgumentException Nếu quantity không hợp lệ.
     * @throws RuntimeException Nếu số vé muốn đặt vượt quá số ghế còn lại.
     */
    public function bookTicket($quantity): void
    {
        $quantity = $this->validateQuantity($quantity, 'Số vé đặt');

        if ($quantity > $this->availableSeats) {
            throw new RuntimeException(
                "Không đủ ghế. Chỉ còn {$this->availableSeats} ghế trống."
            );
        }

        $this->availableSeats -= $quantity;
    }

    /**
     * Hủy vé đã đặt và tăng số ghế còn lại.
     *
     * @throws InvalidArgumentException Nếu quantity không hợp lệ.
     * @throws RuntimeException Nếu số vé muốn hủy vượt quá số vé đã bán.
     */
    public function cancelTicket($quantity): void
    {
        $quantity = $this->validateQuantity($quantity, 'Số vé hủy');
        $soldSeats = $this->getSoldSeats();

        if ($quantity > $soldSeats) {
            throw new RuntimeException(
                "Không thể hủy {$quantity} vé vì phim chỉ mới bán {$soldSeats} vé."
            );
        }

        $this->availableSeats += $quantity;
    }

    public function getSoldSeats(): int
    {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue(): float
    {
        return $this->getSoldSeats() * $this->price;
    }

    /**
     * Tạo chuỗi thông tin đầy đủ của phim.
     */
    public function displayInfo(): string
    {
        return implode(PHP_EOL, [
            "Mã phim        : {$this->id}",
            "Tên phim       : {$this->title}",
            'Giá vé         : ' . self::formatCurrency($this->price),
            "Tổng số ghế    : {$this->totalSeats}",
            "Ghế còn lại    : {$this->availableSeats}",
            'Số vé đã bán   : ' . $this->getSoldSeats(),
            'Doanh thu      : ' . self::formatCurrency($this->getRevenue()),
        ]) . PHP_EOL;
    }

    private function validateQuantity($quantity, string $label): int
    {
        if (filter_var($quantity, FILTER_VALIDATE_INT) === false || (int) $quantity <= 0) {
            throw new InvalidArgumentException("{$label} phải là số nguyên lớn hơn 0.");
        }

        return (int) $quantity;
    }

    private static function formatCurrency(float $amount): string
    {
        return number_format($amount, 0, ',', '.') . ' VNĐ';
    }
}
