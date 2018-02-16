if [[ $1 == 1 || $1 == 2 ]]; then
    let answer=$1 
else
    echo -n "Do you want to (1) replace all tabs with four spaces or (2) replace all four spaces with tabs? (1 or 2) "
    read answer
    echo
    echo "Modified files:"
fi

if [[ "$answer" == "1" || "$answer" == "2" ]]; then
    for file in $(find WEBDEPLOY/)
    do
        if [ -f "$file" ]; then
            if [[ $file == *.html || $file == *.php || $file == *.txt || $file == *.css || $file == *.js ]]; then
                echo $file
                if [ "$answer" == "1" ]; then
                    sed -i 's/	/    /g' $file
                elif [ "$answer" == "2" ]; then
                    echo $file
                    sed -i 's/    /	/g' $file
                fi
            fi
        fi
    done
else
    echo "[None]"
fi
