project new BistableElement.xise
project set family "Artix7"
project set device xc7a100t
project set package csg324
project set speed -3
project set top_level_module_type HDL
project set synthesis_tool "XST (VHDL/Verilog)"
lib_vhdl new "Lab03"
xfile add "I:/Embedded/_Projects/POCP/Lab03/Lab03/src/Inv.vhd" -lib_vhdl "Lab03"
xfile add "I:/Embedded/_Projects/POCP/Lab03/Lab03/src/NOR2.vhd" -lib_vhdl "Lab03"
xfile add "I:/Embedded/_Projects/POCP/Lab03/Lab03/src/AND2.vhd" -lib_vhdl "Lab03"
xfile add "I:/Embedded/_Projects/POCP/Lab03/Lab03/src/Task1/BistableElement.vhd" -lib_vhdl "Lab03"
xfile add "I:/Embedded/_Projects/POCP/Lab03/Lab03/src/Task2/RS_Latch_Param.vhd" -lib_vhdl "Lab03"
xfile add "I:/Embedded/_Projects/POCP/Lab03/Lab03/src/Task2/RS_Latch.vhd" -lib_vhdl "Lab03"
xfile add "I:/Embedded/_Projects/POCP/Lab03/Lab03/src/Task3/D_Latch_Param.vhd" -lib_vhdl "Lab03"
xfile add "I:/Embedded/_Projects/POCP/Lab03/Lab03/src/Task3/D_Latch.vhd" -lib_vhdl "Lab03"
project set top Struct BistableElement
project set "Preferred Language" VHDL
project set "Simulation Model Target" VHDL -process "Implement Design"
project set "Macro Search Path" "" -process "Implement Design"
project close
