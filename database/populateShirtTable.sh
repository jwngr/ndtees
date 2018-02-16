echo -n "Are you sure you want to drop the rows in the current shirt table and re-populate it? (yes/no) "
read answer

if [ "$answer" == "yes" ]; then
	mysql --user=root --password=$rootPassword ndtees < populateShirtTable.sql
	echo "Success: shirt table repopulated"
else
    echo "Nothing changed"
	exit
fi
