<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
</head>

<body>
    <div
        style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 10px;">
        <h1 style="color: #EBA9AE; text-align: center;">Manisnya Kebahagiaan!</h1>
        <p>Hai {{ $name }},</p>
        <p>Yeay! Kebahagiaan Anda sedang dalam perjalanan! 🎂✨</p>
        <p>Senang sekali Anda memilih memesan kue dari kami. Ibarat menanam benih kebahagiaan yang akan mekar menjadi
            mahakarya yang lezat!</p>
        <p>Ini detail investasi manis Anda:</p>
        <ul
            style="background-color: #fff; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); list-style: none;">
            <li><strong>ID Pembayaran:</strong> {{ $payment_id }} (unik seperti selera Anda!)</li>
            <li><strong>Tanggal Pembayaran:</strong> {{ $payment_date }} (hari bersejarah untuk dunia pencuci mulut)
            </li>
            <li><strong>Status Pembayaran:</strong> {{ $payment_status }} (lembut dan mulus seperti buttercream)</li>
            <li><strong>Metode Pembayaran:</strong> {{ $payment_method }} (jalan menuju kesempurnaan kue pilihan Anda)
            </li>
            <li><strong>Jumlah Pembayaran:</strong> Rp.{{ $amount }} (harga kecil untuk senyum besar)</li>
        </ul>
        <p>Saat ini kami sedang mencampur, memanggang, dan menyiapkan impian Anda menjadi kenyataan. Bersiaplah untuk
            memanjakan lidah Anda!</p>
        <p>Kalau ada pertanyaan atau tiba-tiba ngidam topping ekstra, jangan ragu untuk menghubungi kami. Kami di sini
            untuk membuat pengalaman kue Anda lebih istimewa.</p>
        <p>Ikuti terus kabar tentang pesanan Anda. Ini akan jadi pengalaman manis tanpa usaha! 😉</p>
        <p style="text-align: center; font-style: italic; margin-top: 20px;">Mencerahkan hari Anda, satu kue pada satu
            waktu!</p>
        <p style="text-align: center;">Tim Ahli Kue dari <span style="color: #ff69b4; font-weight: bold;">SweetDreams
                Bakery</span></p>
    </div>

</body>

</html>
