<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<?php
$db = parse_url(getenv("DATABASE_URL"));
$pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));
$stmt = $pdo->query("SELECT * FROM tareas");
echo "<h1>Lista de Tareas</h1>";
echo"<form method='POST' action='/'>";
echo "&nbsp";
echo"<label>Añadir Tarea</label>";
echo "<input type='text' style=' width: 20% ' class='form-control' name='tareaNueva'>";
echo "&nbsp";
echo "<br>";
echo"<input type='submit' class='btn btn-success' value='Añadir' name='botonInsertar'>";	
echo "</form>";
if (isset($_POST['botonInsertar'])) {
    $nuevaTarea1=$_POST['tareaNueva'];
    $sentencia = $pdo->prepare("INSERT INTO tareas (name) VALUES (:tarea)");
    $sentencia->bindParam(':tarea', $tarea);
    $tarea = $nuevaTarea1;
    $sentencia->execute();
    header("Location: /");
}
echo"<ol>";
echo"<form method='POST' action='/'>";
while ($row = $stmt->fetch()) {
	echo "<li>";
    echo $row['name'];
    echo "&nbsp";
    echo"<input type='button' class='btn btn-danger' value='Eliminar' name='botonEliminar' onclick=location.href='/?id=".$row['id']."'         >";
    echo "<br>";
    echo "</li>";
}
echo "</ol>";
echo "</form>";
$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$id=explode('=', $url);
if (isset($id)) {
    $id1=$id[1];
    $sentencia = $pdo->prepare("DELETE FROM tareas WHERE id=:id");
    $sentencia->bindParam(':id',$id1);
    $sentencia->execute();
    if($sentencia->rowCount()==0){
       echo " ";
    }else{
        header("Location: /"); 
        echo "ENTRAS!!!!!!!!";
    }
    
    
}
?>
