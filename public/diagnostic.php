<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>DBR - Diagnostic</title>
    <style>
        body { font-family: monospace; background: #0b0f19; color: #f3f4f6; padding: 20px; }
        h1 { color: #f59e0b; }
        h2 { color: #3b82f6; border-bottom: 1px solid #333; padding-bottom: 5px; }
        .ok { color: #10b981; }
        .ko { color: #ef4444; }
        pre { background: #121a2b; padding: 10px; border-radius: 8px; overflow-x: auto; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        td, th { padding: 8px; border: 1px solid #333; text-align: left; }
        th { background: #1e293b; color: #f59e0b; }
    </style>
</head>
<body>
    <h1>🔍 DBR - Diagnostic Render</h1>

    <h2>1. Environnement PHP</h2>
    <table>
        <tr><th>Variable</th><th>Valeur</th></tr>
        <tr><td>PHP Version</td><td><?= PHP_VERSION ?></td></tr>
        <tr><td>Document Root</td><td><?= $_SERVER['DOCUMENT_ROOT'] ?? 'N/A' ?></td></tr>
        <tr><td>Script Name</td><td><?= $_SERVER['SCRIPT_NAME'] ?? 'N/A' ?></td></tr>
        <tr><td>Request URI</td><td><?= $_SERVER['REQUEST_URI'] ?? 'N/A' ?></td></tr>
        <tr><td>Server Software</td><td><?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></td></tr>
        <tr><td>User</td><td><?= get_current_user() ?></td></tr>
    </table>

    <h2>2. Chemins Laravel</h2>
    <table>
        <tr><th>Chemin</th><th>Valeur</th><th>Existe</th></tr>
        <?php
        $paths = [
            'Dossier actuel' => __DIR__,
            'Parent (racine projet)' => dirname(__DIR__),
            'Dossier public' => __DIR__,
            'Dossier Backend' => __DIR__ . '/Backend',
            'Dossier assets' => __DIR__ . '/Backend/assets',
            'Dossier images' => __DIR__ . '/Backend/assets/images',
            'Logo3.png' => __DIR__ . '/Backend/assets/images/logo3.png',
            'Logo-sm.png' => __DIR__ . '/Backend/assets/images/logo-sm.png',
            'app-modern.min.css' => __DIR__ . '/Backend/assets/css/app-modern.min.css',
            'app.min.js' => __DIR__ . '/Backend/assets/js/app.min.js',
            'Favicon' => __DIR__ . '/Backend/assets/images/favicon.ico',
            'Index.php' => __DIR__ . '/index.php',
            'htaccess' => __DIR__ . '/.htaccess',
        ];
        foreach ($paths as $label => $path) {
            $exists = file_exists($path);
            $class = $exists ? 'ok' : 'ko';
            $icon = $exists ? '✅' : '❌';
            echo "<tr>";
            echo "<td>$label</td>";
            echo "<td style='font-size:11px'>$path</td>";
            echo "<td class='$class'>$icon " . ($exists ? 'OUI' : 'NON') . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h2>3. Détails du logo3.png</h2>
    <?php
    $logo = __DIR__ . '/Backend/assets/images/logo3.png';
    if (file_exists($logo)) {
        echo "<table>";
        echo "<tr><td>Taille</td><td>" . filesize($logo) . " octets</td></tr>";
        echo "<tr><td>Lisible</td><td>" . (is_readable($logo) ? '✅ OUI' : '❌ NON') . "</td></tr>";
        echo "<tr><td>Type MIME</td><td>" . mime_content_type($logo) . "</td></tr>";
        echo "<tr><td>Permissions</td><td>" . substr(sprintf('%o', fileperms($logo)), -4) . "</td></tr>";
        echo "</table>";
    } else {
        echo "<p class='ko'>❌ Logo introuvable à : $logo</p>";
    }
    ?>

    <h2>4. Contenu du dossier images</h2>
    <pre><?php
    $dir = __DIR__ . '/Backend/assets/images';
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $f) {
            if ($f !== '.' && $f !== '..') {
                $size = filesize($dir . '/' . $f);
                echo str_pad($f, 40) . " " . number_format($size) . " octets\n";
            }
        }
    } else {
        echo "❌ Dossier introuvable : $dir";
    }
    ?></pre>

    <h2>5. Contenu du dossier Backend</h2>
    <pre><?php
    $dir = __DIR__ . '/Backend';
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $f) {
            if ($f !== '.' && $f !== '..') {
                echo $f . (is_dir($dir . '/' . $f) ? '/' : '') . "\n";
            }
        }
    } else {
        echo "❌ Dossier introuvable : $dir";
    }
    ?></pre>

    <h2>6. Contenu du dossier public</h2>
    <pre><?php
    $files = scandir(__DIR__);
    foreach ($files as $f) {
        if ($f !== '.' && $f !== '..') {
            echo $f . (is_dir(__DIR__ . '/' . $f) ? '/' : '') . "\n";
        }
    }
    ?></pre>

    <h2>7. Variables d'environnement</h2>
    <table>
        <tr><th>Variable</th><th>Valeur</th></tr>
        <?php
        $envVars = ['APP_ENV', 'APP_DEBUG', 'APP_URL', 'ASSET_URL', 'APP_KEY'];
        foreach ($envVars as $var) {
            $val = getenv($var) ?: ($_ENV[$var] ?? 'NON DÉFINI');
            echo "<tr><td>$var</td><td>" . htmlspecialchars($val) . "</td></tr>";
        }
        ?>
    </table>

    <h2>8. .htaccess dans public/</h2>
    <pre><?php
    $htaccess = __DIR__ . '/.htaccess';
    echo file_exists($htaccess) 
        ? htmlspecialchars(file_get_contents($htaccess))
        : '❌ .htaccess absent';
    ?></pre>

    <h2>9. Test de lecture directe du logo</h2>
    <?php
    $logo = __DIR__ . '/Backend/assets/images/logo3.png';
    if (file_exists($logo)) {
        $data = file_get_contents($logo);
        echo "<p class='ok'>✅ Lecture réussie : " . strlen($data) . " octets chargés en mémoire</p>";
        echo "<p>Signature PNG : " . bin2hex(substr($data, 0, 8)) . " (doit être 89504e470d0a1a0a)</p>";
    } else {
        echo "<p class='ko'>❌ Impossible de lire le fichier</p>";
    }
    ?>

</body>
</html>
