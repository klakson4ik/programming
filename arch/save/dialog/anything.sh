#!/bin/bash
tempfile=`mktemp 2>/dev/null` ||
tempfile=/temp/test$$
trap "rm -f $tempfile" 0 1 2 5 15

env=""
project=""

function newWorkSpace {
	sed -i "53c\cd $HOME/containers/workspace/$env" $HOME/.xinitrc 
}

function anything {
	dialog 	--clear --title "anything" \
		--menu "choice:" 20 51 4 \
		"1" "containers edit" \
		"2" "web2text" \
		"3" "testcontainer" \
		"4" "webdriver" 2>$tempfile
	retval=$?
	choice=`cat $tempfile`

	case $choice in
		1)
		env=wcontainersedit
		;;
		2)
		env=web2text
		;;
		3)
		env=wtestcontainer
		;;
		4)
		env=webdriver
		;;
	esac
}

anything
newWorkSpace

startx

