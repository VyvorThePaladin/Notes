voluser:volatility

+ volatility -f cridex.vmem imageinfo
+ volatility -f cridex.vmem --profile=WinXPSP2x86 pslist
+ volatility -f cridex.vmem --profile=WinXPSP2x86 netscan
+ volatility -f cridex.vmem --profile=WinXPSP2x86 psxview
+ volatility -f cridex.vmem --profile=WinXPSP2x86 ldrmodules
+ volatility -f cridex.vmem --profile=WinXPSP2x86 apihooks
+ volatility -f cridex.vmem --profile=WinXPSP2x86 malfind -D .
+ volatility -f cridex.vmem --profile=WinXPSP2x86 dlllist
+ volatility -f cridex.vmem --profile=WinXPSP2x86 --pid=584 dlldump -D .

