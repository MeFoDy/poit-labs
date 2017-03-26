SetActiveLib -work
comp -include "$dsn\src\task311.vhd" 
comp -include "$dsn\src\TestBench\task311_TB.vhd" 
asim +access +r TESTBENCH_FOR_task311 
wave 
wave -noreg X
wave -noreg Y
wave -noreg Z
wave -noreg F
wave -noreg G
run 1200.00 ns
# The following lines can be used for timing simulation
# acom <backannotated_vhdl_file_name>
# comp -include "$dsn\src\TestBench\task311_TB_tim_cfg.vhd" 
# asim +access +r TIMING_FOR_task311 
