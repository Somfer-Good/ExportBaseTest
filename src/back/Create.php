<?php
$Server="localhost";
$UserName="root";
$Password="";
$NameDB="User";
$NameTable="UserComment";

$CreateDB="Create database $NameDB";
    if ($connect->query($CreateDB)){
        echo "Database create successfully";
    }
    else{
        echo "Error" . $connect->error;
    }

$connect = mysqli_connect($Server, $UserName, $Password, $NameDB);

$CreateTable="Create Table $NameTable(
    Id int auto_increment primary key,
    Name varchar(25) not null,
    Comment varchar(100) not null,
    Time timestamp	not null
)";

if ($connect->query($CreateTable)){
    echo "Table created successfully";
}else{
    echo "Error" . $connect->error;
}