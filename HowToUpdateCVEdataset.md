
#remove the old ones 
rm Resources/allCVEs2022.csv 
rm Resources/files_exploits.csv

#run this on linux (you can even rename this file to .sh i think) 
#it gets the new dataset and replaces the old one, let the download finish tho - you dont want half the dataset
#or a corrupt one
wget https://cve.mitre.org/data/downloads/allitems.csv -O allCVEs2022.csv

#Windows : Invoke-WebRequest -Uri "https://cve.mitre.org/data/downloads/allitems.csv" -OutFile "allCVEs2022.csv"
#i didnt test this windows command but it should work fine (the only thing that might be odd is the Outfile directory
#Like I'd go: ./allCVEs2022.csv but i think this should work fine if the script /command is ran from the folder

wget https://raw.githubusercontent.com/offensive-security/exploitdb/master/files_exploits.csv files_exploits.csv

#Windows Invoke-WebRequest -Uri "https://raw.githubusercontent.com/offensive-security/exploitdb/master/files_exploits.csv" -OutFile "files_exploits.csv"

#move the new ones to Resources/ folder
mv allCVEs2022.csv Resources/
mv files_exploits.csv Resources/

#that should be fine

