<?php
include "db.php";

if(isset($_POST['submit'])){

$name = $_POST['name'];
$department = $_POST['department'];

$stmt = $conn->prepare(
"INSERT INTO students(name,department)
VALUES(?,?)"
);

$stmt->bind_param("ss",$name,$department);

$stmt->execute();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Add Student</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card shadow p-4">

<h2>Add Student</h2>

<form method="POST">

<div class="mb-3">

<label>Name</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Department</label>

<input
type="text"
name="department"
class="form-control"
required>

</div>

<button
type="submit"
name="submit"
class="btn btn-primary">

Save Student

</button>

<a href="index.php"
class="btn btn-secondary">
Dashboard
</a>

</form>

</div>

</div>

</body>
</html>