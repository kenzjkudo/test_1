<?
////////////////////////////////////////////////
// Ban khong thay doi cac dong sau:
function send_mailer($to,$title,$content,$header,$id_error=""){
	global $con_gmail_name;
	global $con_gmail_pass;
	global $con_gmail_subject;
	global $con_admin_email;
	//*	
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$header .= 'From: admin@cucre.vn <' . $con_admin_email . '>' . "\r\n";
	//*/	
if(mail($to,'=?UTF-8?B?'.base64_encode($title).'?=',$content,$header)){
		return 1;
	}else{
		if(file_exists("../classes/mailer/class.phpmailer.php")){
			require_once("../classes/mailer/class.phpmailer.php");
		}else{
			if(file_exists("../classes/mailer/class.phpmailer.php")){
				require_once("../../classes/mailer/class.phpmailer.php");
			}
		}
		
		$mail_server	=	"";
		$user_name		=	"";
		$password		=	"";
		
		
		//Lấy account mail có lần gửi ít nhất	
			
		$mail_server 	= "smtp.gmail.com";
		$user_name		= $con_gmail_name;
		$password		= $con_gmail_pass;
			
		/*
		echo $mail_server . "<br>";
		echo $user_name . "<br>";
		echo $password . "<br>";
		*/
		
		//bắt đầu thực hiện gửi mail
		$mail 					= new PHPMailer();
		$mail->IsSMTP();
		$mail->Host     		= $mail_server;
		$mail->SMTPAuth 		= true;
		$mail->CharSet 		= "UTF-8";
		$mail->ContentType	= "text/html";
		
		
		////////////////////////////////////////////////
		// Ban hay sua cac thong tin sau cho phu hop
		
		$mail->Username = $user_name;				// SMTP username
		$mail->Password = $password; 				// SMTP password
		
		$mail->From     = $user_name;				// Email duoc gui tu???
		$mail->FromName = $con_gmail_subject;			// Ten hom email duoc gui
		$to_array = split(",",$to);
		for ($i=0; $i<count($to_array); $i++){
			$mail->AddAddress($to_array[$i],"Admin");	 	// Dia chi email va ten nhan
		}
		//$mail->AddReplyTo("vatgia@truonghocso.com","Information");		// Dia chi email va ten gui lai
		
		$mail->IsHTML(true);						// Gui theo dang HTML
		
	
		$mail->Subject = "=?UTF-8?B?".base64_encode($title)."?=";// Chu de email
		$mail->Body     =  $content;			// Noi dung html
		
		//Nếu là google mail
		if ($mail->Host == "smtp.gmail.com"){
			$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
			$mail->Port       = 465;                   // set the SMTP port
			//$mail->MsgHTML($content);
		}
		
		if(!$mail->Send())
		{
			//Nếu không send được thì thử lại với account khác, chỉ thử lại max đến 2 lần là dừng lại
			//strlen($id_error) <= 3 - Ứng với 1 lần retry
			if (strlen($id_error) <= 3){
				///send_mailer($to, $title, $content, $id_error);
			}
			/*
			echo "Email chua duoc gui di! <p>";
			echo "Loi: " . $mail->ErrorInfo;
			*/
			//exit;
		}else{
			//trường hợp mail gửi thành công
			
			//echo $user_name . "<br>";
			//echo "Email da duoc gui!";
			return;
		}
	}
}


//send_mailer("dinhtoan1905@gmail.com","chu de gui di","Cộng hòa xã hội chủ nghĩa Việt Nam <b>Xin chào các bạn</b><br><br>Cúc cu xin chào các bạn");

function generate_content($content,$array = array()){
	foreach($array as $key=>$value){
		$content = str_replace("{#" . $key . "#}",$value,$content);
	}
	return $content;
}

