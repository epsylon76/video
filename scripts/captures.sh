#!/bin/bash
#Fichiers passés en arguments
VIDEO=$1
CADENCE=$2
DEST=$3
KEY=$4 #sinon le Nommage va réécrire par dessus

ffmpeg -i "${VIDEO}"  -qscale:v 2 -vf fps=1/${CADENCE} "${DEST}"Photo_${KEY}_%03d.jpg
