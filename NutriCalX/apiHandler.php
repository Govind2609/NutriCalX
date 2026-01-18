<?php
// apihandler.php

// Include the fetchdata.php file to access the fetchNutritionData function
include 'fetchdata.php';
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve food item and quantity from POST data
    $foodItem = htmlspecialchars($_POST["foodItem"]);
    $quantity = htmlspecialchars($_POST["quantity"]);

    // Fetch data from OpenFoodFacts API
    $data = fetchNutritionData($foodItem);

    if ($data && isset($data['products']) && count($data['products']) > 0) {
        $nutrients = $data['products'][0]['nutriments'];
        $result = [];

        // Calculate nutrient values based on the quantity
        foreach ($nutrients as $key => $value) {
            if (in_array($key, [
                'energy-kcal',
                'proteins',
                'fat',
                'carbohydrates',
                'fiber',
                'sugars',
                'sodium',
                'salt',
                'calcium',
                'potassium',
                'vitaminC',
                'vitaminA',
                'iron'
            ])) {
                $result[$key] = round($value * ($quantity / 100), 2);
            }
        }

        // Get image URL
        $imageUrl = isset($data['products'][0]['image_url']) ? $data['products'][0]['image_url'] : '';

        echo json_encode(['success' => true, 'data' => $result, 'image' => $imageUrl]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No data found for the food item: ' . $foodItem]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
