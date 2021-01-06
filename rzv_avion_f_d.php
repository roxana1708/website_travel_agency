<?php 
    echo "asaasdfsv";
    include 'functions.php';
    //echo "asaasdfsv";
    
    //include 'db_connections.php';
    //echo "asaasdfsv";

    session_start();

    

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    } else if ($_SESSION["user_type"] != "admin" && $_SESSION["user_type"] != "angajat") {
        echo "Nu ai drepturi pentru a vizualiza aceasta pagina.";
        exit;
    }

    if(isset($_SESSION['err_msg'])) {
        //$tip_serv_err = $_SESSION['err_msg']['tip_serv_err'];
        $nr_pers_err = $_SESSION['err_msg']['nr_pers_err'];
        $date_err = $_SESSION['err_msg']['date_err'];
        $departure_err = $_SESSION['err_msg']['departure_err'];
        $arrival_err = $_SESSION['err_msg']['arrival_err'];
        $duplicate_err = $_SESSION['err_msg']['duplicate_err'];
        $availability_err = $_SESSION['err_msg']['availability_err'];
        $username_client_err = $_SESSION['err_msg']['username_client_err'];
        unset($_SESSION['err_msg']);
    }


    $user_type = $_SESSION["user_type"];
/*
    $link = db_Connect();

    $query = "SELECT nume_destinatie FROM Destinatii"; 
*/

    $result1 = show_dest_list();
    $result2 = show_dest_list();


?>

<!DOCTYPE html>
<html>
<head>
    <title>Rezervare</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div>
        <h1>Buna, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>! Unde plecam?</h1>
    </div>
    <p>
        <a href="logout.php">Sign Out of Your Organizer Account</a>
    </p>

    <form action="rzv_a_f_d_action_form.php" method="post">

        <div>
            <label>Username-ul clientului pentru care se face rezervarea:</label>
            <input type="text" name="username" class="form-control">
            <span style="color:red"><?php echo $username_client_err ?></span>
        </div>

        <div>
            <label>Alege orasul de plecare:</label>
            <select id="plecare" name="plecare" class="col-xs-2 px-lg-5">
                <?php
                    if ($result1->num_rows > 0) {
                        //echo "string";
                        while($row = $result1->fetch_assoc()) {
                            echo '<option value="' . $row['nume_destinatie'] . '">' . $row['nume_destinatie'] . '</option>';
                        }
                    } else {
                        echo 'Eroare';
                    }
                ?>
            </select>
            <span style="color:red"><?php echo $departure_err ?></span>
        </div>

        <div>
            <label>Alege destinatia dorita:</label>
            <select id="destinatie" name="destinatie" class="col-xs-2 px-lg-5">
                <?php
                    if ($result2->num_rows > 0) {
                        //echo "string";
                        while($row = $result2->fetch_assoc()) {
                            echo '<option value="' . $row['nume_destinatie'] . '">' . $row['nume_destinatie'] . '</option>';
                        }
                    } else {
                        echo 'Eroare';
                    }
                ?>
            </select>
            <span style="color:red"><?php echo $arrival_err ?></span>
        </div>
        
        <div>
            <label>Alege data plecarii:</label>
            <input type="text" name="data_plecare" placeholder="Perioada" id="startDatePicker" class="col-xs-2 px-lg-5">
        </div>
        
        <div>
            <label>Alege data intoarcerii:</label>
            <input type="text" name="data_intoarcere" placeholder="Perioada" id="endDatePicker" class="col-xs-2 px-lg-5">
            <span style="color:red"><?php echo $date_err ?></span>
        </div>

        <div>
            <label>Alege numarul de participanti:</label>
            <input type="number" name="nr_pers" min="1" max="40">
            <span style="color:red"><?php echo $nr_pers_err ?></span>
        </div>

        <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Rezerva">
        </div>
        <span style="color:red"><?php echo $duplicate_err ?></span>
        <span style="color:red"><?php echo $availability_err ?></span>
    </form>
    <script src="agentieturism.js"></script>
</body>
</html>