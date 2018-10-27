var wshShell = new ActiveXObject("WScript.Shell");
wshShell.Run('Powershell.exe -ExecutionPolicy Bypass -File "E:\\php\\household-tasks\\jobs\\check-tasks.ps1"', 0, false);