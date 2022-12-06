<?php  

function cleanData($str, $int=0) {
	if($int==1){
		return intval($str);
	}
	else{
		return strip_tags(trim($str));
	}
}
function usersFindID($ID) {
	global $db;


	if(!is_numeric($ID)){
		exit("Numeric değer değil");
	}

	$ID = cleanData($ID, 1);

	$result = $db->prepare("SELECT * FROM users WHERE ID = ?");
	$result->execute(array($ID));
	$line = $result->fetch(PDO::FETCH_ASSOC);

	return $line;
}
function usersList() {
	global $db;

	$result = $db->prepare("SELECT * FROM users");
	$result->execute();
	$line = $result->fetchAll(PDO::FETCH_ASSOC);

	return $line;
}

function usersDelete($ID) {
	global $db;


	if(!is_numeric($ID)){
		exit("Numeric değer değil");
	}

	$ID = intval($ID);
	
	$result = $db->prepare("DELETE FROM users WHERE ID=?");
	if($result->execute(array($ID))) {
		return true;
	}else{
		return false;
	}
}

function usersAdd() {
	global $db;

	$errEmpty = array();
	$errOther = array();

	if (isset($_POST['ekle'])) {
		$username = cleanData($_POST['username']);
		$surname = cleanData($_POST['surname']);
		$phone = cleanData($_POST['phone']);
		$status = cleanData($_POST['status'], 1);

		if (empty($username)) {
			$errEmpty[] = "Kullancı Adı  alanını doldurunuz.";
		}
		if (empty($surname)) {
			$errEmpty[] = "Soyadı alanları doldurunuz.";
		}
		if (empty($surname)) {
			$errEmpty[] = "Telefon numarasını doldurunuz.";
		}

		if(strlen($username) < 2){
			$errOther[] = "Kullanıcı adı 2 den büyük olmalı";
		}
		
		if(count($errEmpty) == 0 && count($errOther) == 0)
		{
			$resultCount = $db->prepare("SELECT ID FROM users WHERE username = ? AND surname = ? AND phone = ?");
			$resultCount->execute(array($username, $surname, $phone));
			if($resultCount->rowCount() > 0)
			{
				$errOther[] = "Kullanıcı Mevcut";
			}
			else{
				$sorgu = $db->prepare("INSERT INTO users(username, surname, phone, status) VALUES(?,?,?,?) ");

				$ekle = $sorgu->execute([$username, $surname, $phone, $status]);
				if ($ekle) {
					header('location: users.php?func=Add');
				} else {
					$hata = $sorgu->errorInfo();
					echo 'mysql Hatası'.$hata[2];
				}
				
			}
		}
		
		return array("errOther"=>$errOther, "errEmpty"=>$errEmpty);
	}
}

function usersEdit($ID) {
	global $db;

	if (isset($_POST['guncelle'])) {
		$username = cleanData($_POST['username']);
		$surname = cleanData($_POST['surname']);
		$status = cleanData($_POST['status'], 1);
		$address = cleanData($_POST['address']);
		$phone = cleanData($_POST['phone']);

		$sorgu = $db->prepare("UPDATE users SET username=?, surname=?, status=?, address=?, phone=? WHERE ID = ?");

		$ekle = $sorgu->execute([$username, $surname, $status, $address, $phone, $ID]);

		if ($ekle) {
			header('location: users.php?func=Add');
		} else {
			$hata = $sorgu->errorInfo();
			echo 'mysql Hatası'.$hata[2];
		}
	}
}



function arizalarList() {
	global $db;

	$result = $db->prepare("SELECT users.ID AS users_id, users.username, users.surname, users.status, users.phone, arizalar.ID as arizalar_id, arizalar.kod, arizalar.arizatip_id, arizalar.durum, arizalar.create_date FROM `users` INNER JOIN arizalar ON users.ID=arizalar.user_id");
	$result->execute();
	$line = $result->fetchAll(PDO::FETCH_ASSOC);

	return $line;
}


// $arizatip[1] = "Mikrofon Arıza";
// $arizatip[2] = "Haporlar Arıza";
function getArizatip() {
	global $db;

	$result = $db->query("SELECT * FROM arizatip");
	$line = $result->fetchAll(PDO::FETCH_ASSOC);

	foreach ($line as $row) {
		$arrayStatus[$row['ID']] = $row['name'];
	}
	return $arrayStatus;
}

function getArizadurum() {
	global $db;

	$result = $db->query("SELECT * FROM arizadurum");
	$line = $result->fetchAll(PDO::FETCH_ASSOC);

	foreach ($line as $row) {
		$arrayStatus[$row['ID']] = $row['name'];
	}
	return $arrayStatus;
}

function arizalarAdd() {
	global $db;

	$errEmpty = array();
	$errOther = array();

	if (isset($_POST['ekle'])) {
		$user_id = cleanData($_POST['user_id'],1);
		$durum = cleanData($_POST['durum'],1);
		$arizatip_id = cleanData($_POST['arizatip_id'],1);
		$detay = cleanData($_POST['detay']);

		if (empty($user_id)) {
			$errEmpty[] = "Kullancı Adı  seçiniz.";
		}
		if (empty($durum)) {
			$errEmpty[] = "Durum alanını seçiniz.";
		}
		if (empty($arizatip_id)) {
			$errEmpty[] = "Arıza tipini seçiniz.";
		}
		if (empty($detay)) {
			$errEmpty[] = "Detay alanını doldurunuz.";
		}
		
		if(count($errEmpty) == 0 && count($errOther) == 0)
		{
			//$kod = time()."-".generateRandomString(4);
			$kod = date("YmdHis")."-".generateRandomString(4);
			$sorgu = $db->prepare("INSERT INTO arizalar(user_id, kod, arizatip_id, durum, detay, create_date) VALUES(?,?,?,?,?,NOW()) ");

			$ekle = $sorgu->execute([$user_id, $kod, $arizatip_id, $durum, $detay]);
			if ($ekle) {
				header('location: arizalar.php?func=Add');
			} else {
				$hata = $sorgu->errorInfo();
				echo 'mysql Hatası'.$hata[2];
			}				
		}
		
		return array("errOther"=>$errOther, "errEmpty"=>$errEmpty);
	}
}

function generateRandomString($length = 10) {
	$characters = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;	
}

?>