@echo off
set curdir=%CD%
cd "%curdir%\MyGames"
FOR /F "eol=; tokens=1* delims=." %%a IN ('dir /b "%curdir%\Downloads\*.zip"') DO (
	echo Unpack %%a
	"%curdir%\tools\unzip.exe" -o -qq "%curdir%\Downloads\%%a.zip"
)
cd..
call ResetGamesPath.bat