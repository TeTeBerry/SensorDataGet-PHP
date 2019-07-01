#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>




// Set these to run example.
const char *host = "172.20.10.2";
const char *ssid = "Hi bich";
const char *password = "19941010Lzy!";

byte statusLed    = 13;
byte sensorInterrupt = 0;  // 0 = digital pin 2
byte sensorPin       = D3;
float calibrationFactor = 4.5;
volatile byte pulseCount;  
String sensorName = "Sensor-1";
float flowRate;
unsigned int flowMilliLitres;
unsigned long totalMilliLitres;
unsigned long oldTime;

void setup() {
  Serial.begin(9600);
 
  pinMode(statusLed, OUTPUT);
  digitalWrite(statusLed, HIGH); 
  pinMode(sensorPin, INPUT);
  digitalWrite(sensorPin, HIGH);
  pulseCount        = 0;
  flowRate          = 0.0;
  flowMilliLitres   = 0;
  totalMilliLitres  = 0;
  oldTime           = 0;
  attachInterrupt(sensorInterrupt, pulseCounter, FALLING);

  // connect to wifi.
  WiFi.begin(ssid, password);
  Serial.print("connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print("!!");
    delay(500);
  }
  Serial.println();
  Serial.print("Connected to WiFi network with IP Address: : ");
  Serial.println(WiFi.localIP());
  
}

int n = 0;

void loop() {
 if((millis() - oldTime) > 1000) {
  detachInterrupt(sensorInterrupt);
  flowRate = ((1000.0 / (millis() - oldTime)) * pulseCount) / calibrationFactor;
  oldTime = millis();
  flowMilliLitres = (flowRate / 60) * 1000;
  totalMilliLitres += flowMilliLitres;
  unsigned int frac;
  Serial.print("Flow rate: ");
  Serial.print(int(flowRate)); 
  Serial.print(".");
  frac = (flowRate - int(flowRate)) * 10;
  Serial.print(frac, DEC) ;
  frac = (flowRate - int(flowRate)) * 10;
  Serial.print(frac, DEC) ; 
  Serial.print("L/min");
  Serial.print("  Current Liquid Flowing: ");
  Serial.print(flowMilliLitres);
  Serial.print("mL/Sec");
  Serial.print("  Output Liquid Quantity: "); 
  Serial.print(totalMilliLitres);
  Serial.println("mL"); 
  pulseCount = 0;
  attachInterrupt(sensorInterrupt, pulseCounter, FALLING);
 }



  //Check wifi connection status
  if(WiFi.status()==WL_CONNECTED){
    HTTPClient http;



//    String url="?sensor="+sensorName+"&Flow rate="+flowRate+"&Current Liquid Flowing="+flowMilliLitres+"&Output Liquid Quantity="+totalMilliLitres;
//    Serial.print("url:");
//    Serial.println(url);
     String Link = "http://172.20.10.2:8088/post-esp-data.php/?sensorName="+sensorName+"&flowRate="+flowRate+"&flowMilliLitres="+flowMilliLitres+"&totalMilliLitres="+totalMilliLitres;
     http.begin(Link);

      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      


     // Specify content-type header
      
  

   
  

    
    int httpResponseCode = http.GET();
    String payload = http.getString();
    if (httpResponseCode>0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      Serial.println(payload);
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Send an HTTP POST request every 30 seconds
  delay(3000);  
  }


void pulseCounter()
{
  // Increment the pulse counter
  pulseCount++;
}