@echo off
title Laravel Server and Scheduler
echo Démarrage de Laravel Serve...
start php artisan serve
echo Démarrage de Laravel Scheduler...
start php artisan schedule:work
pause
