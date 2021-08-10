#!/usr/bin/env bash
#Inject important files into the anax system.

rsync -av vendor/lortus64/weather-module/src ./
rsync -av vendor/lortus64/weather-module/view ./
rsync -av vendor/lortus64/weather-module/config ./
