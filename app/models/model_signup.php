<?php

/**
 * Created by PhpStorm.
 * User: ingvar73
 * Date: 10.09.2016
 * Time: 12:22
 */
class Model_Signup extends Model
{
    public $confirm_password;
    private $err=[];

    const H_PASSWORD_PATTERN = '/(?=^.{8,32}$)((?=.*\d)|(?=.*\W+))(?|[.\n])(?=.*[A-Z])(?=.[a-z]).*S/';
    const M_PASSWORD_PATTERN = '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,30}/';
    const LOGIN_PATTERN = '/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/';
    const EMAIL_PATTERN = '/@/';

    public function __construct($login, $password, $confirm_password, $email)
    {
        $this->login = $login;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
        $this->email = $email;
        $this->date = date('d:m:y');
    }

    public function regex ($pattern, $field, $err){
        preg_match($pattern, $field) ? : $this->err[] = $err;
    }

    public function len ($min, $max, $variable, $err){
        !(strlen($variable) > $max || strlen($variable) < $min) ? : $this->err[] = $err;
    }

    public function quality ($one, $two, $err){
        $one == $two ? : $this->err[] = $err;
    }

    public function unique(array $row, $err){
        array_shift($row) == 0 ? : $this->err[] = $err;
    }

    public function getErrors (){
        return $this->err;
    }

    public function generateHash ($algo = PASSWORD_BCRYPT) {
        $this->password = password_hash($this->password, $algo);
    }

    public function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }
}