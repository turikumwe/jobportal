@echo off
@setlocal
set CODECEPT_PATH=_protected/vendor/bin/
"%CODECEPT_PATH%codecept.bat" %*
@endlocal