<?
include("inc_security.php");
checkAddEdit("edit");

$fs_redirect = base64_decode(getValue("url", "str", "GET", base64_encode("listing.php")));
$record_id = getValue("record_id", "int", "GET", 0);

//Khai báo biến khi thêm mới
$after_save_data = getValue("after_save_data", "str", "POST", "listing.php");
$add = "add.php";
$listing = "listing.php";
$fs_title = "Edit Banner";
$fs_action = getURL();
$fs_redirect = $after_save_data;
$fs_errorMsg = "";

$ban_end_time = 0;
$ban_str_end_time = getValue('ban_str_end_time', "str", "POST", '');
$ban_str_end_date = getValue('ban_str_end_date', "str", "POST", '');
if ($ban_str_end_date != '') {
    $ban_end_time = convertDateTime($ban_str_end_date, $ban_str_end_time);
}

/*
Call class form:
1). Ten truong
2). Ten form
3). Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
4). Noi luu giu data  0 : post, 1 : variable
5). Gia tri mac dinh, neu require thi phai lon hon hoac bang default
6). Du lieu nay co can thiet hay khong
7). Loi dua ra man hinh
8). Chi co duy nhat trong database
9). Loi dua ra man hinh neu co duplicate
*/
$myform = new generate_form();
$myform->add("db_parent_id", "db_parent_id", 0, 0, "", 1, "Bạn chưa chọn hình thức", 0, "");
$myform->add("db_name", "db_name", 0, 0, "", 1, "Bạn chưa nhập tên banner.", 0, "");
$myform->add("db_active", "db_active", 1, 0, 0, 0, "", 0, "");
$myform->add("db_price", "db_price", 1, 0, 0, 0, "", 0, "");
$myform->add("db_price_id", "db_price_id", 1, 0, 0, 0, "", 0, "");
$myform->addTable($fs_table);

//Get action variable for add new data
$action = getValue("action", "str", "POST", "");
//Check $action for insert new data
if ($action == "execute") {

    //Check form data
    $fs_errorMsg .= $myform->checkdata();

    //Get $filename and upload
    $filename = "";
//    if ($fs_errorMsg == "") {
//        $upload = new upload($fs_fieldupload, $fs_filepath, $fs_extension, $fs_filesize, $fs_insert_logo);
//        $filename = $upload->file_name;
//
//        $fs_errorMsg .= $upload->warning_error;
//    }

    if ($fs_errorMsg == "") {
//        if ($filename != "") {
//            $$fs_fieldupload = $filename;
//            $myform->add($fs_fieldupload, $fs_fieldupload, 0, 1, "", 0, "", 0, "");
//        }//End if($filename != "")

        //Update database
        $myform->removeHTML(0);
        $db_update = new db_execute($myform->generate_update_SQL($id_field, $record_id));
        unset($db_update);

        //Redirect after insert complate
        redirect($fs_redirect);

    }//End if($fs_errorMsg == "")

}//End if($action == "execute")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <?= $load_header ?>
    <?
    //add form for javacheck
    $myform->addFormname("add");

    $myform->checkjavascript();
    //chuyển các trường thành biến để lấy giá trị thay cho dùng kiểu getValue
    $myform->evaluate();
    $fs_errorMsg .= $myform->strErrorField;

    //lay du lieu cua record can sua doi
    $db_data = new db_query("SELECT * FROM " . $fs_table . " WHERE " . $id_field . " = " . $record_id);
    if ($row = mysql_fetch_assoc($db_data->result)) {
        foreach ($row as $key => $value) {
            if ($key != 'lang_id' && $key != 'admin_id') $$key = $value;
        }
    } else {
        exit();
    }
    $ban_str_end_time = date("H:i:s", time());
    $ban_str_end_date = "";
    if ($ban_end_time > 0) {
        $ban_str_end_time = date("H:i:s", $ban_end_time);
        $ban_str_end_date = date("d/m/Y", $ban_end_time);
    }

    ?>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?= template_top($fs_title) ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<p align="center" style="padding-left:10px;">
    <?
    $form = new form();
    $form->create_form("add", $fs_action, "post", "multipart/form-data");
    $form->create_table();
    ?>
    <?= $form->text_note('Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.') ?>
    <?= $form->errorMsg($fs_errorMsg) ?>
    <?= $form->text("Hình thức","db_parent_id","db_parent_id",$db_parent_id,"Hình thức",1,250,"","","")?>
    <?= $form->text("Tên City", "db_name", "db_name", $db_name, "Tên City", 1, 250, "", 255, "", "", "") ?>
    <?= $form->checkbox("Kích hoạt", "db_active", "db_active", 1, $db_active, "Kích hoạt", 0, "", "") ?>
    <?= $form->text("Tên Giá", "db_price", "db_price", $db_price, "Tên banner", 1, 250, "", 255, "", "", "") ?>
    <?= $form->text("Hình thức vận chuyển", "db_price_id", "db_price_id", $db_price_id, "hình thức vận chuyển", 1, 250, "", 255, "", "", "") ?>
    <?= $form->button("submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "submit" . $form->ec . "reset", "Cập nhật" . $form->ec . "Làm lại", "Cập nhật" . $form->ec . "Làm lại", $form->ec, ""); ?>
    <?= $form->hidden("action", "action", "execute", ""); ?>
    <?
    $form->close_table();
    $form->close_form();
    unset($form);
    ?>
</p>
<? /*------------------------------------------------------------------------------------------------*/ ?>
<?= template_bottom() ?>
<? /*------------------------------------------------------------------------------------------------*/ ?>
</body>
</html>