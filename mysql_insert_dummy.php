<?php

$pdo = new PDO(
    'mysql:dbname=testdb;host='.$_ENV['mysql_host'].';charset=latin1',
    'root',
    $_ENV['mysql_password'],
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    )
);

$create = <<<'EOF'
create table if not exists test_table (
    id int not null auto_increment primary key,
    val1 int not null,
    val2 int not null,
    val3 int not null,
    text1 varchar(30) not null
) DEFAULT CHARSET=latin1;
EOF;

$pdo->exec($create);


function bulkInsertQuery() {
    $q = 'insert into test_table (val1, val2, val3, text1) VALUES';
    for ($j = 0; $j < 1000; $j++) {
        $q .= '('.rand().','.rand().','.rand().','.'"foo bar baz hoge"'.'), ';
    }
    $q .= '('.rand().','.rand().','.rand().','.'"foo bar baz hoge"'.')';
    $q .= ';';
    return $q;
}

for ($i = 0; $i < 10000; $i++) {
    //print bulkInsertQuery();
    $pdo->exec(bulkInsertQuery());
}
