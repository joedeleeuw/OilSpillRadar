#!/usr/bin/env python

# Written by: Jonathan Logan
# Edited by: Nazarelle VanPutte
# Captures data from ADC CH2 for a specified time in seconds from argv[1]

import time
import os
import math
import sys
from decimal import *
import RPi.GPIO as GPIO

getcontext().prec = 4

data = open("data.txt", "w+")
	
a = []

data.write("{ \n \"Data\": [\n")

#GPIO.setmode(GPIO.BCM)
DEBUG = 1

# read SPI data from MCP3008 chip, 8 possible adc's (0 thru 7)
def readadc(adcnum, clockpin, mosipin, misopin, cspin):
        if ((adcnum > 7) or (adcnum < 0)):
                return -1
        GPIO.output(cspin, True)

        GPIO.output(clockpin, False)  # start clock low
        GPIO.output(cspin, False)     # bring CS low

        commandout = adcnum
        commandout |= 0x18  # start bit + single-ended bit
        commandout <<= 3    # we only need to send 5 bits here
        for i in range(5):
                if (commandout & 0x80):
                        GPIO.output(mosipin, True)
                else:
                        GPIO.output(mosipin, False)
                commandout <<= 1
                GPIO.output(clockpin, True)
                GPIO.output(clockpin, False)

        adcout = 0
        # read in one empty bit, one null bit and 10 ADC bits
        for i in range(12):
                GPIO.output(clockpin, True)
                GPIO.output(clockpin, False)
                adcout <<= 1
                if (GPIO.input(misopin)):
                        adcout |= 0x1

        GPIO.output(cspin, True)
        
        adcout >>= 1       # first bit is 'null' so drop it
        return adcout

# change these as desired - they're the pins connected from the
# SPI port on the ADC to the Cobbler
SPICLK = 12
SPIMISO = 16
SPIMOSI = 18
SPICS = 22

# set up the SPI interface pins
GPIO.setup(SPIMOSI, GPIO.OUT)
GPIO.setup(SPIMISO, GPIO.IN)
GPIO.setup(SPICLK, GPIO.OUT)
GPIO.setup(SPICS, GPIO.OUT)

# 10k trim pot connected to adc #0
potentiometer_adc0 = 0;
potentiometer_adc1 = 2;



i = 0;


curTime = int(time.time())	# get the current unix time
timeTill = int(sys.argv[1]) + int(time.time())	# add the seconds to it


# capture the data for T seconds
while curTime < timeTill :

        # we'll assume that the pot didn't move

        # read the analog pin

        trim_pot1 = readadc(potentiometer_adc1, SPICLK, SPIMOSI, SPIMISO, SPICS)

        a.append(trim_pot1)
        i = i + 1
        
        curTime = int(time.time())
        
len = i
      
i = 0  

# convert the data to json and print it to a file.
while i != len :

	value = a[i]
	volt_ref1 = (value*5.00)/1024.00
	final = 2.805518*math.pow(volt_ref1,2)-49.161218*volt_ref1+31.497479

	data.write("\t{\n")
	data.write("\t\t\"Number\": ")
	data.write(str(i))
	data.write(",\n")
	data.write("\t\t\"Value\": ")
	data.write(str(final))
	data.write("\n")
	
	if(i == len-1) :
		data.write("\t}\n")
	else :
		data.write("\t},\n")
		
	i = i + 1


data.write("] \n}")
#print the value

# if everything went ok, print a 1.
print "1"
