<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
            <img src="logo.png" alt="logo">
    </header>

    <nav>
        <p style = "postion: absolute; float: left; display: inline; padding: 10px; border: 0px;">KOLORY: </p>

        <?php
            $servername = "localhost";
            $username = "root";
            $bd = "produkty";
            
            $conn = mysqli_connect($servername, $username, '' ,$bd);
            
            if (!$conn) {
                die("connection failed" . mysqli_connect_error());
            }
            
            
            $sql = "select id, kolor from kolor";
           
            $query = mysqli_query($conn, $sql);
            
     
            
        if(isset($_GET['kolor']) && ($_GET['kolor'] != NULL)){
            $sel = $_GET["kolor"];
           
            $ide = "select id, kolor from kolor where kolor = '$sel'";
            
            $zap = mysqli_query($conn, $ide);
            $get = mysqli_fetch_array($zap);

            echo "<div class = 'nav1'><ul><li> $get[kolor] </li></ul></div>";
        } else{
                    while($row = mysqli_fetch_array($query)){ 
                        echo "<a href = index.php?kolor=$row[kolor]><div class = 'nav1'><ul><li> $row[kolor] </li></ul></div></a> ";                                         
                    }
                }    
        ?>

    </nav>
     
    <div class="container">
        <section style = "height: 100%;">
            <p style = "border: 0px;">PRODUKTY: </p>

            <?php
            $sql = "select nazwa from prod";
            $query = mysqli_query($conn, $sql);
           
            if(isset($_GET['nazwa']) && ($_GET['nazwa'] != NULL)){
                $sel = $_GET["nazwa"];
                
                $ide = "select nazwa from prod where nazwa = '$sel'";
                
                $zap = mysqli_query($conn, $ide);
                $get = mysqli_fetch_array($zap);

                echo "<div class = 'nav1'><ul><li> $get[nazwa] </li></ul></div>";
            } else{
                        while($row = mysqli_fetch_array($query)){ 
                            echo "<a href = index.php?nazwa=$row[nazwa]><div class = 'nav1'><ul><li> $row[nazwa] </li></ul></div></a>";                                         
                        }
                    }    
            ?>

        </section>
        
        <div class="cont">
        <main style = " border-top: 0px;">
            <h1 style = "border: 0px;">KOLORY PRODUKTÓW</h1>
            <div class = "table1">
            <?php
                $form = "select kolor from kolor";
                $query_f = mysqli_query($conn, $form);
            ?>

            <form action="index.php" method="POST">
                    <label for="nazwa">nazwa: </lable>
                    <input type="text" id="nazwa" name="nazwa"><br>
                    <label for="kolor">kolor: </label>
                        <select name="kolor" id="kolor">
                            <option style="text-align: center;" type="hidden"></option>
                            <?php
                            while($fetchForm = mysqli_fetch_array($query_f)){
                                echo "<option value=$fetchForm[kolor]>$fetchForm[kolor]</option>/n";
                            }
                            ?>
                        </select><br>
                    <label for="sort">sortowanie nazw: </label>
                    <input type="checkbox" id="sort" name="sort" value="check"><br>
                    <input type="submit" value="wyślij">
                    
            </form>

            <table>   
                <tr>
                    <th>#</th>
                    <th>PRODUKT</th>
                    <th>KOLOR</th>
                </tr>
                
                <?php              
                #error_reporting(0); 
                #wp_reset_postdata(); 
                    $nazwa = @$_POST['nazwa'];
                    $kolor = @$_POST['kolor'];
                    $sort = @$_POST['sort'];

                    $selpn = "select prod.id, nazwa, kolor from prod inner join kolor on prod.kolor_id = kolor.id where nazwa like '$nazwa%';";
                    $qn = mysqli_query($conn, $selpn);
                    $selpk = "select prod.id, nazwa, kolor from prod inner join kolor on prod.kolor_id = kolor.id where kolor = '$kolor';";
                    $qk = mysqli_query($conn, $selpk);
                    $selpnk = "select prod.id, nazwa, kolor from prod inner join kolor on prod.kolor_id = kolor.id where nazwa like '$nazwa%' && kolor = '$kolor';";
                    $qnk = mysqli_query($conn, $selpnk);

                    $selo = "select prod.id, nazwa, kolor from prod inner join kolor on prod.kolor_id = kolor.id order by nazwa asc;";
                    $qo = mysqli_query($conn, $selo);
                    $selpno = "select prod.id, nazwa, kolor from prod inner join kolor on prod.kolor_id = kolor.id where nazwa like '$nazwa%' order by nazwa asc;";
                    $qno = mysqli_query($conn, $selpno);
                    $selpko = "select prod.id, nazwa, kolor from prod inner join kolor on prod.kolor_id = kolor.id where kolor = '$kolor' order by nazwa asc;";
                    $qko = mysqli_query($conn, $selpko);
                    $selpnko = "select prod.id, nazwa, kolor from prod inner join kolor on prod.kolor_id = kolor.id where nazwa like '$nazwa%' && kolor = '$kolor' order by nazwa asc;";
                    $qnko = mysqli_query($conn, $selpnko);

                    if(isset($nazwa) && ($kolor) && ($nazwa != NULL) && ($kolor != NULL) && ($sort == TRUE)){
                        while($rnko = mysqli_fetch_array($qnko)){
                            echo "<tr><th> $rnko[id] </th><th> $rnko[nazwa] </th><th> $rnko[kolor] </th></tr>";
                        }
                    } elseif(isset($nazwa) && ($nazwa != NULL) && ($sort == TRUE)){
                        while($rno = mysqli_fetch_array($qno)){
                            echo "<tr><th> $rno[id] </th><th> $rno[nazwa] </th><th> $rno[kolor] </th></tr>";                           
                        }
                    } elseif(isset($kolor) && ($kolor != NULL) && ($sort == TRUE)){
                        while($rko = mysqli_fetch_array($qko)){
                            echo "<tr><th> $rko[id] </th><th> $rko[nazwa] </th><th> $rko[kolor] </th></tr>"; 
                        }
                    } elseif (isset($sort) && $sort == TRUE){
                        while($ro = mysqli_fetch_array($qo)){
                            echo "<tr><th> $ro[id] </th><th> $ro[nazwa] </th><th> $ro[kolor] </th></tr>";
                        }
                    }

                    else{
 
                    if(isset($nazwa) && ($kolor) && ($nazwa != NULL) && ($kolor != NULL)){
                        while($rnk = mysqli_fetch_array($qnk)){
                            echo "<tr><th> $rnk[id] </th><th> $rnk[nazwa] </th><th> $rnk[kolor] </th></tr>";
                        }
                    } elseif(isset($nazwa) && ($nazwa != NULL)){
                        while($rn = mysqli_fetch_array($qn)){
                            echo "<tr><th> $rn[id] </th><th> $rn[nazwa] </th><th> $rn[kolor] </th></tr>";                           
                        }
                    } elseif(isset($kolor) && ($kolor != NULL)){
                        while($rk = mysqli_fetch_array($qk)){
                            echo "<tr><th> $rk[id] </th><th> $rk[nazwa] </th><th> $rk[kolor] </th></tr>"; 
                        }
                    }

                    else{

                    $tab = "select kolor.id, prod.id, nazwa, kolor.kolor from prod inner join kolor on prod.kolor_id = kolor.id;";
                    $query_tab = mysqli_query($conn, $tab);

                    $getn = @$_GET['nazwa'];
                    $seln = "select kolor.id, prod.id, nazwa, kolor.kolor from prod inner join kolor on prod.kolor_id = kolor.id where nazwa = '$getn';";
                    $queryn = mysqli_query($conn, $seln);

                    $getk = @$_GET['kolor'];
                    $selk = "select kolor.id, prod.id, nazwa, kolor.kolor from prod inner join kolor on prod.kolor_id = kolor.id where kolor.kolor = '$getk';";
                    $queryk = mysqli_query($conn, $selk);

                    $sele = "select distinct kolor.id, prod.id, nazwa, kolor.kolor from prod inner join kolor on prod.kolor_id = kolor.id where kolor.kolor = '$getk' && nazwa = '$getn';";
                    $querye = mysqli_query($conn, $sele);

                    if(isset($_GET['nazwa']) && ($_GET['kolor'] != NULL) && ($_GET['nazwa'] != NULL) && ($_GET['kolor']) ){
                        while($odpe = mysqli_fetch_array($querye))
                            echo "<tr><th> $odpe[id] </th> <th> $odpe[nazwa] </th> <th> $odpe[kolor] </th></tr>";
                    } elseif (isset($_GET['nazwa']) && ($_GET['nazwa'] !=NULL)){
                        while($odpn = mysqli_fetch_array($queryn))
                            echo "<tr><th> $odpn[id] </th> <th> $odpn[nazwa] </th> <th> $odpn[kolor] </th></tr>";
                    } elseif (isset($_GET['kolor']) && ($_GET['kolor'] != NULL)){
                        while($odpk = mysqli_fetch_array($queryk))
                            echo "<tr><th> $odpk[id] </th> <th> $odpk[nazwa] </th> <th> $odpk[kolor] </th></tr>";
                    }elseif(isset($nazwa) && ($kolor)){
                        echo "<tr><th> $nazwa </th> <th>  </th> <th> $kolor </th></tr>";
                    } else{
                            while($odp = mysqli_fetch_array($query_tab))
                                echo "<tr><th> $odp[id] </th> <th> $odp[nazwa] </th> <th> $odp[kolor] </th></tr>";
                    }      
                    }    
                }
                ?>

             </table>
            </div> 
        </main>
        <footer>
            <p style = "border: 0px; text-align: center; margin-top: 5px;">© 2022 Damian </p>
        </footer>
        </div>
    </div>
</body>

<?php

mysqli_close($conn);
?>

</html>