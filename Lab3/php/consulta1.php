<html>
<body>

<?php
$buscar = $_POST['T1'];
if (!isset($buscar)){
      echo "Debe especificar una cadena a bucar";
      echo "</html></body> \n";
      exit;
}
$link = mysql_connect($server = "kali",$username= "db2014_g05", $password = "FFPR14");
mysql_select_db("db2014_g05", $link);
$result = mysql_query("
/*Consulta*/
select Cuit, Razon_social, sum(cantidad) as total_maquinas
from (Cliente natural join ClienteMaquina) natural join (
    select Cuit
    from VendedorCliente
    where Cuil = $buscar) 
    as clientes_de_vendedor
group by Cuit
order by total_maquinas asc
", $link);
if ($row = mysql_fetch_array($result)){
      echo "<table border = '1'> \n";
//Mostramos los nombres de las tablas
echo "<tr> \n";
while ($field = mysql_fetch_field($result)){
            echo "<td>$field->name</td> \n";
}
      echo "</tr> \n";
do {
            echo "<tr> \n";
            echo "<td>".$row["Razon_social"]."</td> \n";
            echo "<td>".$row["Cuit"]."</td> \n";
            echo "<td>".$row["total_maquinas"]."</td> \n";
            echo "</tr> \n";
      } while ($row = mysql_fetch_array($result));
            echo "</table> \n";
} else {
echo utf8_decode("¡No se ha encontrado ningún registro!");
}
?>
</body>
</html>