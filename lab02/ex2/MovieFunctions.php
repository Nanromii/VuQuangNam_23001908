<?php

declare(strict_types=1);

require_once __DIR__ . '/Movie.php';

/**
 * Tìm phim theo ID.
 *
 * @param Movie[] $movies
 */
function findMovieById(array $movies, $id): ?Movie
{
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        return null;
    }

    $id = (int) $id;

    foreach ($movies as $movie) {
        if ($movie instanceof Movie && $movie->getId() === $id) {
            return $movie;
        }
    }

    return null;
}

/**
 * Tính tổng doanh thu của tất cả phim.
 * Danh sách rỗng trả về 0.
 *
 * @param Movie[] $movies
 */
function getTotalRevenue(array $movies): float
{
    $totalRevenue = 0.0;

    foreach ($movies as $movie) {
        if ($movie instanceof Movie) {
            $totalRevenue += $movie->getRevenue();
        }
    }

    return $totalRevenue;
}

/**
 * Tìm phim bán được nhiều vé nhất.
 * Danh sách rỗng trả về null.
 * Nếu có nhiều phim cùng số vé bán cao nhất, trả về phim xuất hiện trước.
 *
 * @param Movie[] $movies
 */
function getBestSellingMovie(array $movies): ?Movie
{
    $bestSellingMovie = null;

    foreach ($movies as $movie) {
        if (!$movie instanceof Movie) {
            continue;
        }

        if (
            $bestSellingMovie === null
            || $movie->getSoldSeats() > $bestSellingMovie->getSoldSeats()
        ) {
            $bestSellingMovie = $movie;
        }
    }

    return $bestSellingMovie;
}
