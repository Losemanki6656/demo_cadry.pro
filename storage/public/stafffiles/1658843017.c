#include <Wire.h>
#include <DHT.h>
#include <SoftwareSerial.h>
SoftwareSerial myserial(10,9);
#include <ArduinoJson.h>
StaticJsonBuffer<200> jsonBuffer; 

#include <OneWire.h>
#include <DallasTemperature.h>

#define ONE_WIRE_BUS 7
 
OneWire oneWire(ONE_WIRE_BUS);
 
DallasTemperature sensor(&oneWire);
 
 
#define DHTPIN A1
#define DHTTYPE DHT11
#include <iarduino_RTC.h>

iarduino_RTC time(RTC_DS1302,8,6,7);

DHT dht(DHTPIN, DHTTYPE);

char t[32];
int deviceID = 10;
 float temperature;
 int q=0;
void setup()
{
  myserial.begin(115200);
  Serial.begin(115200);
  Serial.println("Initializing..........");
  dht.begin();
  Wire.begin();
  DynamicJsonBuffer jsonBuffer;
  delay(5000);
  sensor.begin();
  sensor.setResolution(12);
  time.begin();
   
  sensor.requestTemperatures();
  temperature = sensor.getTempCByIndex(0);
  inetapn();
  SendJson();

}
 
void loop()
{
  q++;
  delay(1000);
  if(q == 900) 
  {
    sensor.requestTemperatures();
    temperature = sensor.getTempCByIndex(0);
    
    while(temperature < -100 ){
      delay(1000);
      sensor.requestTemperatures();
      temperature = sensor.getTempCByIndex(0);
    }

    inetapn();
    SendJson();
    q=0;
  }
}

void SendJson()
{
  StaticJsonBuffer<200> jsonBuffer;
  JsonObject& object = jsonBuffer.createObject();
  
  object.set("userid",1);
  object.set("id",deviceID);
  object.set("temp",temperature);
  
  object.printTo(Serial);
  Serial.println(" ");  
  String sendtoserver;
  object.prettyPrintTo(sendtoserver);
  delay(4000);
 
  myserial.println("AT+HTTPPARA=\"URL\",\"http://www.temprail.uz/api/temppch\""); //Server address
  delay(4000);
  ShowSerialData();
 
  myserial.println("AT+HTTPPARA=\"CONTENT\",\"application/json\"");
  delay(4000);
  ShowSerialData();
 
 
  myserial.println("AT+HTTPDATA=" + String(sendtoserver.length()) + ",100000");
  Serial.println(sendtoserver);
  delay(6000);
  ShowSerialData();
 
  myserial.println(sendtoserver);
  delay(6000);
  ShowSerialData;
 
  myserial.println("AT+HTTPACTION=1");
  delay(6000);
  ShowSerialData();

  myserial.println("AT+HTTPREAD");
  delay(6000);
  ShowSerialData();
  
  myserial.println("AT+HTTPTERM");
  delay(10000);
  ShowSerialData;
 
}
 void inetapn()
 {
  if (myserial.available())
  Serial.write(myserial.read());
 
  myserial.println("AT");
  delay(3000);
 
  myserial.println("AT+SAPBR=3,1,\"Contype\",\"GPRS\"");
  delay(6000);
  ShowSerialData();
 
  myserial.println("AT+SAPBR=3,1,\"APN\",\"internet.uzmobile.uz\"");//APN
  delay(6000);
  ShowSerialData();
 
  myserial.println("AT+SAPBR=1,1");
  delay(6000);
  ShowSerialData();
 
  myserial.println("AT+SAPBR=2,1");
  delay(6000);
  ShowSerialData();
 
 
  myserial.println("AT+HTTPINIT");
  delay(6000);
  ShowSerialData();
 
  myserial.println("AT+HTTPPARA=\"CID\",1");
  delay(6000);
  ShowSerialData();
 }
 
void ShowSerialData()
{
  while (myserial.available() != 0)
    Serial.write(myserial.read());
  delay(1000);
 
}