<?php                                          
if (isset($_COOKIE['glos'])) {                                                 //Sprawdzenie wartości ciasteczka
    echo("Już głosowałeś!");
}
else{    
$servername = "localhost";                                                    //Łączenie z serwerem
$username = "root";
$password = "";
$dbname = "voting";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

switch ($_POST['glos']) {                                                          //Sprawdzenie wybranej opcji głosowania
  case "wpl":
    mysqli_query($conn,"UPDATE votes SET Glosy=Glosy+1 WHERE Partia='WPL';");
    break;
  case "klo":
    mysqli_query($conn,"UPDATE votes SET Glosy=Glosy+1 WHERE Partia='KLO';");
    break;
  case "ubg":
    mysqli_query($conn,"UPDATE votes SET Glosy=Glosy+1 WHERE Partia='UBG';");
    break;
  case "cgo";
  mysqli_query($conn,"UPDATE votes SET Glosy=Glosy+1 WHERE Partia='CGO';");
    break;
  default:
    echo "ERROR";
}
$zapytanie = "SELECT * FROM votes";                                         //Wyświetlanie obecnych wynikw głosownia w tabeli
$wynik = mysqli_query($conn,$zapytanie);        
$ile_znalezionych = $wynik->num_rows;
echo '<table>';
echo '<tr><td>Partia</td><td>Glosy</td></tr>';      
for ($i=0; $i <$ile_znalezionych; $i++)
        {
                $wiersz = $wynik->fetch_assoc();
                echo '<tr>';
                echo '<td>'.$wiersz['Partia'].'</td>';
                echo '<td>'.$wiersz['Glosy'].'</td>';
                echo '</tr>';
        }
echo '</table>';
setcookie("glos","1",time()+3600*24);                                   //Inicjacja ciasteczka
$conn->close();                                                         //Zakońcczenie połączenia z serwerem
}
?>