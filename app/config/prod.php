<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 10/03/15
 * Time: 18:55
 */

$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => 'raulnet64ghg13dg.maria.db',
    'port'     => '3306',
    'dbname'   => 'raulnet64ghg13dg',
    'user'     => 'd64ghg13dg',
    'password' => '$Up3rf4t4lB4n4na',
);

$app['zdb.configArray'] = array(
    'driver'   => 'pdo_mysql',
    'database' => 'raulnet64ghg13dg',
    'charset'  => 'utf8',
    'hostname' => 'raulnet64ghg13dg.maria.db',
    'port'     => '3306',
    'username' => 'd64ghg13dg',
    'password' => '$Up3rf4t4lB4n4na',
    'options'  => array(
        'buffer_results' => true,
    )
);

$app['swiftmailer.options'] = array(
    'host' => 'ssl0.ovh.net',
    'port' => 465,
    'username' => 'rolnet@rolnet.fr',
    'password' => 'f4t4lB4n4na',
    'encryption' => 'ssl',
    'auth_mode' =>  'login'                                    
);
