<?php 
	//error_reporting(0);
	$n = $_POST['k'];
	$txt_file1    = file_get_contents('data_20.txt');
	$rows1        = explode("\n", $txt_file1); // Memisahkan Item Data dariPemisah enter
	$txt_file2    = file_get_contents('data_80.txt');
	$rows2        = explode("\n", $txt_file2); // Memisahkan Item Data dariPemisah enter
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
	$j=0;
	foreach($rows1 as $row1 => $data_test)
	{
		$i=0;
		$row_data_test= explode('|', $data_test);// Memisahkan Item Data dariPemisah |
		foreach($rows2 as $row2 => $data_train)
		{
			$row_data_train= explode('|', $data_train);// Memisahkan Item Data dariPemisah |
			$jarak[$i][0] = sqrt(pow((floatval($row_data_test[0])- floatval($row_data_train[0])),2) + pow((floatval($row_data_test[1])- floatval($row_data_train[1])),2));
			$jarak[$i][1] = $row_data_train[2];
			//echo $jarak[$i][0]." = ".$jarak[$i][1]."<br>";
			$i++;
		}
		//echo "<br>";
		//menentukan nilai paling kecil
		for($k=0; $k<$row2; $k++){
			$banding[$k] = $jarak[$k][0];
			//echo "banding = ".$banding[$k]."<br>";
		}
		//sort data
		sort($banding);
		for($l=0;$l<$n;$l++){
			$min_jarak[$l] = $banding[$l];
			//echo "minjarak = ".$min_jarak[$l]."<br>";
		}
		//cari label
		for($l=0;$l<$n;$l++){
			for($k=0; $k<$row2; $k++){
				if($min_jarak[$l]==$jarak[$k][0]){
					$label_baru[$l] = $jarak[$k][1];
				}
			}
			//echo "label baru= ".$label_baru[$l]."<br>";
		}
		for($a=0;$a<$n;$a++)
		{
			$count[$a]=0;
			for($b=0;$b<$n;$b++)
			{
				if($label_baru[$b]==$label_baru[$a])
				{ 
					$count[$a]++; 
				}
			}
		}
		//Mencari Count Terbanyak
		$indeks=0;$modus=0;
		for ($a=0;$a<$n;$a++)
		{
			if($modus<$count[$a])
			{ 
				$modus=$count[$a]; 
				$indeks=$a;
			}
		}
		$class_baru[$j] = $label_baru[$indeks];
		//echo $label_baru[$indeks]."<br>";
		$j++;
	}
	
	
	
	//menampilkan label baru
	$dt=1;
	for($i=0;$i<count($rows1);$i++)
	{
		echo "Label Baru Data Ke-".$dt." adalah ".$class_baru[$i]."<br>";
		$dt++;
	}
	echo "<br><hr>";
	
	$dt=0;
	$error=0;
	//mengecek data dan menentukan tingkat error
	foreach($rows1 as $row1 => $data_test){
		$row_data_test= explode('|', $data_test);// Memisahkan Item Data dariPemisah |
		if($row_data_test[2]!=$class_baru[$dt]){
			$error++;
		}
	}
	//echo $error;
	//hasil presentase
	$hasil = ($error/14) * 100;
	echo "<br>Presentase error data diatas adalah ".$hasil."%<br>";
?>