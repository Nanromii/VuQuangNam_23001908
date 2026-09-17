<?php

/* =========================================================
   BÀI 1. LÀM QUEN VỚI BIẾN, MẢNG VÀ VÒNG LẶP
   ========================================================= */

echo "Bài 1<br><br>";

$studentsBai1 = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

$totalScoreBai1 = 0;

foreach ($studentsBai1 as $student) {
    echo "Họ tên: " . $student["name"] . "<br>";
    echo "Tuổi: " . $student["age"] . "<br>";
    echo "Điểm: " . $student["score"] . "<br>";
    echo "-------------------------<br>";

    $totalScoreBai1 += $student["score"];
}

$averageScoreBai1 = $totalScoreBai1 / count($studentsBai1);

echo "Điểm trung bình: " . number_format($averageScoreBai1, 2) . "<br>";

echo "<br><hr><br>";


/* =========================================================
   BÀI 2. TÁCH HÀM XỬ LÝ SINH VIÊN
   ========================================================= */

echo "Bài 2<br><br>";

$studentsBai2 = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

function calculateAverageScore($students)
{
    if (count($students) === 0) {
        return 0;
    }

    $totalScore = 0;

    foreach ($students as $student) {
        $totalScore += $student["score"];
    }

    return $totalScore / count($students);
}

function getRank($score)
{
    if ($score >= 8) {
        return "Giỏi";
    }

    if ($score >= 6.5) {
        return "Khá";
    }

    if ($score >= 5) {
        return "Trung bình";
    }

    return "Yếu";
}

function displayStudent($student)
{
    echo "Họ tên: " . $student["name"] . "<br>";
    echo "Tuổi: " . $student["age"] . "<br>";
    echo "Điểm: " . $student["score"] . "<br>";
    echo "Xếp loại: " . getRank($student["score"]) . "<br>";
    echo "-------------------------<br>";
}

foreach ($studentsBai2 as $student) {
    displayStudent($student);
}

$averageScoreBai2 = calculateAverageScore($studentsBai2);

echo "Điểm trung bình: " . number_format($averageScoreBai2, 2) . "<br>";

echo "<br><hr><br>";


/* =========================================================
   BÀI 3. XỬ LÝ DANH SÁCH SINH VIÊN
   ========================================================= */

echo "Bài 3<br><br>";

$studentsBai3 = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

function findBestStudent($students)
{
    if (count($students) === 0) {
        return null;
    }

    $bestStudent = $students[0];

    foreach ($students as $student) {
        if ($student["score"] > $bestStudent["score"]) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}

function findWorstStudent($students)
{
    if (count($students) === 0) {
        return null;
    }

    $worstStudent = $students[0];

    foreach ($students as $student) {
        if ($student["score"] < $worstStudent["score"]) {
            $worstStudent = $student;
        }
    }

    return $worstStudent;
}

function countPassedStudents($students)
{
    $count = 0;

    foreach ($students as $student) {
        if ($student["score"] >= 5) {
            $count++;
        }
    }

    return $count;
}

function findStudentByName($students, $name)
{
    foreach ($students as $student) {
        if (strcasecmp($student["name"], $name) === 0) {
            return $student;
        }
    }

    return null;
}

$bestStudentBai3 = findBestStudent($studentsBai3);

if ($bestStudentBai3 !== null) {
    echo "Sinh viên có điểm cao nhất: "
        . $bestStudentBai3["name"]
        . " - Tuổi: " . $bestStudentBai3["age"]
        . " - Điểm: " . $bestStudentBai3["score"]
        . "<br>";
}

$worstStudentBai3 = findWorstStudent($studentsBai3);

if ($worstStudentBai3 !== null) {
    echo "Sinh viên có điểm thấp nhất: "
        . $worstStudentBai3["name"]
        . " - Tuổi: " . $worstStudentBai3["age"]
        . " - Điểm: " . $worstStudentBai3["score"]
        . "<br>";
}

$passedCountBai3 = countPassedStudents($studentsBai3);

echo "Số sinh viên đạt: " . $passedCountBai3 . "<br>";

$searchNameBai3 = "Tran Thi Binh";
$foundStudentBai3 = findStudentByName($studentsBai3, $searchNameBai3);

if ($foundStudentBai3 !== null) {
    echo "Sinh viên tìm được: "
        . $foundStudentBai3["name"]
        . " - Tuổi: " . $foundStudentBai3["age"]
        . " - Điểm: " . $foundStudentBai3["score"]
        . "<br>";
} else {
    echo "Không tìm thấy sinh viên: " . $searchNameBai3 . "<br>";
}

echo "<br><hr><br>";


/* =========================================================
   BÀI 4. CHUYỂN SANG LẬP TRÌNH HƯỚNG ĐỐI TƯỢNG (OOP)
   ========================================================= */

echo "Bài 4<br><br>";

class Student
{
    public $name;
    public $age;
    public $score;

    public function __construct($name, $age, $score)
    {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }

    public function getRank()
    {
        if ($this->score >= 8) {
            return "Giỏi";
        }

        if ($this->score >= 6.5) {
            return "Khá";
        }

        if ($this->score >= 5) {
            return "Trung bình";
        }

        return "Yếu";
    }

    public function isPassed()
    {
        return $this->score >= 5;
    }

    public function display()
    {
        echo "Họ tên: " . $this->name . "<br>";
        echo "Tuổi: " . $this->age . "<br>";
        echo "Điểm: " . $this->score . "<br>";
        echo "Xếp loại: " . $this->getRank() . "<br>";
        echo "Kết quả: " . ($this->isPassed() ? "Đạt" : "Không đạt") . "<br>";
        echo "-------------------------<br>";
    }
}

function findBestStudentObject($students)
{
    if (count($students) === 0) {
        return null;
    }

    $bestStudent = $students[0];

    foreach ($students as $student) {
        if ($student->score > $bestStudent->score) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}

function countPassedStudentObjects($students)
{
    $count = 0;

    foreach ($students as $student) {
        if ($student->isPassed()) {
            $count++;
        }
    }

    return $count;
}

function calculateAverageScoreObjects($students)
{
    if (count($students) === 0) {
        return 0;
    }

    $totalScore = 0;

    foreach ($students as $student) {
        $totalScore += $student->score;
    }

    return $totalScore / count($students);
}

$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);

$studentsBai4 = [
    $student1,
    $student2,
    $student3,
    $student4
];

foreach ($studentsBai4 as $student) {
    $student->display();
}

$bestStudentBai4 = findBestStudentObject($studentsBai4);

if ($bestStudentBai4 !== null) {
    echo "Sinh viên có điểm cao nhất: "
        . $bestStudentBai4->name
        . " - Tuổi: " . $bestStudentBai4->age
        . " - Điểm: " . $bestStudentBai4->score
        . "<br>";
}

$passedCountBai4 = countPassedStudentObjects($studentsBai4);
echo "Số sinh viên đạt: " . $passedCountBai4 . "<br>";

$averageScoreBai4 = calculateAverageScoreObjects($studentsBai4);
echo "Điểm trung bình: " . number_format($averageScoreBai4, 2) . "<br>";

?>
