<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
</head>

<body>
    <div
        style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 10px;">
        <h1 style="color: #EBA9AE; text-align: center;">Sweet Success!</h1>
        <p>Hey {{ $name }},</p>
        <p>Woohoo! Your slice of happiness is on its way! 🎂✨</p>
        <p>We're thrilled that you've ordered a cake from us. It's like you've just planted a seed of joy that's about
            to bloom into a delicious masterpiece!</p>
        <p>Here's the scoop on your sweet investment:</p>
        <ul style="background-color: #fff; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);list-style: none;">
            <li><strong>Payment ID:</strong> {{ $payment_id }} (as unique as your taste buds!)</li>
            <li><strong>Payment Date:</strong> {{ $payment_date }} (a day that will go down in dessert history)</li>
            <li><strong>Payment Status:</strong> {{ $payment_status }} (smooth as buttercream)</li>
            <li><strong>Payment Method:</strong> {{ $payment_method }} (your chosen path to pastry perfection)</li>
            <li><strong>Payment Amount:</strong> Rp.{{ $amount }} (a small price for a big smile)</li>
        </ul>
        <p>We're now mixing, baking, and frosting your dreams into reality. Your taste buds are in for a treat!</p>
        <p>If you have any questions or sudden cravings for extra sprinkles, don't hesitate to reach out. We're here to
            make your cake experience extra sweet.</p>
        <p>Stay tuned for more updates on your order. It's going to be a piece of cake! 😉</p>
        <p style="text-align: center; font-style: italic; margin-top: 20px;">Baking your day brighter, one cake at a
            time!</p>
        <p style="text-align: center;">The Cake Wizards at <span style="color: #ff69b4; font-weight: bold;">SweetDreams
                Bakery</span></p>
    </div>
</body>

</html>
