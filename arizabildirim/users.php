<?php  

include 'config.php';
include 'functions.php';

if(isset($_GET['ID'])){
    $ID = cleanData($_GET['ID'], 1);
    $usersInfo = usersFindID($ID);

    if (isset($_POST['guncelle'])) {
        usersEdit($ID);
    }
}

$error = usersAdd();
print_r($error);

//print_r($_GET);
if ($_GET['func']=='Delete') {
    $ID = $_GET['ID'];

    usersDelete($ID); 
}

$usersList = usersList();



?>

<?php include 'header.php'; ?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> <?php echo ($ID > 0 ? "Kullanıcı Güncelle":"Kullanıcı Ekle") ?></h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                        class="glyphicon glyphicon-cog"></i></a>
                        <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                            <a href="#" class="btn btn-close btn-round btn-default"><i
                                class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                            <form action="users.php<?php if($ID > 0) echo '?ID='.$ID; ?>" method="POST" role="form">
                                <div class="form-group">
                                    <label for="">Adı</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="username" value="<?php echo $usersInfo['username']; ?>" placeholder="Adınızı Giriniz">
                                </div>
                                <div class="form-group">
                                    <label for="">Soyadı</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="surname" value="<?php echo $usersInfo['surname']; ?>" placeholder="Soyadınızı Giriniz">
                                </div>
                                <?php if ($ID > 0) { ?>
                                    <div class="form-group">
                                        <label for="">Adres</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="address" value="<?php echo $usersInfo['address']; ?>" placeholder="Adres Giriniz">
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <label for="">Telefon</label>
                                    <input type="tel" class="form-control myphone" id="exampleInputEmail1" name="phone" value="<?php echo $usersInfo['phone']; ?>" placeholder="Telefon Numarası Giriniz (0555-555-5555)">
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label" for="selectError">Durumunuz</label>
                                    <div class="controls">
                                        <select id="selectError" name="status" style="max-width: 100%" class="form-control">
                                            <option value="1" <?php echo ($usersInfo['status'] == 1 ? "selected":"") ?>>Aktif</option>
                                            <option value="0" <?php echo ($usersInfo['status'] == 0 ? "selected":"") ?>>Pasif</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <input type="hidden" name="ID" value="<?php echo $ID; ?>"> -->
                                <button type="submit" name="<?php echo ($ID > 0 ? "guncelle":"ekle") ?>" class="btn btn-default"><?php echo ($ID > 0 ? "Güncelle":"Ekle") ?></button>
                            </form>
                            <?php 
                            foreach($error['errEmpty'] as $val){
                                print "<div class='alert alert-danger'>".$val."</div>";
                            }
                            ?>
                            <?php 
                            foreach($error['errOther'] as $val){
                                print "<div class='alert alert-warning'>".$val."</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!--/span-->

            </div><!--/row-->

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">
                        <div class="box-header well" data-original-title="">
                            <h2><i class="glyphicon glyphicon-user"></i> Kullanıcılar</h2>

                            <div class="box-icon">
                                <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
                                <a href="#" class="btn btn-minimize btn-round btn-default"><i
                                    class="glyphicon glyphicon-chevron-up"></i></a>
                                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="alert alert-info">For help with such table please check <a href="http://datatables.net/" target="_blank">http://datatables.net/</a></div>
                                <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                    <thead>
                                        <tr>
                                            <th>Adı Soyadı</th>
                                            <th>Kayıt Tarihi</th>
                                            <th>Arıza Bildirim Sayısı</th>
                                            <th>Telefon Numarası</th>
                                            <th>Durumu</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($usersList as $row) {
                                                $resultArizaCount = $db->prepare("SELECT user_id FROM arizalar WHERE user_id=?");
                                                $resultArizaCount->execute(array($row['ID']));
                                                $lineArizaCount = $resultArizaCount->rowCount();
                                                /*if($row['status']==1) {
                                                    echo 'aktif';
                                                }else {
                                                    echo 'pasif';
                                                }*/
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['username']." ".$row['surname']; ?></td>
                                                    <td class="center"><?php echo $row['create_date']; ?></td>
                                                    <td class="center"><?php echo $lineArizaCount ?></td>
                                                    <td class="center"><?php echo $row['phone']; ?></td>
                                                    <td class="center">
                                                        <?php echo ($row['status']==1?'<span class="label-success label label-default">Aktif</span>':'<span class="label-danger label label-default">Pasif</span>') ?>
                                                    </td>
                                                    <td class="center">
                                                        <a class="btn btn-success" href="#">
                                                            <i class="glyphicon glyphicon-zoom-in icon-white"></i>
                                                            Görüntüle
                                                        </a>
                                                        <a class="btn btn-info" href="users.php?ID=<?php echo $row['ID']; ?>">
                                                            <i class="glyphicon glyphicon-edit icon-white"></i>
                                                            Düzenle
                                                        </a>
                                                        <a class="btn btn-danger" href="users.php?func=Delete&ID=<?php echo $row['ID']; ?>">
                                                            <i class="glyphicon glyphicon-trash icon-white"></i>
                                                            Sil
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }  
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/span-->

                    </div><!--/row-->

                    <?php include 'footer.php'; ?>
