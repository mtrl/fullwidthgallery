#!/bin/bash
rsync -avz httpdocs/photos/ mark@mtrl.co.uk:/var/www/vhosts/rosemary.mtrl.co.uk/httpdocs/photos/ --exclude=1200 --exclude=200 --progress