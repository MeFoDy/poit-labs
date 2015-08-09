cd E:/Embedded/Projects/POCP/Lab06/synthesis
project -new dummy
foreach prj [project -list] {
	project -close [project -name]
}
project -load command2.prj
project -run syntax_check
open_file -rtl_view
