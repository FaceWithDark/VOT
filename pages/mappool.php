<?php
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

require_once '../layouts/navigation_bar.php';

// Fetch beatmap data from the Osu! API
function fetchBeatmapData($beatmapId) {
    $accessToken = $_COOKIE['vot_access_token'] ?? null;
    if (!$accessToken) {
        // Access token is not available
        return false;
    }

    $apiUrl = "https://osu.ppy.sh/api/v2/beatmaps/{$beatmapId}";
    $client = new Client();

    try {
        $response = $client->get($apiUrl, [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ]
        ]);

        if ($response->getStatusCode() === 200) {
            return json_decode($response -> getBody() -> getContents());
        }
        // API call did not return a 200 status
        return false;
    } 
    catch (RequestException $exception) {
        error_log($exception -> getMessage());    // Log the exception message
        return false;                           // An exception occurred during the API call
    }
}

// Get the 'Beatmap Id' from the API call
$beatmapData1 = fetchBeatmapData(3271670);
$beatmapData2 = fetchBeatmapData(3524450);

// die('<pre>' . print_r($beatmapData1, true) . '</pre>');
// die('<pre>' . print_r($beatmapData2, true) . '</pre>');
?>

<section>
    <div class="mappool-page">
        <div class="mappool-card-container">
            <h1>NM1</h1>
            
            <br>

            <a href="<?= htmlspecialchars($beatmapData1 -> url); ?>"><img src="<?= htmlspecialchars($beatmapData1 -> beatmapset -> covers -> cover); ?>" width="490px" alt="Beatmap Cover"></a>
            
            <br><br>

            <h2><?= htmlspecialchars($beatmapData1 -> beatmapset -> title_unicode); ?> [<?= htmlspecialchars($beatmapData1 -> version); ?>]</h2>
            <h3><?= htmlspecialchars($beatmapData1 -> beatmapset -> artist_unicode); ?></h3>
            <h4 class="beatmap-creator-row">
                Mapset by <a href="https://osu.ppy.sh/users/5938161"><?= htmlspecialchars($beatmapData1 -> beatmapset -> creator); ?></a>
            </h4>
            
            <br>

            <div class="beatmap-attribute-row">
                <p style="margin-right: 1rem;"><i class='bx bx-star'></i> <?= htmlspecialchars($beatmapData1 -> difficulty_rating); ?></p>
                <p style="margin-right: 1rem;"><i class='bx bx-timer'></i> <?php echo "1:48"; ?></p>                        
                <p><i class='bx bx-tachometer'></i> <?= htmlspecialchars($beatmapData1 -> bpm); ?>bpm</p>
            </div>

            <br>

            <div class="beatmap-attribute-row">
                <p style="margin-right: 1rem;">OD: <?= htmlspecialchars($beatmapData1 -> accuracy); ?></p>
                <p style="margin-right: 1rem;">HP: <?= htmlspecialchars($beatmapData1 -> drain); ?></p>
                <p>Passed: <?= htmlspecialchars($beatmapData1 -> passcount); ?></p>
            </div>
        </div>

        <div class="mappool-card-container">
            <h1>NM2</h1>
            
            <br>

            <a href="<?= htmlspecialchars($beatmapData2 -> url); ?>"><img src="<?= htmlspecialchars($beatmapData2 -> beatmapset -> covers -> cover); ?>" width="490px" alt="Beatmap Cover"></a>
            
            <br><br>

            <h2><?= htmlspecialchars($beatmapData2 -> beatmapset -> title_unicode); ?> [<?= htmlspecialchars($beatmapData2 -> version); ?>]</h2>
            <h3><?= htmlspecialchars($beatmapData2 -> beatmapset -> artist_unicode); ?></h3>
            <h4 class="beatmap-creator-row">
                Mapset by <a href="https://osu.ppy.sh/users/5938161"><?= htmlspecialchars($beatmapData2 -> beatmapset -> creator); ?></a>
            </h4>
            
            <br>

            <div class="beatmap-attribute-row">
                <p style="margin-right: 1rem;"><i class='bx bx-star'></i> <?= htmlspecialchars($beatmapData2 -> difficulty_rating); ?></p>
                <p style="margin-right: 1rem;"><i class='bx bx-timer'></i> <?php echo "1:48"; ?></p>                        
                <p><i class='bx bx-tachometer'></i> <?= htmlspecialchars($beatmapData2 -> bpm); ?>bpm</p>
            </div>

            <br>
            
            <div class="beatmap-attribute-row">
                <p style="margin-right: 1rem;">OD: <?= htmlspecialchars($beatmapData2 -> accuracy); ?></p>
                <p style="margin-right: 1rem;">HP: <?= htmlspecialchars($beatmapData2 -> drain); ?></p>
                <p>Passed: <?= htmlspecialchars($beatmapData2 -> passcount); ?></p>
            </div>
        </div>
</section>
