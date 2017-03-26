library ieee;
use ieee.std_logic_1164.all;

	-- Add your library and packages declaration here ...

entity bistableelement_tb is
end bistableelement_tb;

architecture TB_ARCHITECTURE of bistableelement_tb is
	-- Component declaration of the tested unit
	component bistableelement
	port(
		Q : out STD_LOGIC;
		nQ : out STD_LOGIC );
	end component;

	-- Stimulus signals - signals mapped to the input and inout ports of tested entity
	-- Observed signals - signals mapped to the output ports of tested entity
	signal Q : STD_LOGIC;
	signal nQ : STD_LOGIC;

	-- Add your code here ...

begin

	-- Unit Under Test port map
	UUT : bistableelement
		port map (
			Q => Q,
			nQ => nQ
		);

	-- Add your stimulus here ...

end TB_ARCHITECTURE;

configuration TESTBENCH_FOR_bistableelement of bistableelement_tb is
	for TB_ARCHITECTURE
		for UUT : bistableelement
			use entity work.bistableelement(bistableelement);
		end for;
	end for;
end TESTBENCH_FOR_bistableelement;

