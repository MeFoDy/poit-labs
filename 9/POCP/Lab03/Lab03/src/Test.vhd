library ieee;
use ieee.std_logic_1164.all;

-- Add your library and packages declaration here ...

entity rslatch_tb is
end rslatch_tb;

architecture TB_ARCHITECTURE of rslatch_tb is
	-- Component declaration of the tested unit
	component rs_latch_param
		port(
			S : in STD_LOGIC;
			R : in STD_LOGIC;
			Q : out STD_LOGIC;
			nQ : out STD_LOGIC );
	end component;
	
	-- Stimulus signals - signals mapped to the input and inout ports of tested entity
	signal S : STD_LOGIC;
	signal R : STD_LOGIC;
	-- Observed signals - signals mapped to the output ports of tested entity
	signal Q : STD_LOGIC;
	signal nQ : STD_LOGIC;
	
	-- Add your code here ...
	
begin
	
	-- Unit Under Test port map
	UUT : rs_latch_param
	port map (
		S => S,
		R => R,
		Q => Q,
		nQ => nQ
		);
		
	process
	begin  	   
		S <= '0'; 
		wait for 10ns; 
		S <= '1'; 
		wait for 10ns; 
	end process; 
	
	process
	begin  	   
		R <= '0'; 
		wait for 20ns; 
		R <= '1'; 
		wait for 20ns; 
	end process;
	-- Add your stimulus here ...
	
end TB_ARCHITECTURE;

configuration TESTBENCH_FOR_rslatch of rslatch_tb is
	for TB_ARCHITECTURE
		for UUT : rs_latch_param
			use entity work.rs_latch_param(struct);
		end for;
	end for;
end TESTBENCH_FOR_rslatch;

