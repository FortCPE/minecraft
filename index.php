<?php
$access_token = '5xagYCkXxAmdrP4iQQUojiMKUzgrpkJpN5UpdFYbwSZdJHqJAcKEB7a8X++rfyDKWP7Mo3HTmE2wLnq+rQv5DdCLHISdBvWwmA6rmyDp66lsziSB/UVBpkhXnmgsZ8IB1b2NHyVEvaWcYaq8cnFD3QdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
            $text = $event['message']['text'];              
            //Get Group ID
            $groupId = $event['source']['groupId'];
            //Get User ID
            $userId = $event['source']['userId'];
            // Get replyToken
            $replyToken = $event['replyToken'];
                
            if(strpos($text, 'เมนู') !== false){
                $messages = [
                    [
                      "type" => "template",
                      "altText" => "this is a carousel template",
                      "template" => [
                          "type" => "carousel",
                          "columns" => [
                              [
                                "thumbnailImageUrl" => "https://mc-wildforest.herokuapp.com/images/bg1.jpg",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => "ตัวเลือก",
                                "text" => "กดเลือกได้เลยครับ",
                                "actions" => [
                                    [
                                        "type" => "message",
                                        "label" => "สถานะเซิฟเวอร์",
                                        "text" => "@status"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Broadcast ลงเซิฟเวอร์",
                                        "text" => "@broadcast"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "ส่ง Command ลงเซิฟเวอร์",
                                        "text" => "@command"
                                    ]
                                ]
                              ],
                              [
                                "thumbnailImageUrl" => "https://mc-wildforest.herokuapp.com/images/bg2.png",
                                "imageBackgroundColor" => "#000000",
                                "title" => "ตัวเลือก",
                                "text" => "กดเลือกได้เลยครับ",
                                "actions" => [
                                    [
                                        "type" => "message",
                                        "label" => "จำนวนผู้เล่นออนไลน์ ขณะนี้",
                                        "text" => "@count"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "รายชื่อผู้เล่นออนไลน์ ขณะนี้",
                                        "text" => "@list"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "ค่า Ping เซิฟเวอร์",
                                        "text" => "@ping"
                                    ]
                                ]
                              ]
                          ],
                          "imageAspectRatio" => "rectangle",
                          "imageSize" => "cover"
                      ]
                    ]
                ];
            }

            // Make a POST Request to Messaging API to reply to sender
            $url = 'https://api.line.me/v2/bot/message/reply';
            $data = [
                'replyToken' => $replyToken,
                'messages' => [$messages][0],
            ];
            $post = json_encode($data);
            $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            echo $result . "\r\n";
        }
    }
}
echo "OK";
?>
