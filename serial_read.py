#!/usr/bin/env python
import time		#used to obtain the time information
import serial		#used to establish serial connection
import mysql.connector	#this is required to interface sql databases
import datetime		#also used for time information
import picamera		#this allows us to interface the camera using python
import os		#used to make directories for file storage
import os.path
from os import path

mydb = mysql.connector.connect(
  host="localhost",
  user="jeremy",
  password="Password01",
  database="birdfeeder"
)

mycursor = mydb.cursor()
y = datetime.datetime.now()

ser = serial.Serial(
        port='/dev/ttyS0',
        baudrate = 2400,
        parity=serial.PARITY_NONE,
        stopbits=serial.STOPBITS_ONE,
        bytesize=serial.EIGHTBITS,
        timeout=1
)

while 1:
        x=ser.readline(1)
        print(x)

	if x == '1':		#if x is 1 we are processing bird activity

		#set absolute pathname of the picture file location
		picdir = "images/" + y.strftime("%Y") + "/" + y.strftime("%m") + "/" + y.strftime("%d")
                picloc = "images/" + y.strftime("%Y") + "/" + y.strftime("%m") + "/" + y.strftime("%d") + "/" + y.strftime("%H") + "-" + y.strftime("%M") + ".jpg"

		#check if the picture directory exists and make it if not
		if (path.exists(picdir)):
			print("Dir already exists")
		else:
			path = picdir
			os.makedirs(path, 0755)
			print("Created path: " + picdir)

		#setup camera so that it will close when we are done with it
		#taking picture from the pi camera
		with picamera.PiCamera() as camera:
			camera.resolution = (1920,1080)
			camera.capture(picloc)
			print("Created file: " + picloc)

		#set the pathname of that image to a variable
		pic = "images/" + y.strftime("%Y") + "/" + y.strftime("%m") + "/" + y.strftime("%d") + "/" + y.strftime("%H") + "-" + y.strftime("%M") + ".jpg"

		sql = ("INSERT INTO birds (Year, Month, Day, Hour, Minute, Picture) VALUES (%s, %s, %s, %s, %s, %s)")
		val = (y.year, y.month, y.day, y.hour, y.minute, pic)
		mycursor.execute(sql, val)

		mydb.commit()

		print("Bird activity noted in database")

	elif x == '2':		#if x is 2 we are reading temperature
		temp=ser.readline(2)
		print("temperature: " + temp)

	elif x == '3':		#if x is 3 we are reading humidity
		hum=ser.readline(2)
		print("humidity: " + hum)

	elif x == '4':		#if x is 4 we are reading reservoir level
		res=ser.readline(2)
                print("reservoir level: " + res)
		sql = ("INSERT INTO climat (Temp, Humid, Res, Year, Month, Day, Hour) VALUES (%s, %s, %s, %s, %s, %s, %s)")
		val = (temp, hum, res, y.year, y.month, y.day, y.hour)
		print("Climat information inserted into database")
