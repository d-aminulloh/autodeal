<?php

namespace App\Helpers;
use Carbon\Carbon;

class Helpers {
    public static function myFormatDate($date)
    {
        // Set Indonesian locale for month names
        Carbon::setLocale('id'); 

        $date = Carbon::parse($date);
        $today = Carbon::now();


        // Check if date is today
        if ($date->isSameDay($today)) {
            return 'Hari ini';
        } else {
            // Check if date is yesterday
            $yesterday = $today->subDay();
            if ($date->isSameDay($yesterday)) {
                return 'Kemarin';
            } else {
                // Check if same month
                // if ($date->month === $today->month) {
                    // return $date->formatLocalized('d F Y'); // Uses short month name
                // } else {
                    // Check if same year
                    if ($date->year === $today->year) {
                        return $date->isoFormat('D MMM');
                    } else {
                        return $date->isoFormat('D MMM Y');
                    }
                // }
            }
        }
    }
    public static function TerbilangId($amount)
    {
        if($amount < 0) {
			$hasil = "minus ". trim(self::TerbilangId_penyebut($amount));
		} else {
			$hasil = trim(self::TerbilangId_penyebut($amount));
		}
		return $hasil;
    }

    private function TerbilangId_penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = self::TerbilangId_penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = self::TerbilangId_penyebut($nilai/10)." puluh". self::TerbilangId_penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . self::TerbilangId_penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = self::TerbilangId_penyebut($nilai/100) . " ratus" . self::TerbilangId_penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . self::TerbilangId_penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = self::TerbilangId_penyebut($nilai/1000) . " ribu" . self::TerbilangId_penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = self::TerbilangId_penyebut($nilai/1000000) . " juta" . self::TerbilangId_penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = self::TerbilangId_penyebut($nilai/1000000000) . " milyar" . self::TerbilangId_penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = self::TerbilangId_penyebut($nilai/1000000000000) . " trilyun" . self::TerbilangId_penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}

    public static function TerbilangEn($number){
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->TerbilangEn(abs($number));
        }

        $string = $fraction = null;
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string    = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->TerbilangEn($remainder);
                }
                break;
            default:
                $baseUnit     = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder    = $number % $baseUnit;
                $string       = $this->TerbilangEn($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->TerbilangEn($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return ucwords($string);
    }
}
