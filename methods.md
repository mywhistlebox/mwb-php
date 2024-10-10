# MyWhistleBox Methods

The MyWhistleBox SDK API supports a number of methods to perform various actions on the server account.  These methods are grouped by category.  It may be neccesary to make a number of calls to obtain the required paramters.  For example, listFiles required a folderId.  You can query the folder Id's by calling listBoxes or listFolders as both of those will return a list of folderId's.  More information can be found at http://mywhistlebox.com/developer.

## List Methods

    listBoxes()
    listPages()
    listFolders(parentFolderId)
    listFiles(folderId)
    listMemos(folderId)

## User Methods

    userFileUpload(whistleBoxAddress, fileContents, fileName, subject='', note='', confirmEmail='')
    userMemoUpload(whistleBoxAddress, title, text)
    userfileSend(whistleBoxAddress, array fileIds, confirmEmail='', note='')

## Folder Methods

    folderUpload(folderId, filePath)
    folder(parentFolderId, name)

## File Methods

    fileInfo(fileId)
    fileDownload(fileId, downloadDirectory)

## Memo Methods

    memoAdd(folderId, title, text)
    memo(memoId)

## Request Methods

    requestUpload(boxId, email, expireDays='3', note='')
    requestWhistlepage(pageId, email, expireDays='3', note='')
    requestSignature(array fileIds, email, accessType, accessCode='', expireDays=3, note='')
    requestDownload(array fileIds, email, accessType, accessCode='', expireDays=3, note='')

**Note:** accessType can be any of the following constants: 
* MwbClient::accessNone
* MwbClient::accessZIP5
* MwbClient::accessSSN4
* MwbClient::accessSSN5
* MwbClient::accessPHONE4
* MwbClient::accessCustom

## Report Methods

    reportLogUpload(startDate, endDate, limit=5000, startAt=0)
    reportLogWhistlepage(startDate, endDate, limit=5000, startAt=0)
    reportLogDownload(startDate, endDate, limit=5000, startAt=0)
    reportLogSignature(startDate, endDate, limit=5000, startAt=0)
    reportLogSender(startDate, endDate, limit=5000, startAt=0)
    reportLogAudit(startDate, endDate, limit=5000, startAt=0)

## Test Methods

    ping()
