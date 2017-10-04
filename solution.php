<?php
function matMul( $a, $b ) {
	$countI = count( $a );
	$countJ = count( $b[0] );
	$countK = count( $b );
	$c      = [];
	for ( $i = 0; $i < $countI; $i ++ ) {
		for ( $j = 0; $j < $countJ; $j ++ ) {
			$sum = 0;
			for ( $k = 0; $k < $countK; $k ++ ) {
				$sum += $a[ $i ][ $k ] * $b[ $k ][ $j ];
			}
			$c[ $i ][ $j ] = $sum;
		}
	}
	return $c;
}
function matAdd($a,$b){
	$countI = count( $a );
	$countJ = count( $a[0] );
	$sum = array_fill( 0, $countI, array_fill( 0, $countI, 0 ) );
	for($i=0;$i<$countI;$i++){
		for($j=0;$j<$countJ;$j++){
			$sum[$i][$j] = $a[$i][$j] + $b[$i][$j];
		}
	}
	return $sum;
}
function init($a){
	$aR        = count( $a );
	$aC        = count( $a[0] );
	$rotated   = array_fill( 0, $aC, array_fill( 0, $aR, 0 ) );
	return [$aR,$aC,$rotated];
}
function rotateArrayLeft( $a ) {
	list($aR,$aC,$rotated) = init($a);
	applyRotation('L',$rotated,$a,$aR,$aC);
	return $rotated;
}
function rotateArrayRight( $a ) {
	list($aR,$aC,$rotated) = init($a);
	applyRotation('R',$rotated,$a,$aR,$aC);
	return $rotated;
}
function getRotationFn($rot,$aR,$aC){
	$rotMatrix = [ [ 0, - 1 ], [ 1, 0 ] ];
	$offset = [[$aC-1],[0]];
	if($rot=='R'){
		$rotMatrix = [ [ 0  , 1 ], [ - 1, 0 ] ];
		$offset = [[0],[$aR-1]];
	}
	return function($i,$j) use ($rotMatrix,$offset) {
		list($a,$b) = matAdd(matMul( $rotMatrix, [ [ $i ], [ $j ] ] ), $offset );
		return [$a[0],$b[0]];
	};
}
function apply($fn,&$rotated,$a,$r,$c){
	for ( $i = 0; $i < $r; $i ++ ) {
		for ( $j = 0; $j < $c; $j ++ ) {
			list($u,$v)                                             = $fn($i,$j);
			$rotated[ $u ][ $v ] = $a[ $i ][ $j ];
		}
	}
	return $rotated;
}
function applyRotation($r,&$rotated,$a,$aR,$aC){
	$rotFn = getRotationFn($r,$aR,$aC);
	apply($rotFn,$rotated,$a,$aR,$aC);
}
function dumpArray($r){
	echo array_reduce($r,function($a,$b){return $a.join(',',$b)."\n";},"")."\n";
}
$inputArray = [
	[1,2,3],
	[4,5,6],
	[7,8,9],
	[10,11,12],
];
dumpArray($inputArray);
$r = rotateArrayRight( $inputArray );
dumpArray($r);
$r = rotateArrayLeft( $inputArray );
dumpArray($r);
