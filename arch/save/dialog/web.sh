#!/bin/bash
tempfile=`mktemp 2>/dev/null` ||
tempfile=/temp/test$$
trap "rm -f $tempfile" 0 1 2 5 15

env=wWeb
project=""

function newWorkSpace {
	sed -i "53c\cd $HOME/containers/workspace/$env/$project" $HOME/.xinitrc 
}

function web {
	dialog 	--clear --title "web" \
		--menu "choice:" 20 51 4 \
		"1" "news" 2>$tempfile
	retval=$?
	choice=`cat $tempfile`

	case $choice in
		1)
		project=news
		;;
	esac
}

web
newWorkSpace

startx

