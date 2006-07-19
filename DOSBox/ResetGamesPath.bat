@echo off
set curdir=%CD%
cd "%curdir%\MyGames"
FOR /F "eol=; tokens=1* delims=#" %%a IN ('dir /b /AD "%curdir%\MyGames"') DO (
	echo Reset %%a
	IF EXIST "%curdir%\MyGames\%%a\dosbox.conf" (
		del "%curdir%\MyGames\%%a\dosbox.conf"
	)
	IF EXIST "%curdir%\MyGames\%%a\dosbox.default.conf" (
		copy "%curdir%\MyGames\%%a\dosbox.default.conf" "%curdir%\MyGames\%%a\dosbox.conf" > NUL
	)
	IF NOT EXIST "%curdir%\MyGames\%%a\dosbox.conf" (
		copy "%curdir%\program\dosbox.conf" "%curdir%\MyGames\%%a\dosbox.conf" > NUL
	)
	echo mount D "%curdir%\program\keyb" >> "%curdir%\MyGames\%%a\dosbox.conf"
	echo D: >> "%curdir%\MyGames\%%a\dosbox.conf"
	echo keyb gr >> "%curdir%\MyGames\%%a\dosbox.conf"
	echo mount C "%curdir%\MyGames\%%a" >> "%curdir%\MyGames\%%a\dosbox.conf"
	echo C: >> "%curdir%\MyGames\%%a\dosbox.conf"
	echo zzz.bat >> "%curdir%\MyGames\%%a\dosbox.conf"
	echo "%curdir%\program\dosbox.exe" -conf "%curdir%\MyGames\%%a\dosbox.conf" > "%curdir%\MyGames\%%a\__START_GAME__.bat"
)
cd..
pause