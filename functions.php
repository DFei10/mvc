<?php
function getTransactions($fileHandler)
{
    $transactionsTable = [];
    fgetcsv($fileHandler); // Don't Store First Line in The Array

    while (!feof($fileHandler)) {
        $transactionsTable[] = parseTransactionLine(fgetcsv($fileHandler));
    }

    return $transactionsTable;
}

function getAmount($amount)
{
    return (float) str_replace([',',  '$'], '', $amount);
}

function formatDate($date)
{
    return date('M j, Y', strtotime($date));
}

function parseTransactionLine(array $line)
{
    return [$line[0], $line[1], $line[2], getAmount($line[3])];
}

function getClass($amount)
{
    return $amount >= 0 ? 'text-green' : 'text-red';
}

function formatAmount($amount)
{
    $amount = number_format($amount, 2);

    return $amount[0] == '-' ? '-$' . substr($amount, 1) : "$$amount";
}

function calculate($amounts, $cb = null)
{
    if ($cb) {
        return array_reduce(
            array_filter($amounts, $cb),
            fn ($a, $b) => $a + $b
        );
    }

    return array_reduce(
        $amounts,
        fn ($a, $b) => $a + $b
    );
}
