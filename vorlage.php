<?php
include ('config.php');
include ('head.php');
include ('navigation.php');
echo '<div id="content">';
if ($_SESSION['Login'])
  {
					$i=1;
					$option = range(1, 6);
					shuffle($options);
					foreach ($option as $no) {
					$_SESSION['fragen'][$i]="aw0".$no;
					$i++;
					echo "postition ".$no." frage".$i."<br/>";}
  }
    else header('location:index.php');
include ('footer.php');
?>