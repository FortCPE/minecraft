<?php
$access_token = '5xagYCkXxAmdrP4iQQUojiMKUzgrpkJpN5UpdFYbwSZdJHqJAcKEB7a8X++rfyDKWP7Mo3HTmE2wLnq+rQv5DdCLHISdBvWwmA6rmyDp66lsziSB/UVBpkhXnmgsZ8IB1b2NHyVEvaWcYaq8cnFD3QdB04t89/1O/w1cDnyilFU=';
// Get POST body content
if(isset($_POST)){
    $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";
   //รับข้อความจากผู้ใช้
   $message = $arrayJson['events'][0]['message']['text'];
   //รับ id ของผู้ใช้
   $id = ["U72c641a79b2f1a785a7b362df99931ae","U48354b8b07d4977710684b8b07d2838c"];
   #ตัวอย่าง Message Type "Text + Sticker"
   $arrayPostData['to'] = $id;
   if(isset($_POST)){
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = "Hello";
   }
   pushMsg($arrayHeader,$arrayPostData);
  
   function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/v2/bot/message/multicast";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($ch);
      curl_close ($ch);
   }
   exit;  
}else{

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
                                        "text" => "@cmm"
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
                                        "text" => "@amount"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "รายชื่อผู้เล่น Online",
                                        "text" => "@list"
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
            }else if($text == "@amount"){
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
                                        "text" => "@count:25565"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Server 1 (Survival)",
                                        "text" => "@count:1"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Server 2 (Survival)",
                                        "text" => "@count:2"
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
                                        "text" => "@count:3"
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
            }else if(strpos($text, "@count") !== false){
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
                        $all_players = "";
                        $count = 0;
                        for ($i=0; $i < count($status->players->list); $i++) { 
                            $count++;
                            $all_players .= $count.") ".$status->players->list[$i]."\n";
                        }
                        $messages = [
                            [
                                'type' => 'text',
                                'text' => '[System] ผู้เล่นทั้งหมด'
                            ],
                            [
                                'type' => 'text',
                                'text' => $status->players->online.' / '.$status->players->max.' คน'
                            ]
                        ];
                    }
                }
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
            }else if($text == "@list"){
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
                                        "text" => "@who:25565"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Server 1 (Survival)",
                                        "text" => "@who:1"
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Server 2 (Survival)",
                                        "text" => "@who:2"
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
                                        "text" => "@who:3"
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
            }else if(strpos($text, '@who') !== false){
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
                        $all_players = "";
                        $count = 0;
                        for ($i=0; $i < count($status->players->list); $i++) { 
                            $count++;
                            $all_players .= $count.") ".$status->players->list[$i]."\n";
                        }
                        $messages = [
                            [
                                'type' => 'text',
                                'text' => '[System] ผู้เล่นทั้งหมด '.$status->players->online.' คน'
                            ],
                            [
                                'type' => 'text',
                                'text' => $all_players
                            ]
                        ];
                    }
                }
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
            }else if($text == "@cmm"){
                $messages = [
                    [
                        'type' => 'text',
                        'text' => '[System] พิมพ์ command:คำสั่ง '
                    ],
                    [
                        'type' => 'text',
                        'text' => 'เช่น command:give <player> 16 1'
                    ],
                    [
                        'type' => 'text',
                        'text' => 'แทนชื่อผู้เล่นใน player เช่น command:give notch 16 1'
                    ]
                ];
            }else if(strpos($text, 'command') !== false){
                $get_text = explode(":", $text);
                $messages = [
                    [
                      "type" => "template",
                      "altText" => "this is a carousel template",
                      "template" => [
                          "type" => "carousel",
                          "columns" => [
                              [
                                "thumbnailImageUrl" => "https://mc-wildforest.herokuapp.com/images/bg4.jpg",
                                "imageBackgroundColor" => "#FFFFFF",
                                "title" => "เลือกเซิฟเวอร์ที่ต้องการส่งคำสั่ง",
                                "text" => "กดเลือกได้เลยครับ",
                                "actions" => [
                                    [
                                        "type" => "message",
                                        "label" => "Server 1 (Survival)",
                                        "text" => "@send:server1:".$get_text[1]
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Server 2 (Survival)",
                                        "text" => "@send:server2:".$get_text[1]
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
            }else if(strpos($text, '@send') !== false){
                $get_words = explode(":", $text);
                $post = [
                    'server' => $get_words[1],
                    'command' => $get_words[2]
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://mc-wildforest.com/rcon/index.php');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
                $response = curl_exec($ch);
                $messages = [
                    [
                        'type' => 'text',
                        'text' => '[System] ส่งคำสั่งแล้วครับ'
                    ]
                ];
            
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
                                        "label" => "Server 1 (Survival)",
                                        "text" => "@announce:server1:".$get_text[1]
                                    ],
                                    [
                                        "type" => "message",
                                        "label" => "Server 2 (Survival)",
                                        "text" => "@announce:server2:".$get_text[1]
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
            }else if(strpos($text, '@announce') !== false){
                $get_words = explode(":", $text);
                $post = [
                    'server' => $get_words[1],
                    'message' => $get_words[2]
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://mc-wildforest.com/rcon/index.php');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
                $response = curl_exec($ch);
                if($response == "success"){
                    $messages = [
                        [
                            'type' => 'text',
                            'text' => '[System] ส่งข้อความแล้วครับ'
                        ]
                    ];
                }else{
                    $messages = [
                        [
                            'type' => 'text',
                            'text' => '[System] Server Offline'
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
echo "K";
}
?>

