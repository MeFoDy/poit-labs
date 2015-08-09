SetActiveLib -work
comp -include "$dsn\src\task2\RS_Latch_param.vhd" 
comp -include "$dsn\src\test.vhd" 
asim +access +r TESTBENCH_FOR_rslatch 
wave 
wave -noreg S
wave -noreg R
wave -noreg Q
wave -noreg nQ
# The following lines can be used for timing simulation
# acom <backannotated_vhdl_file_name>
# comp -include "$dsn\src\TestBench\rslatch_TB_tim_cfg.vhd" 
# asim +access +r TIMING_FOR_rslatch 