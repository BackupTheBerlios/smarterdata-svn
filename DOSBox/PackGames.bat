@echo off
set curdir=%CD%
cd "%curdir%\MyGames"
FOR /F "eol=; tokens=1* delims=#" %%a IN ('dir /b /AD "%curdir%\MyGames\"') DO (
	IF EXIST "%curdir%\MyGames\%%a\zzz.bat" (
		IF EXIST "%curdir%\MyGames\%%a\dosbox.conf" (
			IF EXIST "%curdir%\MyGames\%%a\game" (
				echo Pack %%a
				IF EXIST "%curdir%\Downloads\%%a.zip" (
					del "%curdir%\Downloads\%%a.zip"
				)
				"%curdir%\tools\zip.exe" -r -9 -qq "%curdir%\Downloads\%%a.zip" "%%a"
				rmdir /S /Q "%%a"
			)
		)
	)
)
cd..
pause