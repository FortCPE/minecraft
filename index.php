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
                                        "label" => "วิธี Broadcast ลงเซิฟเวอร์",
                                        "text" => "@broadcast"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "วิธีส่ง Command ลงเซิฟเวอร์",
                                        "text" => "@command"
                                    ]
                                ]
                              ]
                          ],
                          "imageAspectRatio" => "rectangle",
                          "imageSize" => "cover"
                      ]
                    ]
                ];
            }else if($text == "@status"){
                $messages = [
                    [
                      "type" => "template",
                      "altText" => "this is a carousel template",
                      "template" => [
                          "type" => "carousel",
                          "columns" => [
                              [
                                "thumbnailImageUrl" => "https://mc-wildforest.herokuapp.com/images/bg3.png",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => "เซิฟเวอร์ทั้งหมด",
                                "text" => "กดเลือกได้เลยครับ",
                                "actions" => [
                                    [
                                        "type" => "message",
                                        "label" => "Lobby Server",
                                        "text" => "@online:25565"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Server 1 (Survival)",
                                        "text" => "@online:1"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Server 2 (Survival)",
                                        "text" => "@online:2"
                                    ]
                                ]
                              ],
                              [
                                "thumbnailImageUrl" => "https://mc-wildforest.herokuapp.com/images/bg4.jpg",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => "เซิฟเวอร์ทั้งหมด",
                                "text" => "กดเลือกได้เลยครับ",
                                "actions" => [
                                    [
                                        "type" => "message",
                                        "label" => "Server 3 (MMO)",
                                        "text" => "@online:3"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "-",
                                        "text" => "-"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "-",
                                        "text" => "-"
                                    ]
                                ]
                              ]
                          ],
                          "imageAspectRatio" => "rectangle",
                          "imageSize" => "cover"
                      ]
                    ]
                ];
            }else if(strpos($text, '@online') !== false){
                $get_server = explode(":", $text);
                if($get_server[1] != null){
                    $status = json_decode(file_get_contents('https://api.mcsrvstat.us/1/mc-wildforest.com:'.$get_server[1]));
                    if($status->offline == true){
                        $messages = [
                            [
                                'type' => 'text',
                                'text' => '[System] เซิฟเวอร์ Offline ครับ'
                            ]
                        ];
                    }else{
                        $messages = [
                            [
                                'type' => 'text',
                                'text' => '[System] เซิฟเวอร์ Online ครับ'
                            ]
                        ];
                    }
                }
            }else if($text == '@broadcast'){
                $messages = [
                    [
                        'type' => 'text',
                        'text' => 'say:เซิฟเวอร์ที่ต้องการ:ประโยคที่ต้องการประกาศ'
                    ],
                    [
                        'type' => 'text',
                        'text' => 'ตัวอย่าง'
                    ],
                    [
                        'type' => 'text',
                        'text' => 'say:server0:Hello Players'
                    ]
                ];
            }else if(strpos($text, 'say') !== false){
                $get_server = explode(":", $text);
                if($get_server[1] == "server1"){
                    include_once("https://mc-wildforest.herokuapp.com/src/rcon.class.php");  
                      
                    $r = new rcon("mc-wildforest.com",25595,"GMPOapomsqzakq503");  
                    $r->Auth();  
                    //Send a request  
                    $r->rconCommand("broadcast hello"); 
                    $messages = [
                    [
                        'type' => 'text',
                        'text' => var_dump($r->rconCommand("broadcast hello"))
                    ]
                ]; 
                }
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
