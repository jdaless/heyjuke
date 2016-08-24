import os
import json
import pygame

dirName = os.path.dirname(os.path.abspath(__file__))

queueFile = open('queue.json', 'r+')

pygame.mixer.init()

while(True):
	queue = json.load(queueFile)
	play = queue.pop()
	queueFile.seek(0)
	queueFile.truncate()
	json.dump(queue, queueFile)
	pygame.mixer.music.load('music\\' + play['path'])
	pygame.mixer.music.play()
	while(pygame.mixer.music.get_busy()):
		continue

