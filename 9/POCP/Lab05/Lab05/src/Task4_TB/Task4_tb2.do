#  File: 'E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task4_TB\Task4_tb2.do'
#  created: 10/18/14 16:15:19
#  from: 'E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task4.asf'
#  by ASFTEST - v.2.1.3 build 56, August 25, 2005

#
# rebuild the project
#
comp "E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task4.asf"
comp "E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task4_TB\Task4_tb2.vhd"

#
# set top-level and initialize the simulator with Code Coverage Data
#
asim -cc -cc_dest $DSN/coverage/Task4_cc_tb2 -cc_hierarchy -cc_all Task4_cfg_tb2

#
# invoke Waveform Viewer window, add signals to Waveform
#
wave
wave -noreg -dec cycle_num
wave -noreg CLK
wave -noreg UUT/NextState_state
wave -noreg UUT/state
wave -noreg test_state
wave -noreg RST
wave -noreg IP
wave -noreg OP

#
#
#
run -all
endsim
write wave "E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task4_TB\Task4_tb2.awf"
#close -wave
