@echo off
:start
cls
echo   1000 Miglia
echo ===================================
echo 0= Play
														echo Z= EXIT
D:\choice.com -c:0Z
IF ERRORLEVEL 2 GOTO EXIT
IF ERRORLEVEL 1 GOTO GAME_0
														
goto start
:GAME_0
														cd game
														call RUNME.BAT
														goto start
														:EXIT
exit
