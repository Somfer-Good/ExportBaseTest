<?php

function GetComment($connect)
{
    $comments = mysqli_query($connect, "SELECT * FROM `UserComment` ORDER by id DESC LIMIT 5");
    $commentsList = [];
    while ($comment = mysqli_fetch_assoc($comments)) {
        $commentsList[] = $comment;
    }
    echo json_encode($commentsList);
}
function AddComment($connect, $data)
{
    $UserName = $data['name'];
    $UserComment = $data['comment'];
    if (empty($UserName) or empty($UserComment)) exit('Null');
    mysqli_query($connect, "INSERT INTO `UserComment` (`Id`, `Name`, `Comment`, `Time`) VALUES (NULL, '$UserName', '$UserComment', NOW())");
    http_response_code(201);

    $res = [
        "status" => true,
        "comment_id" => mysqli_insert_id($connect),
    ];
    echo json_encode($res);
}

function DeleteComment($connect, $id){
    mysqli_query($connect,"DELETE FROM UserComment WHERE `UserComment`.`Id` = '$id'");

    http_response_code(200);

    $res=[
        "status"=>true,
        "message"=>"Comment is deleted"
    ];
    echo json_encode($res);
}