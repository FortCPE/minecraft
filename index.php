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
                                "thumbnailImageUrl" => "https://mc-wildforest.herokuapp.com/images/bg2.png",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => "ตัวเลือกทั้งหมด",
                                "text" => "กดเลือกได้เลยครับ",
                                "actions" => [
                                    [
                                        "type" => "message",
                                        "label" => "สถานะเซิฟเวอร์",
                                        "text" => "@status"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Broadcast",
                                        "text" => "@broadcast"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Command",
                                        "text" => "@command"
                                    ]
                                ]
                              ],
                              [
                                "thumbnailImageUrl" => "https://mc-wildforest.herokuapp.com/images/bg1.jpg",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => "ตัวเลือกทั้งหมด",
                                "text" => "กดเลือกได้เลยครับ",
                                "actions" => [
                                    [
                                        "type" => "message",
                                        "label" => "จำนวนผู้เล่น Online",
                                        "text" => "@online"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "รายชื่อผู้เล่น Online",
                                        "text" => "@list"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Ping Server",
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
            }else if($text == "@broadcast"){
                $messages = [
                    [
                        'type' => 'text',
                        'text' => '[System] พิมพ์ say:คำพูด '
                    ]
                ];
            }else if(strpos($text, 'say') !== false){
                $get_text = explode(":", $text);
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
                                "title" => "เลือกเซิฟเวอร์ที่ต้องการ Broadcast",
                                "text" => "กดเลือกได้เลยครับ",
                                "actions" => [
                                    [
                                        "type" => "message",
                                        "label" => "Lobby Server",
                                        "text" => "@announce:server0:".$get_text[1]
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Server 1 (Survival)",
                                        "text" => "@announce:server1:".$get_text[1]
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Server 2 (Survival)",
                                        "text" => "@announce:server2:".$get_text[1]
                                    ]
                                ]
                              ],
                              [
                                "thumbnailImageUrl" => "https://mc-wildforest.herokuapp.com/images/bg4.jpg",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => "เลือกเซิฟเวอร์ที่ต้องการ Broadcast",
                                "text" => "กดเลือกได้เลยครับ",
                                "actions" => [
                                    [
                                        "type" => "message",
                                        "label" => "Server 3 (MMO)",
                                        "text" => "@announce:server3:".$get_text[1]
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
            }else if(strpos($text, '@announce')){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://mc-wildforest.com/rcon");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, true);

                $data = array(
                    'foo' => 'foo foo foo',
                    'bar' => 'bar bar bar',
                    'baz' => 'baz baz baz'
                );

                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $output = curl_exec($ch);
                $info = curl_getinfo($ch);
                curl_close($ch);
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

