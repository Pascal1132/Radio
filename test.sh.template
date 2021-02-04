#!/bin/sh
sudo rtl_fm -M wbfm -f $1M -r 48000 -p 48 -g 49.6 | lame -r -s 48.0 -m m - - | ezstream -c /home/pi/ezstream/testp.xml

