#!/bin/bash

git reset --hard
git pull
composer install
bin/cake migrations migrate
bin/cake cache clear_all
bin/cake plugins assets symlink