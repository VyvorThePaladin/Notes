#!/bin/sh

initial="nmap -sS -sC -sV -A -O -oN nmap/initial.nmap $2"
all_vuln="nmap --script vuln -oN nmap/all_vuln.nmap $2"
all_port="nmap -p- -A -oN nmap/all_port.nmap $2"

if [ ! -d "./nmap" ]; then
    mkdir nmap
fi

if [ $# -eq 0 ]; then
    echo "Missing options and IP!"
    echo "(run $0 -h for help)"
    echo ""
    exit 0
fi

while getopts "ivph" OPTION; do
    case $OPTION in

        i)
            $initial
            ;;

        v)
            $all_vuln
            ;;
        p)
            $all_port
            ;;

        h)
            echo "Usage:"
            echo "$0 [OPTION] [IP]"
            echo "  -i  Initial comprehensive scan"
            echo "  -v  Run all vuln scripts"
            echo "  -p  Scan all ports"
            echo "  -h  help (this output)"
            exit 0
            ;;

    esac
done