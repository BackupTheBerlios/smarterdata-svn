@echo off
:start
cls
echo   Name of the game
echo ===================================
echo    1 = Name of the game
echo    X = Setup
echo    E = End
echo.
echo.
D:\choice.com -c:1XE
IF ERRORLEVEL 3 GOTO end
IF ERRORLEVEL 2 GOTO setup
IF ERRORLEVEL 1 GOTO game
GOTO start

:setup
cd \game
NameOfTheSetup.Extension
cd\
goto start

:game
cd \game
NameOfTheFile.Extension
cd \
GOTO start

:end
exit