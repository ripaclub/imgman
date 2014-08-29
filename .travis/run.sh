#!/bin/bash

SCRIPT=$(readlink -f "$0")
CWD=$(dirname "$SCRIPT")

sudo mkdir -p $CWD/../tests/ImgManTest/Storage/Adapter/FileSystem/Resolver/test2
sudo chmod -R 555 $CWD/../tests/ImgManTest/Storage/Adapter/FileSystem/Resolver/test2