#!/usr/bin/perl

$header = `cat header.txt`;


open(FILE, $ARGV[0]);
$_ = <FILE>;
print $_;
print $header;
print while <FILE>;
