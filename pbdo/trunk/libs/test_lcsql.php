<?

include('./lc_SQL.php');


$s = new SelectStatement("banners");
print_r($s);
$s->fields = array("pkey","placementID","shown");
print $s->toString();

?>

