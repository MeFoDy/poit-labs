source "C:/Users/Raman But-Husaim/AppData/Local/Synplicity/scm_perforce.tcl"
history clear
run_tcl -fg e:/Embedded/Projects/POCP/Lab06/synthesis/load_view.tcl
impl -add RAM RegFile -type fpga
set_option -technology Spartan2
set_option -top_module Lab06.RAM
project -run  -bg 
impl -add LIFO RAM -type fpga
set_option -result_file E:/Embedded/Projects/POCP/Lab06/synthesis/LIFO/LIFO.edf
set_option -top_module Lab06.LIFO
impl -active RAM
set_option -result_file E:/Embedded/Projects/POCP/Lab06/synthesis/RAM/RAM.edf
project -save E:/Embedded/Projects/POCP/Lab06/synthesis/command2.prj 
impl -active LIFO
project -run  -bg 
impl -add RAM_Ham LIFO -type fpga
set_option -result_file E:/Embedded/Projects/POCP/Lab06/synthesis/RAM_Ham/RAM_Ham.edf
set_option -top_module Lab06.RAM_Ham
project -run  -bg 
project -save E:/Embedded/Projects/POCP/Lab06/synthesis/command2.prj 
impl -active RegFile
project -close E:/Embedded/Projects/POCP/Lab06/synthesis/command2.prj
