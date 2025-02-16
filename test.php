<?php 
$testData = 
[
    [
        ["id" => 1, "nom" => "Alice", "age" => 25],
        ["id" => 2, "nom" => "Bob", "age" => 30]
    ],
    [
        ["id" => 101, "nom" => "Clavier", "prix" => 49.99],
        ["id" => 102, "nom" => "Souris", "prix" => 19.99]
    ]
];

echo $testData[count($testData)-1][1]["id"];

// 