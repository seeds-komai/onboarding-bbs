<?php
/* ----------------------------------------------------------------------
 * データベースの設定定義
 *
 * DB_HOST: データベースサーバのホスト名
 * DB_PORT: データベースサーバのポート
 * DB_NAME: データベース名
 * DB_USER: データベースにアクセスする際に利用するユーザ
 * DB_PASSWORD: データベースにアクセスする際に利用するユーザのパスワード
 * ---------------------------------------------------------------------- */
define('DB_HOST', 'db');
define('DB_PORT', 3306);
define('DB_NAME', 'bbs');
define('DB_USER', 'user');
define('DB_PASSWORD', 'password');

// $host = DB_HOST;
// $port = DB_PORT;
// $dbname = DB_NAME;
// $user = DB_USER;
// $pass = DB_PASSWORD;

/* ----------------------------------------------------------------------
 * データベースへの接続を行う
 * ---------------------------------------------------------------------- */
function connectDB(){
    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // 問題があった場合に例外を出す
    // return null;
    
    try {
        // global $host,$port,$dbname,$user,$pass;
        $dsn = "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME;
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
        
        // return $pdo;
    } catch (PDOException $e){
        throw new Exception('データベースの接続に失敗しました'.$e->getMessage());
    }

}
