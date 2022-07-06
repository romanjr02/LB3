<?php
include('connect.php');
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LB3</title>
    <script src="script.js"></script>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<form action="" method="post" id="date">
    Получить доход с проката по состоянию на выбранную дату:
        <input type="datetime-local" name="date">
        <button>OK</button>
</form>
<br>
<form action="" method="post" id="vendor">
    Получить автомобили выбранного производителя:
    <select name="vendor">
        <?php
            $sth = $dbh->query("SELECT DISTINCT * FROM vendors");
            while ($date = $sth->fetch()) 
            {
                echo "<option value='$date[0]'>$date[1]</option>";
            }
        ?>
    </select>
    <button>OK</button>
</form>
<br>
<form action="" method="post" id="free_car">
    Получить свободные автомобили на выбранную дату:  
    <input type="date" name="free_car">
    <button>OK</button>
</form>
<br>
<form action="" method="post">
    Добавить информации об аренде для выбранного автомобиля на указанные даты: 
    <select name="car">
        <?php
            $sth = $dbh->query("SELECT DISTINCT ID_Cars, name FROM cars");
            while ($date = $sth->fetch()) 
            {
                echo "<option value='$date[0]'>$date[1]</option>";
            }
        ?>
    </select>
    <input type="date" name="date_start">
    <input type="date" name="date_end">
    <input type="number" name="cost">
    <button>OK</button>
</form>
<br>
<form action="" method="post">
    Измененить данные о пробеге для выбранного автомобиля: 
    <select name="updateCar">
        <?php
            $sth = $dbh->query("SELECT DISTINCT ID_Cars, name FROM cars");
            while ($date = $sth->fetch()) 
            {
                echo "<option value='$date[0]'>$date[1]</option>";
            }
        ?>
    </select>
    <input type="number" name="race">
    <button>OK</button>
</form>
<br>
<div id="content"></div>
<?php
if (isset($_POST["car"])) 
{
    $car = $_POST["car"];
    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    $cost = $_POST["cost"];
    $sth = $dbh->prepare("INSERT INTO rent (FID_Car, date_start, date_end, cost) VALUES (?, ?, ?, ?)");
    $sth->execute([$car, $date_start, $date_end, $cost]);
} 
elseif (isset($_POST["updateCar"])) 
{
    $updateCar = $_POST["updateCar"];
    $race = $_POST["race"];
    $sth = $dbh->prepare("UPDATE cars SET race = ? WHERE ID_Cars = ?");
    $sth->execute([$race, $updateCar]);
}
?>
<br>
</body>
</html>

