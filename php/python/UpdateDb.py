#!/usr/bin/env python
# -*- coding: utf-8 -*-

import YourflixDbManager
import DatabaseManager

_user = "pi"
_password = "raspberry"

dbManager = YourflixDbManager


db = DatabaseManager
db.ConnectToDb(db, _user, _password)

print(dbManager.CheckDatabase(dbManager, db))

db.DisconnectDb(db)