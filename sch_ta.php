<?
include_once "__RootDIR__.php";
include_once $RootDIR."/_global/_header.php";

$table_schema = 'pentasec'; //검색할 DB
$sqry = " like 'License%'"; //찾을 조건

$query = "select * from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA = '".$table_schema."' ";
$result = mysql_query($query);

while($row = mysql_fetch_array($result)) $tables[$row['TABLE_NAME']] []= $row['COLUMN_NAME'];

ob_start();
ob_implicit_flush(true);
$r = str_repeat("\r", 4096 ); //화면 표시를 위한 버버채우기용 문자

foreach( $tables as $tkey1=>$tval1 )
{
  foreach( $tval1 as $tkey2=>$tval2 )
  {
    $query = "select count(*) from ".$table_schema.".".$tkey1." where ".$tval2." ".$sqry." limit 1";

	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$affect_num = $row[0];

	if($affect_num) {
   
      echo "Table : <b>".$tkey1."</b> Column : <b>".$tval2."</b> - ".$query."<br>";
      
      //업데이트도 해주려면 아래처럼 해주면 된다.
//      $uqry = "update ".$table_schema.".".$tkey1." set `".$tval2."` = '바꿀문자열' where `".$tval2."`".$sqry;
//      $result= $conn->query( $uqry );
//      if(DB::isError($result)) die($result->getMessage());
      
      echo $r ;
      ob_flush();
      usleep(100000);
    }
  }
}

ob_end_flush();
?>