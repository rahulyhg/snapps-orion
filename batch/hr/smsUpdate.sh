#!/bin/sh 

LOGDIR="log" 

NOW="$(date +"%Y%m%d-%H%M")"
LOGPATH=${LOGDIR}/smsUpdate.log

/opt/php/bin/php smsUpdate.php | tee -a ${LOGPATH}

