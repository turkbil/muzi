<?php
/**
 * Muzibu Path Finder
 */
define("_VALID_PHP", true);
require_once "../../init.php";

// Önemli dizinleri görelim
echo "<h1>CMS Dizin Yapısı</h1>";
echo "<pre>";
echo "BASEPATH: " . BASEPATH . "\n";
echo "MODPATH: " . MODPATH . "\n";
echo "SITEURL: " . SITEURL . "\n";
echo "</pre>";

// Dosyaların fiziksel konumunu bulalım
echo "<h2>Muzibu Modülü Dosya Konumu</h2>";
echo "<pre>";

// Dizinde dolaşarak PHP dosyalarını bulalım
function findPhpFiles($dir) {
    $results = [];
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        
        if (is_dir($path)) {
            $results = array_merge($results, findPhpFiles($path));
        } else if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $results[] = $path;
        }
    }
    
    return $results;
}

// Mevcut klasörde ve alt klasörlerde tüm PHP dosyalarını bul
$phpFiles = findPhpFiles(dirname(__FILE__));
sort($phpFiles);

echo "Bulunan PHP Dosyaları:\n";
foreach ($phpFiles as $file) {
    echo basename($file) . "\n";
}

// Muzibu modülü ana klasörünü göster
echo "\nModül dizin yapısı:\n";
function displayTree($dir, $indent = "") {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        
        if (is_dir($path)) {
            echo $indent . "[D] " . $file . "/\n";
            displayTree($path, $indent . "    ");
        } else {
            echo $indent . "[F] " . $file . "\n";
        }
    }
}

displayTree(dirname(__FILE__));

echo "</pre>";

// Kodumuzdaki relative path sorununu çözelim
echo "<h2>Çözüm Önerisi</h2>";
echo "<p>Dosya yolları hatalı olduğundan, <code>main.php</code> dosyasını aşağıdaki yola yerleştirmeniz gerekiyor:</p>";
echo "<code>" . dirname(__FILE__) . "/main.php</code>";

// Mevcut içe aktarma mekanizmasını görelim
echo "<h2>include_once Mekanizması Test</h2>";
echo "<pre>";
$testInclude = "main.php";
echo "include_once(\"$testInclude\") aradığında aşağıdaki yolda aranır:\n";
echo "- " . dirname(__FILE__) . "/$testInclude\n";
echo "- " . MODPATH . "muzibu/$testInclude\n";
echo "</pre>";
?>