<?php 
 
//PDO("oci:dbname=//oracle远程IP:端口号/数据库名",用户名,密码);oci要小写
    $dsn_con="oci:dbname=//192.168.23.12/ORCL;charset=UTF8";
    try{
        $dbh= new PDO($dsn_con,"username","password",array(PDO::ATTR_PERSISTENT => true));
    } catch (PDOException $e) {
        print "oci: " . $e->getMessage() . "<br/>";
        die();
    }
    $sth = $dbh->prepare('SELECT TABLE_NAME FROM dba_tables');
    $sth->execute();

    $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
    var_dump($result);
