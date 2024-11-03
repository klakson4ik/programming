#!/bin/bash
tempfile=`mktemp 2>/dev/null` ||
tempfile=/temp/test$$
trap "rm -f $tempfile" 0 1 2 5 15
dir=$HOME/containers/dialog

function main {
	dialog 	--clear --title "workspace" \
		--menu "choice:" 20 51 4 \
       		"1" "web" \
		"2" "cpp" \
 		"3" "entertainment" \
 		"4" "anuthing" \
		"0" "exit" 2>$tempfile
	retval=$?
	choice=`cat $tempfile`
	[ -f .docker-compose.yml ] && docker-compose down
	case $choice in
		1)
		$dir/web.sh
		;;
		2)
		$dir/cpp.sh
		;;
		3)
		entertianment
		;;
		4)
		$dir/anything.sh
		;;
		0)
		$dir/close.sh
		;;
	esac
}

main
