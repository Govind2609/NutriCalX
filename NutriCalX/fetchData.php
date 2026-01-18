<?php
// fetchdata.php

// Function to fetch nutritional data from OpenFoodFacts API
function fetchNutritionData($foodItem) {
    $apiUrl = 'https://world.openfoodfacts.org/cgi/search.pl?search_terms=' . urlencode($foodItem) . '&json=true';
    $response = file_get_contents($apiUrl);
    return json_decode($response, true);
}
?>
