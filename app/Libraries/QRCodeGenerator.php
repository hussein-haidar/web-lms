<?php

namespace App\Libraries;

class QRCodeGenerator
{
    /**
     * Generate QR Code sebagai SVG string
     */
    public static function generateSVG($data, $size = 200)
    {
        $encoded = self::encode($data);
        $modules = count($encoded);
        $moduleSize = $size / $modules;

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 ' . $size . ' ' . $size . '">';
        $svg .= '<rect width="100%" height="100%" fill="white"/>';

        for ($y = 0; $y < $modules; $y++) {
            for ($x = 0; $x < $modules; $x++) {
                if ($encoded[$y][$x]) {
                    $svg .= '<rect x="' . ($x * $moduleSize) . '" y="' . ($y * $moduleSize) . '" width="' . $moduleSize . '" height="' . $moduleSize . '" fill="black"/>';
                }
            }
        }

        $svg .= '</svg>';
        return $svg;
    }

    /**
     * Generate QR Code dan simpan sebagai file
     */
    public static function generateFile($data, $filename, $directory = 'uploads/qrcode', $size = 300)
    {
        $dir = FCPATH . $directory;
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $svg = self::generateSVG($data, $size);
        $filepath = $dir . '/' . $filename;
        file_put_contents($filepath, $svg);

        return $directory . '/' . $filename;
    }

    /**
     * Simple QR code encoder (minimal version for certificate verification)
     * For production use a proper QR library like chillerlan/php-qrcode
     */
    private static function encode($data)
    {
        // Simple data matrix encoding for short strings
        // This is a basic implementation - for production, use a dedicated QR library
        $bits = self::dataToBits($data);
        $size = self::calculateSize($bits);
        
        $matrix = array_fill(0, $size, array_fill(0, $size, false));
        
        // Add finder patterns
        self::addFinderPattern($matrix, 0, 0);
        self::addFinderPattern($matrix, $size - 7, 0);
        self::addFinderPattern($matrix, 0, $size - 7);
        
        // Add timing patterns
        for ($i = 8; $i < $size - 8; $i++) {
            $matrix[6][$i] = ($i % 2 == 0);
            $matrix[$i][6] = ($i % 2 == 0);
        }
        
        // Simple data placement
        $bitIndex = 0;
        for ($col = $size - 1; $col >= 0; $col -= 2) {
            if ($col == 6) $col--;
            for ($row = 0; $row < $size; $row++) {
                for ($c = 0; $c < 2; $c++) {
                    $x = $col - $c;
                    if ($x >= 0 && $x < $size && !self::isReserved($x, $row, $size)) {
                        if ($bitIndex < count($bits)) {
                            $matrix[$row][$x] = (bool)$bits[$bitIndex];
                            $bitIndex++;
                        }
                    }
                }
            }
        }
        
        return $matrix;
    }

    private static function dataToBits($data)
    {
        $bits = [];
        foreach (str_split($data) as $char) {
            $byte = ord($char);
            for ($i = 7; $i >= 0; $i--) {
                $bits[] = ($byte >> $i) & 1;
            }
        }
        return $bits;
    }

    private static function calculateSize($bits)
    {
        $moduleCount = ceil(sqrt(count($bits) * 2));
        $moduleCount = max(21, $moduleCount);
        return min($moduleCount, 41);
    }

    private static function addFinderPattern(&$matrix, $x, $y)
    {
        $pattern = [
            [1,1,1,1,1,1,1],
            [1,0,0,0,0,0,1],
            [1,0,1,1,1,0,1],
            [1,0,1,1,1,0,1],
            [1,0,1,1,1,0,1],
            [1,0,0,0,0,0,1],
            [1,1,1,1,1,1,1],
        ];
        
        for ($row = 0; $row < 7; $row++) {
            for ($col = 0; $col < 7; $col++) {
                $matrix[$y + $row][$x + $col] = (bool)$pattern[$row][$col];
            }
        }
    }

    private static function isReserved($x, $y, $size)
    {
        // Finder patterns + separators
        if ($x < 9 && $y < 9) return true;
        if ($x >= $size - 8 && $y < 9) return true;
        if ($x < 9 && $y >= $size - 8) return true;
        
        // Timing patterns
        if ($x == 6 || $y == 6) return true;
        
        return false;
    }
}
