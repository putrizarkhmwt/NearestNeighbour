<?php 
	$n = $_POST['k'];
	$txt_file1    = file_get_contents('data_20.txt');
	$rows1        = explode("\n", $txt_file1); // Memisahkan Item Data dariPemisah enter
	$txt_file2    = file_get_contents('data_80.txt');
	$rows2        = explode("\n", $txt_file2); // Memisahkan Item Data dariPemisah enter
	$j=0;
	$class = '';
	
	$dt=1;
	foreach($rows1 as $row1 => $data_test)
	{
		$row_data_test= explode('|', $data_test);// Memisahkan Item Data dariPemisah |
		echo "Label Lama Data Ke-".$dt." adalah ".$row_data_test[2]."<br>";
		$dt++;
	}
	echo "<br><hr>";
	
	//proses
	foreach($rows1 as $row1 => $data_test)
	{
		$i=0;
		$row_data_test= explode('|', $data_test);// Memisahkan Item Data dariPemisah |
		foreach($rows2 as $row2 => $data_train)
		{
			$row_data_train= explode('|', $data_train);// Memisahkan Item Data dariPemisah |
			$jarak[$i]['jarak'] = sqrt(pow((floatval($row_data_test[0])- floatval($row_data_train[0])),2) + pow((floatval($row_data_test[1])- floatval($row_data_train[1])),2));
			$jarak[$i]['label'] = $row_data_train[2];
			//echo $jarak[$i]['jarak']." = ".$jarak[$i]['label']."<br>";
			$i++;
		}
		//menentukan nilai paling kecil
		$k=0;
		$flag = true;
		$tempjarak=0;
		$templbl=0;
		//echo "<br><br>";
		while($flag)
		{
		  $flag = false;
		  for( $k=0;  $k < count($jarak)-1; $k++)
		  {
			if ( $jarak[$k]['jarak'] > $jarak[$k+1]['jarak'] )
			{
			  $tempjarak = $jarak[$k]['jarak'];
			  $templbl= $jarak[$k]['label'];
			  $jarak[$k]['jarak'] = $jarak[$k+1]['jarak'];
			  $jarak[$k]['label'] = $jarak[$k+1]['label'];
			  $jarak[$k+1]['jarak']=$tempjarak;
			  $jarak[$k+1]['label']=$templbl;
			  $flag = true; 
			}
			//echo $jarak[$k]['jarak']." = ".$jarak[$k]['label']."<br>";
		  }
		}
		//echo "<br><br>";
		for($k=0;$k<$n;$k++){
			$min_jarak[$k]['jarak'] = $jarak[$k]['jarak'];
			$min_jarak[$k]['label'] = $jarak[$k]['label'];
			//echo "baru ".$min_jarak[$k]['jarak']." = ".$min_jarak[$k]['label']."<br>";
		}
		//echo "<br><br>";
		$lbl[0] = 0;
		$lbl[1] = 0;
		$lbl[2] = 0;
		$lbl[3] = 0;
		for($k=0;$k<$n;$k++){
			if($min_jarak[$k]['label']==1)
				$lbl[0]++;
			if($min_jarak[$k]['label']==2)
				$lbl[1]++;
			if($min_jarak[$k]['label']==3)
				$lbl[2]++;
			if($min_jarak[$k]['label']==4)
				$lbl[3]++;
		}
		$jml_lbl= max($lbl);
		for($k=0; $k<4;$k++){
			if($lbl[$k]==$jml_lbl){
				$index = $k;
				break;
			}
		}		
		if($index==0){
			$lbl_baru = 1;
		}else if($index==1){
			$lbl_baru = 2;
		}else if($index==2){
			$lbl_baru = 3;
		}else{
			$lbl_baru = 4;
		}
		$dt_baru[$j]['lbl_tes'] = $row_data_test[2];
		$dt_baru[$j]['lbl_train'] = $lbl_baru;
		$j++;
	}
	//menampilkan label baru dan menghitung error
	$dt=1;
	$error = 0;
	for($i=0;$i<count($rows1);$i++)
	{
		echo "Data Ke-".$dt." = ".$dt_baru[$i]['lbl_tes']." , ".$dt_baru[$i]['lbl_train']."<br>";
		if($dt_baru[$i]['lbl_tes']!=$dt_baru[$i]['lbl_train']){
			$error++;
		}
		$dt++;
	}
	echo "<br><hr>";
	
	//hasil presentase
	$hasil = ($error/14) * 100;
	echo "<br>Presentase error data diatas adalah ".$hasil."%<br>";
?>
<html>
<body>
<a href="index.php">kembali<<</a>
</body>
</html>