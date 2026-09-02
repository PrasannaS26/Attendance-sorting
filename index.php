<?php
include "db.php";

$total_students =
mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM students")
);

$total_present =
mysqli_num_rows(
mysqli_query(
$conn,
"SELECT * FROM attendance
WHERE status='Present'
AND attendance_date=CURDATE()"
)
);

$total_absent =
mysqli_num_rows(
mysqli_query(
$conn,
"SELECT * FROM attendance
WHERE status='Absent'
AND attendance_date=CURDATE()"
)
);

?>

<!DOCTYPE html>
<html>

<head>

<title>Smart Attendance System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
background:#eef2f7;
font-family:Arial;
}

.card-box{
border-radius:20px;
transition:0.3s;
}

.card-box:hover{
transform:translateY(-5px);
}

.navbar{
background:#0d6efd;
}

.navbar-brand{
color:white !important;
font-size:24px;
font-weight:bold;
}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg">

<div class="container">

<a class="navbar-brand">
Smart Attendance Dashboard
</a>

</div>

</nav>

<div class="container mt-5">

<div class="row">

<div class="col-md-4">

<div class="card shadow card-box p-4">

<h3>Total Students</h3>

<h1><?php echo $total_students; ?></h1>

<i class="fa fa-users fa-3x text-primary"></i>

</div>

</div>

<div class="col-md-4">

<div class="card shadow card-box p-4">

<h3>Present Today</h3>

<h1><?php echo $total_present; ?></h1>

<i class="fa fa-check-circle fa-3x text-success"></i>

</div>

</div>

<div class="col-md-4">

<div class="card shadow card-box p-4">

<h3>Absent Today</h3>

<h1><?php echo $total_absent; ?></h1>

<i class="fa fa-times-circle fa-3x text-danger"></i>

</div>

</div>

</div>

<hr class="my-5">

<div class="row text-center">

<div class="col-md-4">

<a href="add_student.php"
class="btn btn-primary btn-lg w-100 p-4">

<i class="fa fa-user-plus"></i>
<br><br>
Add Student

</a>

</div>

<div class="col-md-4">

<a href="attendance.php"
class="btn btn-success btn-lg w-100 p-4">

<i class="fa fa-calendar-check"></i>
<br><br>
Take Attendance

</a>

</div>

<div class="col-md-4">

<a href="report.php"
class="btn btn-dark btn-lg w-100 p-4">

<i class="fa fa-chart-bar"></i>
<br><br>
View Reports

</a>

</div>

</div>

</div>

</body>
</html>