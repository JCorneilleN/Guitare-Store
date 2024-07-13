document.addEventListener('DOMContentLoaded', function() {
    // Function for shorthand querySelector
    function $(selector) {
        return document.querySelector(selector);
    }

    // Attach event handler to calculate button
    $('#calculateBtn').addEventListener('click', calculate);

    // Focus on product cost textbox
    $('#productCost').focus();

    function calculate() {
        const productCost = parseFloat($('#productCost').value);

        // Validate product cost
        if (!isNaN(productCost) && productCost > 0) {
            const totalCost = calculateShipping(productCost);
            $('#totalCost').value = totalCost.toFixed(2);
        } else {
            alert('Please enter a valid product cost greater than zero.');
        }

        // Keep focus on product cost
        $('#productCost').focus();
    }

    function calculateShipping(cost) {
        let shippingPercentage;
        if (cost <= 50) {
            shippingPercentage = 0.20;
        } else if (cost <= 200) {
            shippingPercentage = 0.18;
        } else if (cost <= 500) {
            shippingPercentage = 0.15;
        } else if (cost <= 1000) {
            shippingPercentage = 0.12;
        } else {
            shippingPercentage = 0.08;
        }
        return cost + (cost * shippingPercentage);
    }
});
