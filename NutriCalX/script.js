document.getElementById("foodForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const foodItem = document.getElementById("food_item").value;
    const quantity = document.getElementById("quantity").value;

    fetch('apihandler.php', { // Updated to use apihandler.php
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            foodItem: foodItem,
            quantity: quantity,
        })
    })
    .then(response => response.json())
    .then(data => {
        const resultDiv = document.getElementById("result");
        const foodImage = document.getElementById("foodImage");
        resultDiv.innerHTML = ""; // Clear previous results

        if (data.success) {
            foodImage.src = data.image; // Set the food image
            foodImage.style.display = 'block'; // Show the food image
            resultDiv.innerHTML = "<h3>Nutritional Information:</h3><ul>";
            for (const [key, value] of Object.entries(data.data)) {
                resultDiv.innerHTML += `<li>${key}: ${value} g</li>`;
            }
            resultDiv.innerHTML += "</ul>";
        } else {
            resultDiv.innerHTML = `<p>${data.message}</p>`;
            foodImage.style.display = 'none'; // Hide image if there's an error
        }
    })
    .catch(error => console.error('Error:', error));
});
