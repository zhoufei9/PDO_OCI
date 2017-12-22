# PDO_OCI && OCI8-install
#安装PDO_OCI <br/>
我的php版本为5.6.30，要连接的oracle服务器是 11g R2，操作系统版本CentOS 6.9 x86_64 <br/>
PDO_OCI官方说明<br/>
You need to install the PDO core module before you can make use of this one.<br/>
You also require Oracle OCI 8 or higher client libraries installed on the<br/>
machine where you intend to build and/or use it.<br/><br/>

下载并解压缩  <br/>
$ wget https://pecl.php.net/get/PDO_OCI-1.0.tgz <br/>
$ tar -xvf PDO_OCI-1.0.tgz <br/>
$ cd PDO_OCI-1.0 <br/><br/>

修改配置文件 <br/>
更新目录中的config.m4文件，使其适配Oracle11g （我装的oracle服务器是 11g R2）<br/>
在第10行左右找到与下面类似的代码，添加这两行：（注：11.2是下载的版本号instantclient11.2） <br/>
elif test -f $PDO_OCI_DIR/lib/libclntsh.$SHLIB_SUFFIX_NAME.11.2; then <br/>
 PDO_OCI_VERSION=11.2 <br/><br/>
 
在第101行左右添加这几行：（注：11.2是下载的版本号instantclient11.2,别掉了后面两个;;） <br/>
11.2) <br/>
 PHP_ADD_LIBRARY(clntsh, 1, PDO_OCI_SHARED_LIBADD) <br/>
 ;;<br/><br/>

编译<br/>
在当前目录下执行<br/>
$ phpize<br/><br/>
 
安装<br/>
$ ./configure --with-php-config=/usr/local/php/bin/php-config（php默认安装路径可不加）<br/>
$ make && make install<br/>
这里一般会遇到一个问题，在make的时候会提示在pdo_oci.c文件中:<br/>
pdo_oci.c:34: error: expected ‘=', ‘,', ‘;', ‘asm' or ‘attribute' before ‘pdo_oci_functions'<br/>
解决办法是修改pdo_oci.c文件的第34行，把function_entry修改成zend_function_entry,保存后重新make就可以了。<br/><br/>

修改php.ini<br/>
成功之后，会提示在一个目录下生成了pdo_oci.so模块<br/>
把extension=pdo_oci.so加到php.ini<br/>
到这里，pdo_oci模块就安装完成了<br/><br/><br/>


-----------------------------------------------hualifengexian--------------------------------------------------------<br/>
安装OCI8<br/>
下载并解压缩<br/>
依次在命令行中执行下面的命令:<br/>
$ wget https://pecl.php.net/get/oci8-2.0.10.tgz （注意oci8依赖，2.1版本只支持php7，php5.2~PHP5.6请选择2.1以下版本）<br/>
$ tar -xvf oci8-2.0.10.tgz<br/>
$ cd oci8-2.0.10<br/><br/>

编译和安装<br/>
$ phpize<br/>
$ ./configure --with-php-config=/usr/local/php/bin/php-config <br/>
$ make && make install<br/><br/>
 
修改php.ini<br/>
成功之后，会提示已经在/usr/lib64/php/modules目录下生成了pdo_oci.so模块<br/>
把extension=pdo_oci.so加到php.ini<br/><br/>

重启Apache/nginx<br/>
别忘记重启一下apache服务器来重新加载php的模块：<br/><br/>

$ service httpd restart/service nginx restart<br/><br/>
 
通过 phpinfo(); 打印出来的信息，查看其中的pdo, pdo_oci和oci8模块的相关信息。<br/><br/><br/>


问题1 <br/>
You need to tell me where to find your oracle SDK, or set ORACLE_HOME.<br/>
需要安装oracle的客户端<br/><br/>

问题2 <br/>
PDO_OCI-1.0/php_pdo_oci_int.h:21:17: error: oci.h: No <br/>
在Makefile （./configure生成文件） 的INCLUDES 加入 -I/home/oracle/sdk/include 可解决<br/><br/>
 
问题3<br/>
编译时报/usr/bin/ld: cannot find -lclntsh <br/>
原因：环境变量设置,没找到ORACLE下的libclntsh.so文件<br/>
解决办法：检查环境变量，看ORACLE有关的环境变量是否设置正确<br/>
我本地是libclntsh.so.11.1，没有libclntsh.so。 加一个软连接指向就好了  ln -s libclntsh.so.11.1 libclntsh.so<br/>
