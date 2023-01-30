# NeonEx - V1
A platform for CMS version detection, exploit suggestion and CVE display based on vulnerability.

# Installation
- You NEED to have your CSV datasets 
- For this you can use Updater.sh OR read it out manually, just extract LINKS and download datasets 
- USE PHP 8 FOR THIS (and xampp accordingly)
- IMPORTANT NOTE TO WINDOWS USERS : use windows detectcms script for windows and linux for linux 
*(explaination: delete the DetectCMS.php if you are on windows, rename DetectCMSwindows.php to DetectCMS.php - and you are set to go ;; If you are on linux, just leave it all as it is -you dont need to remove DetectCMSwindows.php)*

# Dependencies 
- If you got all 3 of the .csv files in Resources folder using the updater or similar commands you are set to go! 
- Refer to "Datasets used" part of this README for a list of files.

# Aggressiveness
This scanner DOES NOT scan for ports, it DOES NOT dirbust/dirb/ , it DOES NOT attempt injections - it is a passive scanner (it only sends few requests to your website, so far max i've seen is 10, usually its around 5-6) and therefore it is safer and easier on the website load. 

# Scripts used
CMS detection script is from https://github.com/Krisseck/Detect-CMS
0daytoday from unofficial API (i think this one https://github.com/MrSentex/0day.today-API)
Exploitdb from https://github.com/offensive-security/exploitdb

# Datasets used
Should be found In the /Resources folder:

- allCVEs2022.csv
- files_exploits.csv
- known_exploited_vulnerabilities.csv

# Next versions
Better and wider detections of versions and fixes for vulns.
