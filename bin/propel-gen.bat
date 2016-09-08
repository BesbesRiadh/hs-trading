@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/propel/propel1/generator/bin/propel-gen
bash "%BIN_TARGET%" %*
