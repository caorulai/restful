<?php
/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 2018-10-13
 * Time: 18:49
 */
require_once __DIR__.'/ErrorCode.php';
class User
{
    /**
     * 数据库连接句柄
     * @var
     */
    private $_db;

    /**
     * 构造方法
     * User constructor.
     * @param PDO $_db 连接数据库句柄
     */
    public function __construct($_db)
    {
        $this->_db = $_db;
    }


    /**
     * 用户登录
     * @param $username
     * @param $password
     * @return mixed
     * @throws Exception
     */
    public function login($username, $password)
    {
        if (empty($username)) {
            throw new Exception('用户名不能为空', ErrorCode::USERNAME_CANNOT_EMPTY);
        }
        if (empty($password)) {
            throw new Exception('密码不能为空', ErrorCode::PASSWORD_CANNOT_EMPTY);
        }
        $sql = "SELECT * FROM `user` WHERE `username`=:username AND `password`=:password";
        $password = $this->_md5($password);
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        if (!$stmt->execute()) {
            throw new Exception('服务器内部错误', ErrorCode::SERVER_INTERANL_ERROR);
        }
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($user)) {
            throw new Exception('账户或密码错误', ErrorCode::USERNAME_OR_PASSWORD_INVALID);
        }
        unset($user['password']);
        return $user;
    }

    /**
     * 用户注册
     * @param $username
     * @param $password
     */
    public function register($username, $password)
    {
        if (empty($username)) {
            throw new Exception('用户名不能为空', ErrorCode::USERNAME_CANNOT_EMPTY);
        }
        if (empty($password)) {
            throw new Exception('密码不能为空', ErrorCode::PASSWORD_CANNOT_EMPTY);
        }
        if ($this->_isUsernameExists($username)) {
            throw new Exception('用户名已存在', ErrorCode::USERNAME_EXISTS);
        }
        // 写入数据
        $sql = "INSERT INTO `user`(`username`,`password`,`created_at`) VALUE (:username,:password,:created_at)";
        $created_at = time();
        $password = $this->_md5($password);
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':created_at', $created_at);
        if (!$stmt->execute()) {
            throw new Exception('注册失败', ErrorCode::REGISTER_FAIL);
        }
        return [
            'user_id' => $this->_db->lastInsertId(),
            'username' => $username,
            'created_at' => $created_at,
        ];
    }

    /**
     * MD5加密
     * @param $string
     * @param string $key
     * @return string
     */
    private function _md5($string, $key = 'buddha')
    {
        return md5($string . $key);
    }

    /**
     * 检测用户名是否存在
     * @param $username
     * @return bool
     */
    private function _isUsernameExists($username)
    {
        $sql = 'SELECT * FROM `user` WHERE `username`=:username';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($result);
    }
}