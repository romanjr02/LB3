<?php
    include('connect.php');
    if (isset($_POST["date"]))
    {
        $date = $_POST["date"];
        $sth = $dbh->prepare("SELECT name, date_start, time_start, cost FROM cars INNER JOIN rent ON ID_Cars=FID_Car WHERE ? BETWEEN date_start and date_end");
        
        $sth->execute([$date]);

        echo "<h4>Доход с проката по состоянию на ".date ( 'd-m-Y H:i:s' , strtotime($date)). "</h4>";
        $str = "<table style='text-align: center'>";
        $str .= " <tr>
             <th> Name  </th>
             <th> Cost </th>
            </tr> ";
        while ($data = $sth->fetch()) {
            $cost = (strtotime($date) - strtotime($data["date_start"]."T".$data["time_start"]))/3600*$data["cost"];
            $str .= " <tr>
                 <td> {$data['name']}  </td>
                 <td> {$cost} </td>
                </tr> ";
        }
        $str .= "</table>";
        echo $str;
    }
    elseif (isset($_POST["vendor"]))
    {
        $vendor = $_POST["vendor"];
        $sth = $dbh->prepare("SELECT name, release_date, race FROM cars WHERE FID_Vendors=?");
        $sth->execute([$vendor]);
        
        $str = "<table style='text-align: center'>";
        $str .= " <tr>
         <th> Name  </th>
         <th> Release Date </th>
         <th> Race </th>
        </tr> ";
        while ($data = $sth->fetch()) 
        {
             $str .= " <tr>
             <td> {$data['name']}  </td>
             <td> {$data['release_date']} </td>
             <td> {$data['race']} </td>
             </tr> ";
        }
    $str .= "</table>";
    echo json_encode($str);
    }
    elseif (isset($_POST["free_car"]))
    {
        $free_car = $_POST["free_car"];
        $sth = $dbh->prepare("SELECT name, release_date, race FROM cars INNER JOIN rent ON ID_Cars=FID_Car WHERE ? NOT BETWEEN date_start and date_end");
        $sth->execute([$free_car]);

        echo "<h4>Свободные автомобили на ".$free_car."</h4>";
        $str = "<table style='text-align: center'>";
        $str .= " <tr>
         <th> Name  </th>
         <th> Release Date </th>
         <th> Race </th>
        </tr> ";
        while ($data = $sth->fetch()) 
        {
            $str .= " <tr>
             <td> {$data['name']}  </td>
             <td> {$data['release_date']} </td>
             <td> {$data['race']} </td>
            </tr> ";
        }
        $str .= "</table>";
        echo $str;
    }
?>