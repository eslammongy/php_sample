<?php

declare(strict_types = 1);

function getTransactionFiles(string $dirPath): array{
    $files = [];
    foreach (scandir($dirPath) as $file){
       if (is_dir($file)){
           continue;
       }
       $files[] = $dirPath . $file;
    }
    return $files;
}

function getTransactions(string $fileName): array{
    if(! file_exists($fileName)){
        trigger_error('File "' .$fileName . '" does not found.' , E_USER_ERROR);
    }
    $file = fopen($fileName , 'r');
    fgetcsv($file);
    $transactions = [];
    while(($transaction = fgetcsv($file)) != false){
        $transactions [] = extractTransactions($transaction);
    }
    return $transactions;
}

function extractTransactions(array $transactionsRow):array{
    [$date , $checkNumber , $description , $amount ] = $transactionsRow;
    $amount = (float)str_replace(['$' , ','] , '' , $amount);
    return [
        'date' => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount' => $amount
    ];
}