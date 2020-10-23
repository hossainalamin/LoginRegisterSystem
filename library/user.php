<?php
include_once 'session.php';
include 'database.php';
class user
{
    private $tbl="tbl_user";
    private $db;
    public function __construct()
    {
        $this->db=new database();
    }
    public function registration($data)
    {
        $name     = $data['name'];
        $username = $data['username'];
        $email    = $data['email'];
        $phone    = $data['phone'];
        $pass     = $data['password'];
        $chk_email= $this->emailCheck($email);
        if($name =="" or $username =="" or $email == "" or $pass == "" or $phone == "")
        {
            $msg="<div class='alert alert-danger'><strong>Any of the field should not be empty!</strong></div>";
            return $msg;
        }
        elseif(strlen($username)<3)
        {
           $msg="<div class='alert alert-danger'><strong>Username Should be of length greater than 3!</strong></div>";
            return $msg;
        }
        elseif(preg_match('/[^a-zA-Z0-9_-]/i',$username))
        {
            $msg="<div class='alert alert-danger'><strong>User name only contain Alphanuumerical,Underscrore,Dashes!</strong></div>";
            return $msg;
        }

        elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $msg="<div class='alert alert-danger'><strong>Invalid Email</strong></div>";
            return $msg;
        }
        elseif($chk_email==true)
        {
            $msg="<div class='alert alert-danger'><strong>Duplicate Email.Please Enter new email!</strong></div>";
            return $msg;
        }
        elseif(strlen($data['password']) < 6)
        {
           $msg="<div class='alert alert-danger'><strong>Password Should be of length greater than 6!</strong></div>";
            return $msg;
        }
        else
        {
            $pass     = md5($data['password']);
            $sql="insert into $this->tbl(name,username,email,phone,password) values(:name,:username,:email,:phone,:password)";
            $stmt= $this->db->pdo->prepare($sql);
            $stmt->bindValue(':name',$name);
            $stmt->bindValue(':username',$username);
            $stmt->bindValue(':email',$email);
            $stmt->bindValue(':phone',$phone);
            $stmt->bindValue(':password',$pass);
            $result = $stmt->execute();
            if($result)
            {
                $msg="<div class='alert alert-success'><strong>Registration Successfull.ThankYouu</strong></div>";
                return $msg;
            }
            else
            {
                 $msg="<div class='alert alert-success'><strong>Registration unsuccessfull.Something wrong.</strong></div>";
                return $msg;

            }

        }

    }
	public function verify($data)
    {
        $phone     = $data['phone'];
        if(empty($phone))
        {
            $msg="<div class='alert alert-danger'><strong>Any of the field should not be empty!</strong></div>";
            return $msg;
        }
        else
        {
			$sql  = "select phone from tbl_user where phone = :phone";
			$stmt = $this->db->pdo->prepare($sql);
			$stmt->bindValue(':phone',$phone);
			$stmt->execute();
			if($stmt->rowCount()>0){
					$token = "acd0069af0e40eb62acba975278c094e";
					$otp   = array('0','1','2','3','4','5','6','7','8','9');
					$length = 6;
					$str = "";
					for($i = 0;$i<$length;$i++){
						shuffle($otp);
						$str .= $otp[0];  
					}
					$message = $str;
					$url = "http://api.greenweb.com.bd/api2.php";

					$data= array(
					'to'=>"$phone",
					'message'=>"$message",
					'token'=>"$token"
					); // Add parameters in key value
					$ch = curl_init(); // Initialize cURL
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_ENCODING, '');
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$smsresult = curl_exec($ch);
					echo curl_error($ch);
					$sql="update  
					tbl_user
					set otp = $message
					where phone = :phone";
					$stmt= $this->db->pdo->prepare($sql);
					$stmt->bindValue(':phone',$phone);
					$upOtp = $stmt->execute();
					if($upOtp){
						$success="An otp send in " .$phone. " Please place it for verification";
						header("location:sms.php?msg=$success&&phone=$phone");
					}else{
						$fail="Otp does not sent";
						header("location:sms.php?msg=$fail");
					}
				
			}else{
					$fail="Number doesn't match";
					return $fail;
			}

		}

    }
	public function confirm($data)
    {
        $otp = $data['otp'];
		$phone = $data['phone'];
        $sql = "select otp from tbl_user where phone = :phone and otp = :otp";
        $stmt= $this->db->pdo->prepare($sql);
        $stmt->bindValue(':phone',$phone);
        $stmt->bindValue(':otp',$otp);
        $result = $stmt->execute();
        if($stmt->rowCount()>0)
        {
			header("location:confirm.php");
        }
        else
        {
            $txt="<div class='alert alert-danger'><strong>Verification unsuccessfull.Something wrong.</strong></div>";
			return $txt;
		}

    }
	public function emailCheck($email)
    {
        $sql = "select email from tbl_user where email = :email";
        $stmt= $this->db->pdo->prepare($sql);
        $stmt->bindValue(':email',$email);
        $stmt->execute();
        if($stmt->rowCount()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function login($email,$pass)
    {
        $sql = "select * from tbl_user where email = :email and password = :password";
        $stmt= $this->db->pdo->prepare($sql);
        $stmt->bindValue(':email',$email);
        $stmt->bindValue(':password',$pass);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function userlogin($data)
    {
        $email    = $data['email'];
        $pass     = md5($data['password']);
        $chk_email= $this->emailCheck($email);
        if($email == "" or $pass == "")
        {
            $msg="<div class='alert alert-danger'><strong>Any of the field should not be empty!</strong></div>";
            return $msg;
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $msg="<div class='alert alert-danger'><strong>Invalid Email</strong></div>";
            return $msg;
        }
        if($chk_email==false)
        {
            $msg="<div class='alert alert-danger'><strong>Email Address not Exists!</strong></div>";
            return $msg;
        }
        $result=$this->login($email,$pass);
        if($result)
        {
            session::init();
            session::set('login',true);
            session::set('id',$result->id);
            session::set('name',$result->name);
            session::set('username',$result->username);
            session::set('loginmsg',"<div class='alert alert-success'><strong>Login Successfull</strong></div>");
			session::set('current_timestamp',time());
            header("location:index.php");

        }
        else
        {
            $msg="<div class='alert alert-danger'><strong>Data Not found</strong></div>";
            return $msg;
        }

    }
    public function getUserData()
    {
        $sql = "select * from $this->tbl order by id desc";
        $stmt= $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;

    }
    public function getDataById($userid)
    {
        $sql = "select * from $this->tbl where id=:id";
        $stmt= $this->db->pdo->prepare($sql);
        $stmt->bindValue(':id',$userid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function userUpdate($userid,$data)
    {
        $name     = $data['name'];
        $username = $data['username'];
        $email    = $data['email'];
        if($name == "" or $username == "" or $email == "")
        {
            $msg="<div class='alert alert-danger'><strong>Any of the field should not be empty!</strong></div>";
            return $msg;
        }
        elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $msg="<div class='alert alert-danger'><strong>Invalid Email</strong></div>";
            return $msg;
        }
        elseif(strlen($username)<3)
        {
           $msg="<div class='alert alert-danger'><strong>Invalid Username!</strong></div>";
            return $msg;
        }
        elseif(preg_match('/[^a-zA-Z0-9_-]/i',$username))
        {
            $msg="<div class='alert alert-danger'><strong>User name only contain Alphanuumerical,Underscrore,Dashes!</strong></div>";
            return $msg;
        }

        elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $msg="<div class='alert alert-danger'><strong>Invalid Email</strong></div>";
            return $msg;
        }
        else{
            $sql="update  $this->tbl set
            name        =:name,
            username   =:username,
            email      =:email
            where id    =:id;";
            $stmt= $this->db->pdo->prepare($sql);
            $stmt->bindValue(':name',$name);
            $stmt->bindValue(':username',$username);
            $stmt->bindValue(':email',$email);
            $stmt->bindValue(':id',$userid);
            $result = $stmt->execute();
            if($result)
            {
                $msg="<div class='alert alert-success'><strong> updated Successfull.ThankYou</strong></div>";
                return $msg;
            }
            else
            {
                 $msg="<div class='alert alert-danger'><strong>Update unsuccessfull.Something wrong.</strong></div>";
                return $msg;

            }
        }
    }
    public function checkPass($old,$id)
    {
        $pass=md5($old);
        $sql = "select password from tbl_user where password = :pass and id=:id";
        $stmt= $this->db->pdo->prepare($sql);
        $stmt->bindValue(':pass',$pass);
        $stmt->bindValue(':id',$id);
        $stmt->execute();

        if($stmt->rowCount()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function userPassword($userid,$data)
    {
        $old     = $data['old'];
        $new = $data['new'];
        if($old==""or $new == "")
        {
            $msg="<div class='alert alert-danger'><strong>Any of the field should not be empty!</strong></div>";
            return $msg;
        }
        elseif(strlen($data['new']) < 6)
        {
           $msg="<div class='alert alert-danger'><strong>Password Should be of length greater than 6!</strong></div>";
            return $msg;
        }
        $chk_pass=$this->checkPass($old,$userid);
        if(!$chk_pass)
        {
            $msg="<div class='alert alert-danger'><strong>Password Not Exists..</strong></div>";
            return $msg;
        }
        $password = md5($new);
        $sql="update  $this->tbl
        set
        password        =:pass
        where id    =:id;";
        $stmt= $this->db->pdo->prepare($sql);
        $stmt->bindValue(':pass',$password);
        $stmt->bindValue(':id',$userid);
        $result = $stmt->execute();
            if($result)
            {
                $msg="<div class='alert alert-success'><strong>Password updated Successfull.ThankYou</strong></div>";
                return $msg;
            }
            else
            {
                 $msg="<div class='alert alert-danger'><strong>Update unsuccessfull.Something wrong.</strong></div>";
                return $msg;

            }

    }

}

?>
