import os
import json
import socket
import threading
import pygame

dirName = os.path.dirname(os.path.abspath(__file__))

class PlayerModel:
	def __init__(self):
		self.queue = []
		self.currentlyPlaying = ""
	def pop(self):
		self.currentlyPlaying = self.queue.pop()

pygame.mixer.init()
model = PlayerModel()

def playQueue():
	print("Jukebox thread started...")
	while(True):
		if(len(model.queue) > 0):
			model.pop()
			try:
				pygame.mixer.music.load(dirName + '\\music\\' + model.currentlyPlaying)
				pygame.mixer.music.play()
				while(pygame.mixer.music.get_busy()):
					continue

			except pygame.error:
				print("Error loading file")

def socketListener():
	print("Network thread started...")
	s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
	s.bind(("localhost",15000))
	s.listen(1)
	while(True):
		connection, sender = s.accept()
		try:
			data = connection.recv(128)
			print(sender)
			print(data)
			if data:
				connection.sendall(
					bytes(
						json.dumps([model.currentlyPlaying, list(reversed(model.queue))]), 
						'utf8'))
		finally:
			connection.close()

socketThread = threading.Thread(target = socketListener)

playerThread = threading.Thread(target = playQueue)

socketThread.daemon = True
playerThread.daemon = True

playerThread.start()
socketThread.start()
print("Ready")

while(True):
	x = input()
	if(x=="break"):
		break 
	if(x=="queue"):
		print(list(reversed(model.queue)))
	if(x=="playing"):
		print(model.currentlyPlaying)
	if(x=="library"):
		print(os.listdir(dirName + "\\music"))
	if(x.startswith("add")):
		model.queue.insert(0, x[4:])
