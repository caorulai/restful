<?php
/**
 * 连接数据库并返回数据库连接句柄
 * Created by PhpStorm.
 * User: buddha
 * Date: 2018-10-13
 * Time: 18:49
 */
$pdo = new PDO('mysql:host=localhost;dbname=restful', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
return $pdo;