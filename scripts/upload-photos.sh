#!/bin/bash
rsync -avz httpdocs/photos/ mark@mtrl.co.uk:/var/www/vhosts/rosemary.mtrl.co.uk/httpdocs/photos/ --exclude=200 --exclude=225 --progress
