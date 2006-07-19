@echo off
:start
cls
echo   Name of the game
echo ===================================
echo    1 = Name of the game
echo    E = End
echo.
echo.
D:\choice.com -c:1E
IF ERRORLEVEL 2 GOTO end
IF ERRORLEVEL 1 GOTO game
GOTO start

:game
cd \game
NameOfTheFile.Extension
cd \
GOTO start

:end
exit