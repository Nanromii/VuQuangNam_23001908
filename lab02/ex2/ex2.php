<?php

declare(strict_types=1);

require_once __DIR__ . '/MovieFunctions.php';

function printOutput(string $content = ''): void
{
    if (PHP_SAPI === 'cli') {
        echo $content . PHP_EOL;
        return;
    }

    echo nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8')) . '<br>';
}

function formatCurrency(float $amount): string
{
    return number_format($amount, 0, ',', '.') . ' VNĐ';
}

/**
 * Thực hiện thao tác đặt vé và hiển thị thông báo thân thiện.
 */
function tryBookTicket(Movie $movie, $quantity): void
{
    try {
        $movie->bookTicket($quantity);
        printOutput("- Đặt thành công {$quantity} vé cho phim {$movie->getTitle()}.");
    } catch (InvalidArgumentException | RuntimeException $exception) {
        printOutput("- Không thể đặt vé cho {$movie->getTitle()}: {$exception->getMessage()}");
    }
}

/**
 * Thực hiện thao tác hủy vé và hiển thị thông báo thân thiện.
 */
function tryCancelTicket(Movie $movie, $quantity): void
{
    try {
        $movie->cancelTicket($quantity);
        printOutput("- Hủy thành công {$quantity} vé của phim {$movie->getTitle()}.");
    } catch (InvalidArgumentException | RuntimeException $exception) {
        printOutput("- Không thể hủy vé của {$movie->getTitle()}: {$exception->getMessage()}");
    }
}

printOutput('=== BÀI 2: QUẢN LÝ VÉ XEM PHIM ===');

try {
    // 1. Tạo danh sách ít nhất 03 object Movie theo dữ liệu mẫu của đề.
    $movies = [
        new Movie(1, 'Avengers', 100000, 100),
        new Movie(2, 'Avatar', 120000, 80),
        new Movie(3, 'Batman', 90000, 120),
    ];

    // 2. Tìm phim rồi đặt vé cho Avengers.
    $avengers = findMovieById($movies, 1);
    if ($avengers !== null) {
        tryBookTicket($avengers, 30);
    }

    // 3. Đặt vé cho Avatar.
    $avatar = findMovieById($movies, 2);
    if ($avatar !== null) {
        tryBookTicket($avatar, 45);
    }

    // 4. Hủy một số vé đã đặt của Avengers.
    if ($avengers !== null) {
        tryCancelTicket($avengers, 5);
    }

    // 5. Hiển thị thông tin tất cả phim.
    printOutput("\n1. Thông tin các phim:");
    foreach ($movies as $movie) {
        printOutput($movie->displayInfo());
    }

    // 6. Tính tổng doanh thu của tất cả phim.
    printOutput('2. Tổng doanh thu: ' . formatCurrency(getTotalRevenue($movies)));

    // 7. Tìm phim bán được nhiều vé nhất.
    $bestSellingMovie = getBestSellingMovie($movies);
    if ($bestSellingMovie !== null) {
        printOutput(
            '3. Phim bán được nhiều vé nhất: '
            . $bestSellingMovie->getTitle()
            . ' (' . $bestSellingMovie->getSoldSeats() . ' vé)'
        );
    } else {
        printOutput('3. Không có phim để xác định phim bán chạy nhất.');
    }
} catch (InvalidArgumentException $exception) {
    printOutput('Lỗi dữ liệu khởi tạo phim: ' . $exception->getMessage());
}

// ------------------------------------------------------------
// Kiểm tra các trường hợp bắt buộc phải xử lý theo đề bài.
// ------------------------------------------------------------
printOutput("\n=== KIỂM TRA TRƯỜNG HỢP NGOẠI LỆ ===");

if (isset($avengers) && $avengers instanceof Movie) {
    tryBookTicket($avengers, 0);       // Đặt <= 0 vé.
    tryBookTicket($avengers, -2);      // Đặt số vé âm.
    tryBookTicket($avengers, 1000);    // Đặt vượt số ghế còn lại.

    tryCancelTicket($avengers, 0);     // Hủy <= 0 vé.
    tryCancelTicket($avengers, -1);    // Hủy số vé âm.
    tryCancelTicket($avengers, 1000);  // Hủy vượt số vé đã bán.
}

$missingMovie = findMovieById($movies ?? [], 999);
if ($missingMovie === null) {
    printOutput('- Không tìm thấy phim có ID = 999.');
}

$emptyMovies = [];
printOutput('- Tổng doanh thu khi danh sách phim rỗng: ' . formatCurrency(getTotalRevenue($emptyMovies)));

$bestOfEmptyList = getBestSellingMovie($emptyMovies);
if ($bestOfEmptyList === null) {
    printOutput('- Không thể tìm phim bán chạy nhất vì danh sách phim đang rỗng.');
}

$movieFromEmptyList = findMovieById($emptyMovies, 1);
if ($movieFromEmptyList === null) {
    printOutput('- Không tìm thấy phim trong danh sách rỗng.');
}
