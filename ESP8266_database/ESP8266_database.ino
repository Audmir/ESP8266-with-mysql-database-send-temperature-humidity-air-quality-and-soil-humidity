////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// AUTHOR: AUDREY MIRINDI
// DATE: ?/?/2024
// GUIDER: Amtech-co LLC | Hardware
// WEBSITE: https://amtech-co.com
// SERVICE ID: @am005
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
#include <SimpleDHT.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

const int pinDHT11 = 16; // this is the D0 pin
const int gasSensor = A0; // this is the GAZ Sensor pin
const int soil_humidity_sensor = 14; // this is the soil humidity sensor pin corresponding to the D5

// configure your WIFI or hostspot SSID and password
const char* ssid = "Amtech";  // your WIFI SSID (wifi name)
const char* password = "12345678"; // your WIFI PASSWORD

SimpleDHT11 dht11(pinDHT11);

void setup() {
  Serial.begin(115200);
  pinMode(gasSensor, INPUT);
  pinMode(soil_humidity_sensor, INPUT);
  WiFi.begin(ssid, password); // connect to the hostspot
  Serial.println();
  Serial.println("=============================================================================");
  Serial.print("Connecting to the WIFI");
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println(".");
  }
  // return this if your board is connected to the WIFI or hostpot
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.println("=============================================================================");
  Serial.println('\n');
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {

    byte humidity = 0;
    byte temperature = 0;
    int err = SimpleDHTErrSuccess;

    if ((err = dht11.read(&temperature, &humidity, NULL)) != SimpleDHTErrSuccess) {
      Serial.print("Read DHT11 failed, err="); Serial.print(SimpleDHTErrCode(err));
      Serial.print(","); Serial.println(SimpleDHTErrDuration(err)); delay(1000);
      return;
    }

    // data from sensors
    int air_quality = getVoltage(gasSensor); // Gaz value
    int humidity_val = (int)humidity; // Humidity value
    int temperature_val = (int)temperature; // Temperature value
    int soil_hum = (int) digitalRead(soil_humidity_sensor);

    // http request. replace the present IPV4 adress by your IPV4 of your computer if you operate under localhost.
    // if it's online, just replace this one by your domain. ensure your PHP file is hosted on the same server
    // exemple: "http://amtech-co.com/v_memoire_christian_UCB/sensor-data.php?temperature=" etc...

    String serverName = "http://192.168.43.179/v_memoire_christian_UCB/sensor-data.php?temperature="
                        + String(temperature_val) + "&humidity=" + String(humidity_val) + "&air_quality=" + String(air_quality) + "&soil_humidity=" + String(soil_hum);

    HTTPClient http;
    http.begin(serverName); // send data to the server
    int httpResponseCode = http.GET(); // get the code response
    if (httpResponseCode > 0) {
      String response = http.getString(); // get the returned message
      Serial.println(httpResponseCode); // print the code response
      Serial.println(response); // print the returned message from the PHP file
      // this code below allows you to visualize your data in the serial monitor
      Serial.print('\n');
      Serial.print("Temperature: ");
      Serial.println((float)temperature);
      Serial.print("Humidity: ");
      Serial.println((float)humidity);
      Serial.print("Air Quality: ");
      Serial.println((float)air_quality);
      Serial.println("__________________________________________________________________________");
    } else {
      // return this if there is an error
      Serial.println(httpResponseCode);
      Serial.println("Error on HTTP request");
      Serial.println("__________________________________________________________________________");
    }
    http.end(); // end the request to send it again or to release the port for the next request
  }
  delay(5000); // Send data every 5 seconds
}
// calculation of gaz values according to a given value
float getVoltage(int pin) {
  return (analogRead(pin) * 0.006882814);
  // This equation converts the 0 to 1023 value that analogRead()
  // returns, into a 0.0 to 5.0 value that is the true voltage
  // being read at that pin.
  // 0.004882814 a division variable that changes the calculation of 0 to 1023 to give the exact values.
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
