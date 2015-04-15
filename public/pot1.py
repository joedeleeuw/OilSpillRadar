#!/usr/bin/env python
import time
import os
import math
from decimal import *
import RPi.GPIO as GPIO

getcontext().prec = 4

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
potentiometer_adc1 = 1;

last_read0 = 0       # this keeps track of the last potentiometer value
last_read1 = 0       # this keeps track of the last potentiometer value
tolerance = 5       # to keep from being jittery we'll only change
                    # volume when the pot has moved more than 5 'counts'
i = 0;

# run it 5 times for calibration
while i < 5 :
        # we'll assume that the pot didn't move
        trim_pot0_changed = False
        trim_pot1_changed = False

        # read the analog pin
        trim_pot0 = readadc(potentiometer_adc0, SPICLK, SPIMOSI, SPIMISO, SPICS)
        trim_pot1 = readadc(potentiometer_adc1, SPICLK, SPIMOSI, SPIMISO, SPICS)
        volt_ref0 = (trim_pot0*4.95)/1023.00
        volt_ref1 = (trim_pot1*4.95)/1023.00
	# how much has it changed since the last read?
        pot_adjust0 = abs(trim_pot0 - last_read0)
        pot_adjust1 = abs(trim_pot1 - last_read1)
        
        if ( pot_adjust0 > tolerance ):
               trim_pot0_changed = True
               
        if ( pot_adjust1 > tolerance ):
               trim_pot1_changed = True
                
                             
        last_read0 = trim_pot0
        last_read1 = trim_pot1
        
        
        time.sleep(0.2)
        
        i = i + 1

#print the value
print volt_ref0