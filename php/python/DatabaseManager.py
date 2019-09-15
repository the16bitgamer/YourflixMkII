#!/usr/bin/env python
# -*- coding: utf-8 -*-

import MySQLdb

_connectedDb = None
_dbCursor = None

def ConnectToDb(self, userID, userPassword):
	if self._connectedDb is not None:
		DisconnectDb(self)

	self._connectedDb = MySQLdb.connect(host="localhost", user = userID, passwd=userPassword)
	self._dbCursor = self._connectedDb.cursor()
	return "Connected to Database!"

def DisconnectDb(self):
    self._dbCursor.close()
    self._connectedDb.close()

def InsertIntoDb(self, values, location, db, table):
    insertLoc = ""
    for x in location:
        if len(insertLoc) > 0:
            insertLoc += ","
        insertLoc += "`"+str(x)+"`"
    
    value = ""
    for x in values:
        if len(value) > 0:
            value += ","
        value += "\""+str(x)+"\""
    self._dbCursor.execute("INSERT INTO `"+db+"`.`"+table+"` ("+insertLoc+") VALUES (%s);" % value)

def UpdateDb(self, updateCol, updateValue, value, location, db, table):
    set = ""
    for idx, x in enumerate(location):
        if len(set) > 0:
            set += ","
        set += "`"+str(x)+"` = \""+str(value[idx])+"\""
    self._dbCursor.execute("UPDATE `"+db+"`.`"+table+"` SET "+set+" WHERE `"+updateCol+"` = \"%s\";"% updateValue)

def RemoveFromDb(self, value, location,  db, table):
    self._dbCursor.execute("DELETE FROM `"+db+"`.`"+table+"` WHERE (`"+location+"` = \""+str(value)+"\");")

def SearchDb (self, range, db, table, col, search):
    self._dbCursor.execute("SELECT "+range+" FROM `"+db+"`.`"+table+"` WHERE `"+col+"` = \"%s\";" % search)
    return self._dbCursor.fetchall()
    
def GetAllTableData(self, range, db, table):
    self._dbCursor.execute("SELECT "+range+" FROM `"+db+"`.`"+table+"`;")
    return self._dbCursor.fetchall()

def CommitChangesToDb(self):
    self._connectedDb.commit()
