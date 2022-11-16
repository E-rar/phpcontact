<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,400;1,500;1,700;1,900&family=Saira+Condensed&display=swap" rel="stylesheet">
</head>
<style>
    *{
       font-family: 'Roboto', sans-serif;
       margin:0;
    }
    .main {
        display:flex;
        width:80vw;
        margin-left:10vw;
    }
    .navbar{
        background-color: #7D0990;
        height:100vh;
        padding-top:120px;
        position:fixed;
        top:0;
        left:0;
        
    }
    .navbar a {
        text-decoration:none;
        display:block;
        color:white;
        padding:9% 6%;
        display:flex;
        align-items:center;

    }
    img {
        color:#FFF;
        width:20%;
        padding-right:12%;
    }
    .content{
        width:30vw;
    }
    .content form div {
        margin:13%;
    }
    h1{
        margin:13%;
        width:100%;
    }
    input{
        padding: 3%;
    }
    button {
        margin-left:13%;
        background-color: #7D0990;
        color:#FFF;
        border:none;
        padding:4%;
        border-radius:12px;
    }

    button:hover{
        background-color: #AE0BC9;
        cursor:pointer;
    }

    .card{
        background-color: rgba(0,0,0,0.05);
        margin-bottom:3%;
        border-radius:8px;
        padding : 8%;
        margin-left:13%;
        display:flex;
        justify-content: space-between;
        align-items : center;
    }

    .card a {
        text-decoration: none;
        color:#FFF;
        background-color:#7D0990;
        padding:3%;
        border-radius:14px;
    }

    .card a:hover{
        background-color:#AE0BC9;
    }

    .profile-picture{
        width:48px;
        height:48px;
        border-radius:50%;
        border:2px solid #FFF;
        padding:0%;

    }

</style>
<body>
<div class="main">
    <div class="nav">
    <nav class="navbar navbar-default navbar-">
        <a href="index.php?page=start"><img src="img/home.svg"/>Start</a>
        <a href="index.php?page=contacts"><img src="img/contacts.svg"/>Contacts</a>
        <a href="index.php?page=addcontact"><img src="img/add.svg"/>Kontakt hinzufügen</a>
        <a href="index.php?page=legal"><img src="img/legal.svg"/>Impressum</a>
    </nav>
    </div>
    <div class="content">
    <?php

    $headline = 'Herzlich Willkommen';
    $contacts = [];

    if(file_exists('contacts.txt')){
        $text = file_get_contents('contacts.txt',true);
        $contacts = json_decode($text,true);
    }

    if(isset($_POST['name']) && isset($_POST['phone'])){
        echo 'kontakt ' .$_POST['name'].' wurde hinzugefügt';
        $newContact = [
            'name' => $_POST['name'],
            'phone' => $_POST['phone']
        ];
        array_push($contacts,$newContact);
        file_put_contents('contacts.txt', json_encode($contacts,JSON_PRETTY_PRINT));
    }

    if($_GET['page'] == 'contacts'){
        $headline = 'Deine Kontakte';
    } 
    if($_GET['page'] == 'legal'){
        $headline = 'Impressum';
    }
    if($_GET['page'] == 'start'){
        $headline = 'Startseite';
    }
    if($_GET['page'] == 'addcontact'){
        $headline = 'Kontakt hinzufügen ';
    }
    echo '<h1>' . $headline .'</h1>';

    if($_GET['page'] == 'legal'){
        $headline = 'Impressum';
    }
    if($_GET['page'] == 'start'){
        $headline = 'Startseite';
    }
    if($_GET['page'] == 'addcontact'){
       echo "
       <form action='?page=contacts' method='POST'>
            <div>
                <input placeholder='Namen eingeben' name='name'>
            </div>
            <div>
                <input placeholder='Telefonnummer eingeben' name='phone'>
            </div>
            <button type='submit'> Absenden </button>
       </form>
       ";
    }

    if ($_GET['page'] == 'delete') {
        echo "
            <p>Dein Kontakt wurde gelöscht und sie werden in wenigen Sekunden wieder auf Contacts weitergeleitet</p>
            <script>
            setTimeout(location.href='http://localhost/phpcontact/index.php?page=contacts', 30000);
            </script>
        ";
        # Wir laden die Nummer der Reihe aus den URL Parametern
        $index = $_GET['delete']; 

        # Wir löschen die Stelle aus dem Array 
        unset($contacts[$index]); 

        # Tabelle erneut speichern in Datei contacts.txt
        file_put_contents('contacts.txt', json_encode($contacts, JSON_PRETTY_PRINT));
    }else if($_GET['page'] == 'contacts'){
        foreach ( $contacts as  $index=>$row){
            $name = $row['name'];
            $phone = $row['phone'];
            echo "
            <div class ='card'> 
                <img class='profile-picture' src='img/profile-picture.png'/>
                <div>
                " 
                . $name . "<br>" 
                . $phone .
            "</div>
            <a class='deletebtn' href='?page=delete&delete=$index'>Löschen</a>
            </div>";
        }
    } 

    
?>
</div>
</div>
</body>
</html>