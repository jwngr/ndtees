rm *.bad *.log *~ -f

rm -rf databaseDumps/
mkdir databaseDumps

mysql --user=root --password=$rootPassword ndtees -B -e "select * from Shirt;" | sed 's/\t/,/g;s/^//;s/$//;s/\n//g' > databaseDumps/shirt.csv
mysql --user=root --password=$rootPassword ndtees -B -e "select * from Client;" | sed 's/\t/,/g;s/^//;s/$//;s/\n//g' > databaseDumps/client.csv
mysql --user=root --password=$rootPassword ndtees -B -e "select * from Purchase;" | sed 's/\t/,/g;s/^//;s/$//;s/\n//g' > databaseDumps/purchase.csv

echo "Success: database rebuilt"
