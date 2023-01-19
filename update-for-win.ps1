
#UPDATE SCRIPT FOR POWERSHELL (run powershell, run "powershell -ep bypass", run the script)
#script by skiddie0057
#remove the old ones 
rm Resources/allCVEs2022.csv 
rm Resources/files_exploits.csv
rm Resources/known_exploited_vulnerabilities.csv

echo "[-] Removed the old files"

wget https://cve.mitre.org/data/downloads/allitems.csv -O allCVEs2022.csv

wget https://gitlab.com/exploit-database/exploitdb/-/raw/main/files_exploits.csv?inline=false -O files_exploits.csv

wget https://www.cisa.gov/sites/default/files/csv/known_exploited_vulnerabilities.csv -O known_exploited_vulnerabilities.csv

echo "[+] Downloaded the new files"

#move the new ones to Resources/ folder
mv allCVEs2022.csv Resources/
mv files_exploits.csv Resources/
mv known_exploited_vulnerabilities.csv Resources/

#that should be fine
echo "[!] New files replaced to the folder. Done. You may exit"
