<?php
/**
 * Generate Placeholder Images
 * Script ini akan membuat placeholder images untuk semua products
 */

$storageDir = __DIR__ . '/storage/app/public/products';

// Pastikan direktori ada
if (!is_dir($storageDir)) {
    mkdir($storageDir, 0755, true);
}

$products = [
    'smartphone-samsung.jpg',
    'laptop-hp.jpg',
    'headphone-sony.jpg',
    'ipad-air.jpg',
    'kemeja-levis.jpg',
    'jaket-denim.jpg',
    'tshirt-beatles.jpg',
    'celana-jeans-zara.jpg',
    'sneaker-nike.jpg',
    'sepatu-formal-clarks.jpg',
    'sandal-adidas.jpg',
    'boots-timberland.jpg',
    'backpack-duffel.jpg',
    'briefcase-leather.jpg',
    'dompet-hermes.jpg',
    'handbag-coach.jpg',
    'gshock-watch.jpg',
    'bracelet-leather.jpg',
    'rayban-sunglasses.jpg',
    'necklace-silver.jpg',
    'dining-table-jati.jpg',
    'sofa-lshape.jpg',
    'cabinet-glass.jpg',
    'bed-wooden.jpg',
    'blender-philips.jpg',
    'microwave-panasonic.jpg',
    'iron-steam.jpg',
    'vacuum-cleaner.jpg',
    'bike-mtb.jpg',
    'yoga-mat.jpg',
    'dumbbell-set.jpg',
    'tennis-racket.jpg',
    'book-laskar.jpg',
    'comic-onepiece.jpg',
    'dvd-avatar.jpg',
    'cookbook-indo.jpg',
    'rubiks-cube.jpg',
    'game-fifa24.jpg',
    'board-game-catan.jpg',
    'figure-onepiece.jpg',
    'skincare-laroche.jpg',
    'lipstick-mac.jpg',
    'serum-argan.jpg',
    'perfume-sauvage.jpg',
    'coffee-arabika.jpg',
    'tea-jasmine.jpg',
    'chocolate-dark.jpg',
    'honey-flores.jpg',
];

$colors = [
    '3498db', // Blue
    'e74c3c', // Red
    '2ecc71', // Green
    'f39c12', // Orange
    '9b59b6', // Purple
    '1abc9c', // Turquoise
    'e67e22', // Dark Orange
    'c0392b', // Dark Red
];

$count = 0;
foreach ($products as $index => $filename) {
    $filePath = $storageDir . '/' . $filename;
    
    if (file_exists($filePath)) {
        echo "✓ File sudah ada: $filename\n";
        continue;
    }
    
    // Generate simple placeholder image
    $width = 400;
    $height = 400;
    $image = imagecreatetruecolor($width, $height);
    
    // Random background color
    $color = $colors[$index % count($colors)];
    $bgColor = imagecolorallocate($image, 
        hexdec(substr($color, 0, 2)),
        hexdec(substr($color, 2, 2)),
        hexdec(substr($color, 4, 2))
    );
    
    imagefill($image, 0, 0, $bgColor);
    
    // Add text
    $textColor = imagecolorallocate($image, 255, 255, 255);
    $fontSize = 5;
    $text = basename($filename, '.jpg');
    $textWidth = imagefontwidth($fontSize) * strlen($text);
    $textX = ($width - $textWidth) / 2;
    $textY = ($height - imagefontheight($fontSize)) / 2;
    
    imagestring($image, $fontSize, $textX, $textY, $text, $textColor);
    
    // Save image
    imagejpeg($image, $filePath, 85);
    imagedestroy($image);
    
    $count++;
    echo "✓ Dibuat: $filename\n";
}

echo "\n✓ Total placeholder images dibuat: $count\n";
echo "✓ Folder: " . $storageDir . "\n";
?>
