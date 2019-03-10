<?php
$access_token = '5xagYCkXxAmdrP4iQQUojiMKUzgrpkJpN5UpdFYbwSZdJHqJAcKEB7a8X++rfyDKWP7Mo3HTmE2wLnq+rQv5DdCLHISdBvWwmA6rmyDp66lsziSB/UVBpkhXnmgsZ8IB1b2NHyVEvaWcYaq8cnFD3QdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
class Rcon {
private $host;
private $port;
private $password;
private $timeout;
private $socket;
private $authorized;
private $last_response;
const PACKET_AUTHORIZE = 5;
const PACKET_COMMAND = 6;
const SERVERDATA_AUTH = 3;
const SERVERDATA_AUTH_RESPONSE = 2;
const SERVERDATA_EXECCOMMAND = 2;
const SERVERDATA_RESPONSE_VALUE = 0;
public function __construct($host,$port,$password,$timeout)
{
$this->host = $host;
$this->port = $port;
$this->password = $password;
$this->timeout = $timeout;
}
public function get_response() {
return $this->last_response;
}
public function connect() {
$this->socket = fsockopen($this->host,$this->port,$errno,$errstr,$this->timeout);
if (!$this->socket)
{
$this->last_response = $errstr;
return false;
}
stream_set_timeout($this->socket,3,0);
$auth = $this->authorize();
if ($auth) {
return true;
}
return false;
}
public function disconnect()
{
if ($this->socket)
{
fclose($this->socket);
}
}
public function is_connected() {
return $this->authorized;
}
public function send_command($command)
{
if (!$this->is_connected()) return false;
$this->write_packet(Rcon::PACKET_COMMAND,Rcon::SERVERDATA_EXECCOMMAND,$command);
$response_packet = $this->read_packet();
if ($response_packet['id'] == Rcon::PACKET_COMMAND)
{
if ($response_packet['type'] == Rcon::SERVERDATA_RESPONSE_VALUE)
{
$this->last_response = $response_packet['body'];
return $response_packet['body'];
}
}
return false;
}
private function authorize() {
$this->write_packet(Rcon::PACKET_AUTHORIZE,Rcon::SERVERDATA_AUTH,$this->password);
$response_packet = $this->read_packet();
if ($response_packet['type'] == Rcon::SERVERDATA_AUTH_RESPONSE)
{
if ($response_packet['id'] == Rcon::PACKET_AUTHORIZE)
{
$this->authorized = true;
return true;
}
}
$this->disconnect();
return false;
}
private function write_packet($packet_id,$packet_type,$packet_body)
{
$packet = pack("VV",$packet_id,$packet_type);
$packet = $packet .$packet_body ."\x00";
$packet = $packet ."\x00";
$packet_size = strlen($packet);
$packet = pack("V",$packet_size) .$packet;
fwrite($this->socket,$packet,strlen($packet));
}
private function read_packet()
{
$size_data = fread($this->socket,4);
$size_pack = unpack("V1size",$size_data);
$size = $size_pack['size'];
$packet_data = fread($this->socket,$size);
$packet_pack = unpack("V1id/V1type/a*body",$packet_data);
return $packet_pack;
}
}; 
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
                
            if(strpos($text, 'เมนู') !== false || strpos($text, 'เซิฟเวอร์') !== false){
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
            }else if(strpos($text, 'say') !== false){
                $get_server = explode(":", $text);
                $host = 'mc-wildforest.com';
                $port = '25595';
                $password = 'GMPOapomsqzakq503';
                $timeout = 30;
                $rcon = new Rcon($host,$port,$password,$timeout);
                if ($rcon->connect()) {
                    $rcon->send_command("broadcast Hello");
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
