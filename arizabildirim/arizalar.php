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

$error = arizalarAdd();
print_r($error);

//print_r($_GET);
if ($_GET['func']=='Delete') {
    $ID = $_GET['ID'];

    usersDelete($ID); 
}

$usersList = usersList();

$arizalarList = arizalarList();

$arizatip = getArizatip();
$arizadurum = getArizadurum();


?>

<?php include 'header.php'; ?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> <?php echo ($ID > 0 ? "Arıza Güncelle":"Arıza Ekle") ?></h2>

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
                            <form action="arizalar.php<?php if($ID > 0) echo '?ID='.$ID; ?>" method="POST" role="form">
                                <div class="form-group">
                                    <label for="">Kullanıcı Adı</label>
                                    <select class="form-control" style="max-width: 100%" name="user_id">
                                        <option value="">Seçiniz...</option>
                                        <?php foreach ($usersList as $value) { ?>
                                            <option value="<?php echo $value['ID'];?>"><?php echo $value['username']." ".$value['surname'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label" for="selectError">Arıza Durumu</label>
                                    <div class="controls">
                                        <select id="selectError" name="durum" style="max-width: 100%" class="form-control">
                                            <option value="">Seçiniz...</option>
                                            <?php foreach($arizadurum as $key=>$value) {?>
                                                <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="selectError">Arıza Tipi</label>
                                    <div class="controls">
                                        <select id="selectError" name="arizatip_id" style="max-width: 100%" class="form-control">
                                            <option value="">Seçiniz...</option>
                                            <?php foreach($arizatip as $key=>$value) {?>
                                                <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="selectError">Arıza Detay</label>
                                    <div class="controls">
                                        <textarea class="form-control" name="detay"></textarea>
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
                                            <th>Arıza Kodu</th>
                                            <th>Adı Soyadı</th>
                                            <th>Telefon Numarası</th>
                                            <th>Arıza Tipi</th>
                                            <th>Arızanın Durumu</th>
                                            <th>Kayıt Tarihi</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($arizalarList as $row) {
                                                /*if($row['status']==1) {
                                                    echo 'aktif';
                                                }else {
                                                    echo 'pasif';
                                                }*/
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['kod']; ?></td>
                                                    <td><?php echo $row['username']." ".$row['surname']; ?></td>
                                                    <td class="center"><?php echo $row['phone']; ?></td>
                                                    <td class="center"><?php echo $arizatip[$row['arizatip_id']]; ?></td>
                                                    <td class="center"><?php echo $arizadurum[$row['durum']]; ?></td>
                                                    <td class="center"><?php echo $row['create_date']; ?></td>
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