function send_mailer_spam($to,$title,$content, $FromEmail = "", $FromName = 'Cuc Re - www.cucre.vn',$id_error=""){
	global $con_gmail_name;
	global $con_gmail_pass;
	global $con_gmail_subject;
	global $con_admin_email;
	//*	
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$header .= 'From: ' . $FromEmail . ' <' . $FromEmail . '>' . "\r\n";
	//*/	
	$class_path = dirname(__FILE__);
	if(file_exists(str_replace("functions","classes",$class_path) . "/mailer/class.phpmailer.php")){
		require_once(str_replace("functions","classes",$class_path) . "/mailer/class.phpmailer.php");
	}
	
	$mail_server	=	"";
	$user_name		=	"";
	$password		=	"";
	
	
	//Lấy account mail có lần gửi ít nhất	
		
	$mail_server 	= "smtp.cucre.vn";
	$user_name		= "admin@cucre.vn";
	$password		= "cQN(mnJ8";
	
	$db_select 		=	new db_query("SELECT *
											  FROM mails_account
											  WHERE mac_active = 1
											  ORDER BY mac_time_sent ASC
											  LIMIT 1");
 	if($row = mysql_fetch_assoc($db_select->result)){
		$mail_server 	= $row["mac_mail_server"];
		$user_name		= $row["mac_email"];
		$password		= $row["mac_password"];
		//update vao bang mails account
		$db_ex = new db_execute("UPDATE mails_account SET mac_time_sent = " . time() . " WHERE mac_id = " . intval($row["mac_id"]));
		unset($db_ex);
	}
	
	//bắt đầu thực hiện gửi mail
	$mail 					= new PHPMailer();
	$mail->IsSMTP();
	//$mail->SMTPDebug		=	true; echo '<br>' . $user_name;
	//fake smtp
	//$mail_server = '101.99.3.45'; 
	$mail->Host     		= $mail_server;
	//$mail->SMTPAuth 		= false;
	$mail->SMTPAuth 		= true;
	$mail->CharSet 			= "UTF-8";
	$mail->ContentType		= "text/html";
	
	
	////////////////////////////////////////////////
	// Ban hay sua cac thong tin sau cho phu hop
	
	$mail->Username = $user_name;				// SMTP username
	$mail->Password = $password; 				// SMTP password
	
	$mail->From     = $user_name;				// Email duoc gui tu???
	$mail->FromName = $FromName;			// Ten hom email duoc gui
	$to_array = split(",",$to);
	for ($i=0; $i<count($to_array); $i++){
		$mail->AddAddress($to_array[$i], "");	 	// Dia chi email va ten nhan
	}
	//$mail->AddReplyTo("vatgia@truonghocso.com","Information");		// Dia chi email va ten gui lai
	
	$mail->IsHTML(true);						// Gui theo dang HTML
	
	$mail->Subject  =  $title;				// Chu de email
	$mail->Body     =  $content;			// Noi dung html
	//$mail->AddAttachment("../cv_stores/", "a.doc");
	
	//Nếu là google mail
	if ($mail->Host == "smtp.gmail.com" || $mail->Host == "smtp.bizmail.yahoo.com"){
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Port       = 465;                   // set the SMTP port
		//$mail->MsgHTML($content);
	}
	// $mail->Port = 6500;
	 //var_dump($mail);

	if(!$mail->Send()){
		//Nếu không send được thì thử lại với account khác, chỉ thử lại max đến 2 lần là dừng lại
		//strlen($id_error) <= 3 - Ứng với 1 lần retry
		if (strlen($id_error) <= 3){
			///send_mailer($to, $title, $content, $id_error);
		}
		return false;
	}else{
		//trường hợp mail gửi thành công
		
		//echo $user_name . "<br>";
		//echo "Email da duoc gui!";
		return true;
	}
}

//hàm gửi mail thông qua hệ thống SMTP của Nhanh.vn.

function send_mail_nhanh($to, $title, $json_info, $content, $attach='', $sendmode = 2, $id_error = "", $FromEmail = 'cucre.vn'){

	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$header .= 'From: ' . $FromEmail . ' <' . $FromEmail . '>' . "\r\n";
	
	$class_path = dirname(__FILE__);
	if(file_exists(str_replace("functions","classes",$class_path) . "/mailer/class.phpmailer.php")){
		require_once(str_replace("functions","classes",$class_path) . "/mailer/class.phpmailer.php");
	}

	//thực hiện gửi mail
	$mail 					= new PHPMailer();
	$mail->IsSMTP();	
	
	//$mail->Host     		= '101.99.3.45';// địa chỉ smtp của Nhanh
	$mail->Host 			= '123.30.208.146';

	$mail->Port 			= 6500;
	$mail->SMTPAuth 		= true;			// tạm thời để false vì bên Nhanh chưa bắt buộc
	$mail->CharSet 		= "UTF-8";
	//$mail->ContentType	= "text/html";
	//$mail->ContentType	= "multipart/mixed";

	//show respone từ smtp server để check lỗi
	//$mail->SMTPDebug		= true;
	$mail->Username 		= 'sn.cucre.vn';					// SMTP username
	$mail->Password 		= 'Vsqfk0UDMT9thAxUVH97'; 	// SMTP password
	
	$mail->From     		= $FromEmail;				// Email duoc gui tu???
	$mail->FromName 		= 'Cucre.vn';			// Ten hom email duoc gui	

	$mail->AddReplyTo("admin@cucre.vn","Admin");

	$mail->Subject    	= "Mail Mừng sinh nhật cucre";

	$to_array = split(",",$to);

	for ($i=0; $i<count($to_array); $i++){
		$mail->AddAddress($to_array[$i], "");	 	// Dia chi email va ten nhan
	}
	//$mail->AddReplyTo("vatgia@truonghocso.com","Information");		// Dia chi email va ten gui lai
	
	$mail->IsHTML(true);						// Gui theo dang HTML
	
	$mail->Subject  =  $title;				// Chu de email
	$mail->Body     =  $content;			// Noi dung html
	$mail->AltBody	 = '';					// noi dung mail hien thị cho thiêt bị không hỗ trợ nội dung html

	// Nếu có đường dẫn file atach thì atach file kèm theo
	if($attach != ''){
		$mail->AddAttachment($attach); // file attach theo email	
	}
	// Check hình thức gửi test hay thật với bên email Nhanh (gắn thêm vào header để bên Nhanh đọc duyệt)
	$arr_teststatus = array(1 => 'just_attach_excel', // sẽ gửi vào địa chỉ nhận template mail và file attach để kiểm tra 
									2 => 'send_after_one_hour',	// sẽ gửi email đi theo danh sách đc ghi trong file excel sau 1h tính từ thời điểm sv Nhanh nhận được
									3 => 'just_send_notify');	// chỉ gửi mail thông báo mà ko gửi đi, để test template mail. 

	
	$headers = "SendMode: " . $arr_teststatus[$sendmode] . "\r\n";
	$mail->AddCustomHeader($headers);	
	// End check hình thức gửi test hay thật với bên email Nhanh	

	// Nếu là google mail
	if ($mail->Host == "smtp.gmail.com" || $mail->Host == "smtp.bizmail.yahoo.com"){
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Port       = 465;                   // set the SMTP port		
	}

	if(!$mail->Send()){
		//Nếu không send được thì thử lại với account khác, chỉ thử lại max đến 2 lần là dừng lại
		//strlen($id_error) <= 3 - Ứng với 1 lần retry
		if (strlen($id_error) <= 3){
			///send_mailer($to, $title, $content, $id_error);
		}
		
		 //echo("Gửi mail thất bại");
		return false;
	}else{
		//trường hợp mail gửi thành công
		
		// echo $user_name . "<br>";
		 //echo "Email da duoc gui!";
		return true;
	}
}
?>