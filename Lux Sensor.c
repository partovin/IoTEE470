//---------------------------------------------
// Title: Lux Detector with LED
//---------------------------------------------
//Program Detail: Read the Lux Measurement and also activate a buzzer and LED
//---------------------------------------------
//Purpose: Read Lux and give feedback
// Inputs: Light
// Outputs: Lux reading, buzzer, LED
// Date: 9/29/2025 9AM
// Compiler: Visual Studio
// AUthor: Nima Partovi 
// Version:
//      V1; Code uploaded
//---------------------------
// Platform Dependecies: PlatformIO, C/C++


#include <Arduino.h>


#define BUZZER_PIN 14   // D5
#define LED_PIN 12      // D6
#define LIGHT_SENSOR A0 // Analog input


const int threshold = 800;  // Lux threshold (adjust after testing)


unsigned long buzzerStartTime = 0;
const unsigned long buzzerDuration = 5000;  // 5 seconds


bool buzzerManualOn = false;


void setup() {
 pinMode(BUZZER_PIN, OUTPUT);
 pinMode(LED_PIN, OUTPUT);
 digitalWrite(BUZZER_PIN, LOW);
 digitalWrite(LED_PIN, LOW);


 Serial.begin(9600);
 Serial.println("System started. Send 'B' to test buzzer.");
}


void loop() {
 int lightValue = analogRead(LIGHT_SENSOR);


 // Print the current light level
 Serial.print("Light Level: ");
 Serial.println(lightValue);


 // Check for manual buzzer activation from Serial input
 if (Serial.available() > 0) {
   char c = Serial.read();
   if (c == 'B' || c == 'b') {
     buzzerManualOn = true;
     buzzerStartTime = millis();
     digitalWrite(BUZZER_PIN, HIGH);
     Serial.println("Manual buzzer ON for 5 seconds");
   }
 }


 // If manual buzzer is ON, check if 5 seconds passed
 if (buzzerManualOn) {
   if (millis() - buzzerStartTime >= buzzerDuration) {
     buzzerManualOn = false;
     digitalWrite(BUZZER_PIN, LOW);
     Serial.println("Manual buzzer OFF");
   }
 }
 else {
   // Automatic buzzer activation if dark
   if (lightValue > threshold) {
     digitalWrite(BUZZER_PIN, HIGH); // Turn buzzer ON
     digitalWrite(LED_PIN, LOW);     // LED OFF when buzzer is on
   } else {
     digitalWrite(BUZZER_PIN, LOW);  // Turn buzzer OFF
     digitalWrite(LED_PIN, HIGH);    // LED ON when light >= threshold
   }
 }


 delay(1000); // Delay 1 second before next reading
}
