<?php

include "db.php";

$date = date("Y-m-d");

if(isset($_POST['save'])){

foreach($_POST['status'] as $id => $status){

$check = mysqli_query(

$conn,

"SELECT *
FROM attendance

WHERE student_id='$id'
AND attendance_date='$date'"

);


// UPDATE EXISTING ATTENDANCE

if(mysqli_num_rows($check) > 0){

mysqli_query(

$conn,

"UPDATE attendance

SET status='$status'

WHERE student_id='$id'
AND attendance_date='$date'"

);

}

// INSERT NEW ATTENDANCE

else{

mysqli_query(

$conn,

"INSERT INTO attendance
(student_id,attendance_date,status)

VALUES
('$id','$date','$status')"

);

}

}


// REFRESH PAGE AFTER SAVE

header("Location: attendance.php?saved=1");

exit();

}


$students =
mysqli_query(
$conn,
"SELECT * FROM students ORDER BY name ASC"
);

?>

<!DOCTYPE html>
<html>

<head>

<title>Take Attendance</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
background:#eef2f7;
font-family:Arial;
}

.card{
border-radius:20px;
}

.table th{
background:#0d6efd;
color:white;
}

.btn-save{
padding:12px 40px;
font-size:18px;
border-radius:10px;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="card shadow p-4">

<div class="d-flex justify-content-between">

<h2>
<i class="fa fa-calendar-check text-success"></i>
Take Attendance
</h2>

<a href="index.php"
class="btn btn-dark">
Dashboard
</a>

</div>

<p class="mt-3">

Today's Date:
<b><?php echo $date; ?></b>

</p>


<?php if(isset($_GET['saved'])){ ?>

<div class="alert alert-success">

Attendance Saved Successfully

</div>

<?php } ?>


<form method="POST">

<table class="table table-bordered table-hover">

<tr>

<th>Name</th>
<th>Department</th>
<th>Status</th>

</tr>

<?php while($row=mysqli_fetch_assoc($students)){ ?>

<?php

$student_id = $row['id'];

$existing = mysqli_query(

$conn,

"SELECT status
FROM attendance

WHERE student_id='$student_id'
AND attendance_date='$date'"
);

$attendance = mysqli_fetch_assoc($existing);

$current_status =
$attendance['status'] ?? 'Present';

?>

<tr>

<td>
<?php echo $row['name']; ?>
</td>

<td>
<?php echo $row['department']; ?>
</td>

<td>

<select
name="status[<?php echo $row['id']; ?>]"
class="form-select">

<option value="Present"

<?php
if($current_status=="Present")
echo "selected";
?>

>
Present
</option>

<option value="Absent"

<?php
if($current_status=="Absent")
echo "selected";
?>

>
Absent
</option>

</select>

</td>

</tr>

<?php } ?>

</table>

<div class="text-center">

<button
type="submit"
name="save"
class="btn btn-success btn-save">

Save Attendance

</button>

</div>

</form>

</div>

</div>

</body>
</html>