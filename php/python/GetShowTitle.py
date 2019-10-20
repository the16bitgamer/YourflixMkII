from imdb import IMDb
import DatabaseManager
from datetime import date

_currentDb = "Pi_YourFlix_Data"
_showsTable = "YourFlix_ShowInfo"

_dateStamp = date.today().strftime("%Y-%m-%d %H:%M:%S")


def UpdateShowTitles(self, db):
    movieDb = IMDb()
    showsData = db.SearchNullDb(db, "*", _currentDb, _showsTable, "ShowName")
    
    list = ""
    
    for currShow in showsData:
        showId = currShow[0]
        showType = currShow[1]
        showFolder = currShow[2]

        search = showFolder

        movies = movieDb.search_movie(search)
        if(len(movies) == 0):
            print (showFolder)
        else:
            if(ShowCompare(showFolder, movies[0].get('title'))):
                list += showFolder + "\n" +movies[0].get('title')+"\n\n"
    return list
    
    
def ShowCompare(original, newString):
    strOne = ProcessString(original)
    strTwo = ProcessString(newString)
    
    correct = CompareStrings(strOne, strTwo)
    correct = max(CompareStrings(strTwo, strOne), correct)    
    
    maxNum = max(len(strOne),len(strTwo))
    
    if((correct/maxNum) > 0.7):
        return True
        
    return False

def ProcessString(strIn):

    filterStr = [',', '<', '.', '>', '/', '?', ':', ';', '"', '\'', '[', '{', ']', '}', '|', '\\', '!', '@', '#', '$', '^', '&', '*', '(', ')', '_', '+', '-', '=', "and", "the" , ' ']
    ans = strIn.lower()
    
    for x in filterStr:
        ans.replace(x,"")
    return ans

def CompareStrings(original, newString):
    minLen = min(len(original), len(newString))
    
    if(original == newString):
        return minLen
    if(minLen == 0):
        return 0
    
    correct = 0
    recievedCorrect = 0
    originalPos = 0
    for x in range(minLen):
        if((original[originalPos] != newString[x])):
            correct += 0
        else:
            originalPos += 1
            correct += 1
    correct = max(correct, recievedCorrect)
    
    return correct