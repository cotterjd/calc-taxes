#!/usr/bin/php

<?php
  if (sizeOf($argv) < 2) {
    // required salary not given
    return print "salary required";
  }
  $salary = $argv[1];

  // defaults
  $spouseIncome = 0;
  $numberOfChildren = 0;
  $deductions = 0;
  if (sizeOf($argv) > 2) {
    $spouseIncome = $argv[2];
  } 
  if (sizeOf($argv) > 3) {
    $numberOfChildren = $argv[3];
  } 
  if (sizeOf($argv) > 4) {
    $deductions = $argv[4];
  } 
  $netSalary = $salary - $deductions;
  $standardDeduction = 24400;
  $childCredit = $numberOfChildren * 2000;
  $payrollTaxRate = 0.0765;
  $payrollTaxes = $netSalary * $payrollTaxRate;
  $ten99TaxableIncome = $netSalary + $spouseIncome - $standardDeduction;
  $w2TaxableIncome = $salary + $spouseIncome - $standardDeduction;
  $ten99Taxes = getIncomeTaxes($ten99TaxableIncome) - $childCredit + $netSalary * 0.153;
  $w2Taxes = getIncomeTaxes($w2TaxableIncome) - $childCredit + $salary * 0.0765;

  #debug
  #echo "1099 taxable income $ten99TaxableIncome\n";
  #echo "w2 table income $w2TaxableIncome\n";
  #echo "1099 taxes";
  #echo getIncomeTaxes($ten99TaxableIncome);
  #echo "child credit $childCredit";
  #echo "salary $salary";
  #echo "net salary $netSalary";

  echo "\nw2 total taxes: $w2Taxes\n";
  echo "1099 total taxes: $ten99Taxes\n";

  function getIncomeTaxes($income) {
    $l1 = 9700;
    $l1Taxes = $l1*.1;
    if ($income < $l1) {
      return $l1Taxes;
    }
    $l2 = 39475;
    $l2Taxes = ($l2-$l1)*.12;
    if ($income < $l2) {
      return $l2Taxes;
    }
    $l3 = 84200;
    $l3Taxes = ($l3-$l2)*.22;
    if ($income < $l3) {
      return $l3Taxes;
    }
    $l4 = 160725;
    $l4Taxes = ($l4-$l3)*.24;
    if ($income < $l4) {
      return $l4Taxes;
    }
    $l5 = 204100;
    $l5Taxes = ($l5-$l4)*.32;
    if ($income < $l5) {
      return $l5Taxes;
    }
    $l6 = 510300;
    $l6Taxes = ($l6-$l5)*.35;
    if ($income < $l6) {
      return $l6Taxes;
    }
    $l7 = 510301;
    $l7Taxes = ($income-$l6)*.37; 
    return $l7Taxes;
  }
?>
