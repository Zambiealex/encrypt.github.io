<?php
$x = (10*1*2016*21.15) * 2322;
for($i = 1; $i <= 6; $i++)
{
		$do = ($i * 46) * ($i * 45) * ($i * 44) * ($i * 43) * ($i * 42) * ($i * 41) / ($x*46);
		echo $i . '. '. $do . '<br>';
}

?>