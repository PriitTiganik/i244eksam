<?php
connect_db();
$comments =array();


function alusta_sessioon(){
    // siin ees võiks muuta ka sessiooni kehtivusaega, aga see pole hetkel tähtis
    session_start();
    if(!isset($_SESSION["userid"])){
        $_SESSION["userid"]="";//as long as user is not logged in userid exists, but is blank
    }

}

function lopeta_sessioon(){
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
}

function upload_comment(){

    global $connection;
    $errors=array();
    include_once("head.html");

    if(!empty($_POST)) { //on sisse loginud ja vajutas uploadi nuppu
        if (empty($_POST["author"])) {
            $errors[] = "Missing author!";
        }
        if (empty($_POST["comment"])) {
            $errors[] = "Missing comment!";
        }
    }

    if(count($errors)==0&&!empty($_POST)) { //erroreid pole, insert
        $queryresult="";

        $author=htmlspecialchars(array('author',mysqli_real_escape_string($connection,$_POST["author"]))[1]);
        $comment=htmlspecialchars(array('comment',mysqli_real_escape_string($connection,$_POST["comment"]))[1]);

        $query="INSERT INTO ptiganik_comments (author, comment ) VALUES('$author', '$comment')";
        $queryresult=mysqli_query($connection, $query);

        if($queryresult){
            $queryresult='Comment uploaded! Please take a look at your and other comments:';
        }else {
            $queryresult='For some reason comment was not uploaded, but please see other comments:';
        }


        echo  '<span style="color:red">'.$queryresult.'</span></br>'; //annab teada, mida tehti
        print_errors($errors);

    }


}
function kuva_comments(){
    global $connection;
    global $comments;
    $comments=get_comments();

    echo '<h1>Comment table</h1>';
    //print_r($comments);
    echo '<table border="1">';
    echo '<td>Author</td><td>Comment</td><td>Time</td>';
    foreach($comments as $comment) {
        $autor=htmlspecialchars($comment["author"]);
        $comment_text=htmlspecialchars($comment["comment"]);
        $date=htmlspecialchars($comment["date"]);
        echo '<tr>';
        echo '<td>'.$autor.'</td><td class="comment">'. $comment_text.'</td><td>'.$date.'</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<a href="controller.php">Add another comment</a>';
    include_once("foot.html");
}
function print_errors($errors){
    echo '<span style="color:red">';
    foreach($errors as $error){
        echo $error.'</br>';
    }
    echo '</span>';
}

function kuva_insert(){
    include_once("head.html");
    include_once("insert_comment.html");
    include_once("foot.html");
}

function connect_db(){
    global $connection;
    $host="localhost";//"http://enos.itcollege.ee/phpmyadmin/";
    $user="test";
    $pass="t3st3r123";
    $db="test";
    $connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa mootoriga ühendust");
    mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function get_comments(){
    global $connection;
    //luua massiiv info hoidmiseks
    $comments = array();
    //Käivitada päring, mis hangib eelmisel korral loodud piltide tabelist kõik read.
    $query="select * from ptiganik_comments";
    $result =mysqli_query($connection, $query);

    //    Pärast päringu käivitamist kasutada tulemuste lugemiseks while tsüklit.
    while($row=mysqli_fetch_assoc($result)){ //Seni kuni on ridu, loe järgmine rida ja paiguta see eelnevalt loodud massiivi lõppu
        $comments[]=$row;
    }
    //funktsiooni lõpus tagastada täidetud massiiv
    return $comments;
}

function add_comment($user, $comment){

}

