# Database Listing System

# Release Note

## 2020/August/26
### New Feature - Expiring Checking
```
databaseList/admin/manageAuth.html
databaseList/admin/manageCommonlyDatabase.html
databaseList/admin/manageExpiryResource.html
databaseList/admin/manageLatestNews.html
databaseList/admin/manageResource.html
databaseList/admin/manageSetting.html
databaseList/admin/manageSubject.html
databaseList/admin/usageReport.html
databaseList/lib/css/admin_index.css
databaseList/lib/css/admin_index.css.map
databaseList/lib/css/allLatestNews.css
databaseList/lib/css/allLatestNews.css.map
databaseList/lib/css/authLogin.css
databaseList/lib/css/authLogin.css.map
databaseList/lib/css/header.scss
databaseList/lib/css/index.css
databaseList/lib/css/index.css.map
databaseList/lib/css/index_ie.css
databaseList/lib/css/index_ie.css.map
databaseList/lib/css/init.css
databaseList/lib/css/init.css.map
databaseList/lib/css/init.scss
databaseList/lib/css/landing.css
databaseList/lib/css/landing.css.map
databaseList/lib/css/landing_select_result.css
databaseList/lib/css/landing_select_result.css.map
databaseList/lib/css/manageAuth.css
databaseList/lib/css/manageAuth.css.map
databaseList/lib/css/manageCommonlyDatabase.css
databaseList/lib/css/manageCommonlyDatabase.css.map
databaseList/lib/css/manageExpiryResource.css
databaseList/lib/css/manageExpiryResource.css.map
databaseList/lib/css/manageExpiryResource.scss
databaseList/lib/css/manageLatestNews.css
databaseList/lib/css/manageLatestNews.css.map
databaseList/lib/css/manageLatestNews.scss
databaseList/lib/css/manageResource.css
databaseList/lib/css/manageResource.css.map
databaseList/lib/css/manageSettings.css
databaseList/lib/css/manageSettings.css.map
databaseList/lib/css/manageSettings.scss
databaseList/lib/css/manageSubject.css
databaseList/lib/css/manageSubject.css.map
databaseList/lib/css/usageReport.css
databaseList/lib/css/usageReport.css.map
databaseList/lib/css/usageReport.scss
databaseList/features/checkDatabaseExpiry.php
databaseList/features/getExpiryResourceSetting.php
databaseList/features/processCheckExpirySettings.php
databaseList/lang/lang.js
databaseList/index.php
databaseList/data/expiryCheckSetting.json
databaseList/lib/js/header_back.js
```

## 2020/August/18
### Change the JSON structure of commonly resouce
```
databaseList/data/commonlyResource.json
databaseList/admin/manageCommonlyDatabase.html
databaseList/admin/manageSetting.html
databaseList/lib/css/index.css
databaseList/lib/css/index.css.map
databaseList/lib/css/index.scss
databaseList/lib/css/manageCommonlyDatabase.css
databaseList/lib/css/manageCommonlyDatabase.css.map
databaseList/lib/css/manageCommonlyDatabase.scss
databaseList/lib/css/manageSettings.css
databaseList/lib/css/manageSettings.css.map
databaseList/lib/css/manageSettings.scss
databaseList/features/processCommonlyResource.php
databaseList/index.php
databaseList/lang/lang.js
databaseList/img/frontstage_background.jpg
```

## 2020/August/17
### New Feature - Commonly Resource management
```
databaseList/admin/manageCommonlyDatabase.html
databaseList/data/header_back.json
databaseList/features/processCommonlyResource.php
databaseList/lang/lang.js
databaseList/lib/css/manageCommonlyDatabase.css
databaseList/lib/css/manageCommonlyDatabase.css.map
databaseList/lib/css/manageCommonlyDatabase.scss
```

## 2020/August/13
### Bug Fix, add commonly resource, adjust style
```
databaseList/admin/manageResource.html
databaseList/admin/manageSetting.html
databaseList/data/commonlyResource.json
databaseList/data/settings.json
databaseList/features/getCommonlyResources.php
databaseList/features/getResourceListOriginal.php
databaseList/index.php
databaseList/lang/lang.js
databaseList/lib/css/index.css
databaseList/lib/css/index.css.map
databaseList/lib/css/index.scss
databaseList/admin/manageLatestNews.html
```

## 2020/August/11
### Integrate stroke, popular database 0 click issue, extract php header
```
	databaseList/admin/manageLatestNews.html
	databaseList/features/fileConverter.php
	databaseList/features/getPopularDatabases.php
	databaseList/index.php

	databaseList/features/_header.php
	databaseList/features/addIdentityInSession.php
	databaseList/features/buildAnchorOfSearchKeyWord.php
	databaseList/features/buildDataStructure.php
	databaseList/features/buildStrokeInResourceList.php
	databaseList/features/checkDatabaseExpiry.php
	databaseList/features/checkSessionForFrontStageUser.php
	databaseList/features/exportDatabases.php
	databaseList/features/fileConverter.php
	databaseList/features/login.php
	databaseList/features/passwordGenerator.php
	databaseList/features/processAccountAndPassword.php
	databaseList/features/processAuth.php
	databaseList/features/processAuthIdentity.php
	databaseList/features/processLatestNews.php
	databaseList/features/processLogReport.php
	databaseList/features/processResource.php
	databaseList/features/processSettings.php
	databaseList/features/processSubject.php
	databaseList/features/verifyUserSession.php
```


## 2020/August/10
### Fix UUID issue, add confirm dialogue for import database list
```
	databaseList/admin/manageSetting.html
	databaseList/features/fileConverter.php
	databaseList/lang/lang.js
	databaseList/lib/css/manageSettings.css
	databaseList/lib/css/manageSettings.css.map
	databaseList/lib/css/manageSettings.scss
```

## 2020/July/10
### Import Database List
```
	databaseList/admin/manageSetting.html
	databaseList/features/buildDataStructure.php
	databaseList/features/exportDatabases.php
	databaseList/features/fileConverter.php
	databaseList/lang/lang.js
	databaseList/lib/css/manageSettings.css
	databaseList/lib/css/manageSettings.css.map
	databaseList/lib/css/manageSettings.scss
```

## 2020/July/09
### Export Database List
```
	databaseList/admin/manageSetting.html
	databaseList/features/exportDatabases.php
	databaseList/lang/lang.js
```

## 2020/July/01
### Add accordion for News Management page
```
	databaseList/admin/manageLatestNews.html
	databaseList/lang/lang.js
	databaseList/lib/css/manageLatestNews.css
	databaseList/lib/css/manageLatestNews.css.map
	databaseList/lib/css/manageLatestNews.scss
```