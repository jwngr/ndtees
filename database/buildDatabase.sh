rm *.bad *.log *~ -f

echo -n "Are you sure you want to dump the old database and rebuild the blank tables? (yes/no) "
read answer

if [ "$answer" == "yes" ]; then
	mysql --user=root --password=$rootPassword ndtees < createAllTables.sql
	echo "Success: database rebuilt"
else
    echo "Nothing changed"
	exit
fi
