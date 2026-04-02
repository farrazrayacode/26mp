<?php

namespace App\Helpers;

class Terbilang{
    private static $satuan = [
        '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima',
        'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh',
        'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas',
        'Lima Belas', 'Enam Belas', 'Tujuh Belas', 'Delapan Belas', 'Sembilan Belas'
    ];

    public static function convert($angka): string{
        $angka = (int) $angka;

        if ($angka < 0) return 'minus ' . self::convert(abs($angka));
        if ($angka === 0) return 'Nol';
        if ($angka < 20) return self::$satuan[$angka];
        if ($angka < 100) return self::$satuan[(int)($angka/10)+10-2].' Puluh'.($angka%10?' '.self::$satuan[$angka%10]:'');
        if ($angka < 200) return 'Seratus' . ($angka%100 ? ' '.self::convert($angka%100):'');
        if ($angka < 1000) return self::$satuan[(int)($angka/100)].' Ratus'.($angka%100?' '.self::convert($angka%100):'');
        if ($angka < 2000) return 'Seribu' . ($angka%1000?' '.self::convert($angka%1000):'');
        if ($angka < 1000000) return self::convert((int)($angka/1000)).' Ribu'. ($angka%1000?' '. self::convert($angka%1000): '');
        if ($angka < 1000000000) return self::convert((int)($angka/1000000)). 'Juta'. ($angka % 1000000? ' '.self::convert($angka%1000000):'');

        return self::convert((int)($angka/1000000000)). ' Miliar'.($angka%1000000000?' '.self::convert($angka%1000000000):'');
    }
}