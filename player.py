import os
import json
import socket
import threading
import pygame

dirName = os.path.dirname(os.path.abspath(__file__))

queue = []
currentlyPlaying = ''

pygame.mixer.init()


def playQueue():
	while(True):
		if(len(queue) > 0):
			play = queue.pop()
			currentlyPlaying = play
			pygame.mixer.music.load('music\\' + play)
			pygame.mixer.music.play()
			while(pygame.mixer.music.get_busy()):
				continue
		else:
			currentlyPlaying = ''

def socketListener():
	s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
	s.bind(("localhost",15000))
	s.listen(1)
	while(True):
		print("Waiting for a connection...")
		connection, sender = s.accept()
		print(sender)
		try:
			data = connection.recv(128)
			print('received "%s"', data)
			if data:
				print('sending data back to the client')
				connection.sendall(data)
				print('data sent')
            
		finally:
			# Clean up the connection
			connection.close()

socketThread = threading.Thread(target = socketListener)

playerThread = threading.Thread(target = playQueue)

socketThread.daemon = True
playerThread.daemon = True

playerThread.start()
socketThread.start()

while(True):
	x = input()
	if(x=="break"):
		break 
	if(x=="queue"):
		print(queue)
	if(x=="playing"):
		print(currentlyPlaying)
	if(x.startswith("add")):
		queue.append(x[4:])
