# NeonEx - WORK IN PROGRESS
A platform for CMS version detection, exploit suggestion and CVE display based on vulnerability.

# Installation
> You NEED to have your CSV datasets 
> For this you can use Updater.sh 

# Dependencies 
- If you got both the .csv files using the updater or similar commands you are set to go!

# Aggressiveness
This scanner DOES NOT scan for ports, it DOES NOT dirbust/dirb/ , it DOES NOT attempt injections - it is a passive scanner (it only sends few requests to your website, so far max i've seen is 10, usually its around 5-6) and therefore it is safer and easier on the website load. 

# Scripts used
CMS detection script is from https://github.com/Krisseck/Detect-CMS
0daytoday from unofficial API (i think this one https://github.com/MrSentex/0day.today-API)
Exploitdb from https://github.com/offensive-security/exploitdb

# Next versions
Better and wider detections.
