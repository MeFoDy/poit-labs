SetActiveLib -work
comp -include "$dsn\src\summ2.vhd" 
comp -include "$dsn\src\TestBench\summ2_TB.vhd" 
asim +access +r TESTBENCH_FOR_summ2 
wave 
wave -noreg a
wave -noreg b
wave -noreg n
wave -noreg s
wave -noreg p
run 3200.00 ns
# The following lines can be used for timing simulation
# acom <backannotated_vhdl_file_name>
# comp -include "$dsn\src\TestBench\summ2_TB_tim_cfg.vhd" 
# asim +access +r TIMING_FOR_summ2 
