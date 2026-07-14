<?php
require_once "../config/gemini_config.php";

function askGemini($prompt)
{
    // Menggunakan header X-Goog-Api-Key lebih disarankan daripada menaruh key di URL
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent";

    $data = [
        "contents" => [
            [
                "parts" => [
                    [
                        "text" => $prompt
                    ]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "x-goog-api-key: " . GEMINI_API_KEY // API Key dikirim lewat header
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return json_encode(["error" => ["message" => $error_msg]]);
    }

    curl_close($ch);

    return $response;
}
?>