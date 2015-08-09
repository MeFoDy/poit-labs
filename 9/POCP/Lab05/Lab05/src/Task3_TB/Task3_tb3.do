#  File: 'E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task3_TB\Task3_tb3.do'
#  created: 10/18/14 16:08:55
#  from: 'E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task3.asf'
#  by ASFTEST - v.2.1.3 build 56, August 25, 2005

#
# rebuild the project
#
comp "E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task3.asf"
comp "E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task3_TB\Task3_tb3.vhd"

#
# set top-level and initialize the simulator with Code Coverage Data
#
asim -cc -cc_dest $DSN/coverage/Task3_cc_tb3 -cc_hierarchy -cc_all Task3_cfg_tb3

#
# invoke Waveform Viewer window, add signals to Waveform
#
wave
wave -noreg -dec cycle_num
wave -noreg CLK
wave -noreg UUT/NextState_Sreg0
wave -noreg UUT/Sreg0
wave -noreg test_Sreg0
wave -noreg RST
wave -noreg IP
wave -noreg OP

#
#
#
run -all
endsim
write wave "E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task3_TB\Task3_tb3.awf"
#close -wave
