#!/usr/bin/env python
# -*- coding: utf-8 -*-

import DatabaseManager
import os
from os import walk
from datetime import date

_currentDb = "Pi_YourFlix_Data"
_showsTable = "YourFlix_ShowInfo"
_videosTable = "YourFlix_VideoInfo"
_seasonsTable = "YourFlix_ShowSeasons"

_videosDir = "/home/pi/Videos/"
_root = "/home/pi/"

_user = "pi"
_password = "raspberry"

_dateStamp = date.today().strftime("%Y-%m-%d %H:%M:%S")

def GetFoldersInDir(self, currDir):
	dirList = []
	for(dirPath, dirNames, fileNames) in walk(self._videosDir + currDir):
		dirList.append(dirPath)
	return dirList

def GetFilesInDir(currDir):
	filesList = []
	for(dirPath, dirNames, fileNames) in walk(currDir):
		return(fileNames)

def GetCurrentFileStruct(self):
	currentFolders = GetFoldersInDir(self, '')

	currentFiles = []

	for x in currentFolders:
		files = GetFilesInDir(x)
		for y in files:
			if x.endswith('/'):
				currentFiles.append(x+y)
			else:
				currentFiles.append(x+"/"+y)
	return currentFiles

def GetShowId(self, db, currShow, showType, listOfAllItems, dbShows):
    for x in dbShows:
        if x[2] == currShow:
            return x[0]
    
    imageLoc = ""
    
    for img in listOfAllItems:
        if (not img.endswith(".mp4")) and (currShow+"." in img) and ("DIR" in img):
            imageLoc = img.split(self._root)[1]
            
    db.InsertIntoDb(db, [showType, currShow, imageLoc, self._dateStamp],["ShowType","ShowFolderName","ShowImg","LastUpdated"], self._currentDb, self._showsTable)
    showId =  db.SearchDb(db, "ShowId", self._currentDb, self._showsTable, "ShowFolderName", currShow)
    return showId[0][0]

def UpdateYourFlix(self, db, listOfNewShows, listOfAllItems):
    currShow = ""
    currShowId = -1
    dbSeasons = None
    dbShows = db.GetAllTableData(db, "*", self._currentDb, self._showsTable)
    season = "NULL"
    seasonId = "NULL"
    
    addedShow = 0

    for x in listOfNewShows:
        if x.endswith(".mp4"):
            showInfo = x.split(self._videosDir)[1].split('/')
            videoName = showInfo[len(showInfo)-1].split(".mp4")[0]

            if showInfo[0] != currShow:
                showType = "MOV"
                season = "NULL"
                seasonId = "NULL"
                if len(showInfo) > 2:
                    showType = "SHO"
                    dbSeasons = db.GetAllTableData(db, "*", self._currentDb, self._seasonsTable)
                currShow = showInfo[0]
                currShowId = GetShowId(self, db, currShow, showType, listOfAllItems, dbShows)
                
                db.UpdateDb(db, "ShowId", currShowId, [self._dateStamp], ["LastUpdated"], self._currentDb, self._showsTable)

            if len(showInfo) > 2 and not seasonId == (currShow+" "+showInfo[1]):
                season = showInfo[1]
                seasonId = currShow + " " + showInfo[1]
                if not season in dbSeasons:
                    db.InsertIntoDb(db, [currShowId, season, seasonId, self._dateStamp], ["ShowId", "SeasonFolderName","SeasonId", "LastUpdated"], self._currentDb, self._seasonsTable)
                
                db.UpdateDb(db, "SeasonID", seasonId, [self._dateStamp], ["LastUpdated"], self._currentDb, self._seasonsTable)

            db.InsertIntoDb(db, [x.split(self._root)[1], videoName, currShowId, seasonId, self._dateStamp], ["VideoLoc", "FileName", "ShowId",  "SeasonId", "DateAdded"] ,self._currentDb, self._videosTable)
            addedShow += 1
            
    return addedShow

def CleanUpDb(self, db):
    dbSeasons = db.GetAllTableData(db, "*", self._currentDb, self._seasonsTable)
    dbVideos = db.GetAllTableData(db, "*", self._currentDb, self._videosTable)
    dbShows = db.GetAllTableData(db, "*", self._currentDb, self._showsTable)
    
    updated = False

    for show in dbShows:
        if not any(show[0] in video for video in dbVideos):
            db.RemoveFromDb(db, show[0], "ShowId", self._currentDb, self._seasonsTable)
            db.RemoveFromDb(db, show[0], "ShowId", self._currentDb, self._showsTable)
            updated = True

    for season in dbSeasons:
        if not any(season[2] in video for video in dbVideos):
            db.RemoveFromDb(db, season[2], "SeasonId", self._currentDb, self._seasonsTable)
            updated = True
    
    return updated

def VarifyDbData(self, db):
    updatedDatabase = False
    actualData = GetCurrentFileStruct(self)
    actualData.sort()
    sendData = actualData

    dbFiles = db.GetAllTableData(db, "*", self._currentDb, self._videosTable)

    numOfNewShows = 0

    for x in dbFiles:
        id = str(x[0])
        file = str(x[1])
        if _root+file in actualData:
            sendData.remove(_root+file)
        else:
            db.RemoveFromDb(db, file, "VideoLoc", self._currentDb, self._videosTable)
            updatedDatabase = True

    if not updatedDatabase:
        updatedDatabase = len(sendData) > 0

    if updatedDatabase:
        numOfNewShows = UpdateYourFlix(self, db, sendData, actualData)

    return numOfNewShows


def CheckDatabase(self):

    db = DatabaseManager
    db.ConnectToDb(db, self._user, self._password)

    addedToDb = VarifyDbData(self, db)
    
    restartServer = False
    
    if(addedToDb > 0):
        db.CommitChangesToDb(db)
        restartServer = True

    removedFromDb = CleanUpDb(self, db)
    if(removedFromDb):
        db.CommitChangesToDb(db)
        restartServer = True
        
    if(restartServer):
        os.system("sudo minidlnad -R")
        os.system("sudo service minidlna restart")

    returnString = "Updating Database. Added Shows: "+ str(addedToDb) + " Removed Show: " + str(removedFromDb)

    db.DisconnectDb(db)
    
    return returnString