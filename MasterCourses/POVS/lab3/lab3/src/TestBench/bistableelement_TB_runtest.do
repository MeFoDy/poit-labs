SetActiveLib -work
comp -include "$dsn\src\1\BiStableElement.vhd" 
comp -include "$dsn\src\TestBench\bistableelement_TB.vhd" 
asim +access +r TESTBENCH_FOR_bistableelement 
wave 
wave -noreg Q
wave -noreg nQ
# The following lines can be used for timing simulation
# acom <backannotated_vhdl_file_name>
# comp -include "$dsn\src\TestBench\bistableelement_TB_tim_cfg.vhd" 
# asim +access +r TIMING_FOR_bistableelement 
