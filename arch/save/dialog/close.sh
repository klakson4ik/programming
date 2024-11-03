#!/bin/bash
tempfile=`mktemp 2>/dev/null` ||
tempfile=/temp/test$$
trap "rm -f $tempfile" 0 1 2 5 15
dir=$HOME/containers/dialog

function main {
	dialog 	--clear --title "workspace" \
		--menu "choice:" 20 51 4 \
       		"1" "poweroff" \
		"2" "reboot" \
		"3" "console" 2>$tempfile
	retval=$?
	choice=`cat $tempfile`

	[ -f .docker-compose.yml ] && docker-compose down
	case $choice in
		1)
		doas poweroff
		;;
		2)
		doas reboot
		;;
		3)
		[ -f .docker-compose.yml ] && exit
		clear
		;;
	esac

}

main
