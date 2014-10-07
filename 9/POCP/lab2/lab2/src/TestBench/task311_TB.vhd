library ieee;
use ieee.std_logic_1164.all;

	-- Add your library and packages declaration here ...

entity task311_tb is
end task311_tb;

architecture TB_ARCHITECTURE of task311_tb is
	-- Component declaration of the tested unit
	component task311
	port(
		X : in STD_LOGIC;
		Y : in STD_LOGIC;
		Z : in STD_LOGIC;
		F : out STD_LOGIC;
		G : out STD_LOGIC );
	end component;

	-- Stimulus signals - signals mapped to the input and inout ports of tested entity
	signal X : STD_LOGIC;
	signal Y : STD_LOGIC;
	signal Z : STD_LOGIC;
	-- Observed signals - signals mapped to the output ports of tested entity
	signal F, F1 : STD_LOGIC;
	signal G, G1, error : STD_LOGIC;

	-- Add your code here ...

begin

	-- Unit Under Test port map
	UUT : task311
		port map (
			X => X,
			Y => Y,
			Z => Z,
			F => F,
			G => G
		); 
		UUT2 : task311
		port map (
			X => X,
			Y => Y,
			Z => Z,
			F => F1,
			G => G1
		);

	--Below VHDL code is an inserted .\compile\task.vhs
	--User can modify it ....

STIMULUS: process
begin  -- of stimulus process
--wait for <time to next event>; -- <current time>

	Y <= '0';
	Z <= '0';
	X <= '0';
    wait for 50 ns; --0 fs
	X <= '1';
    wait for 50 ns; --50 ns
	Y <= '1';
	X <= '0';
    wait for 50 ns; --100 ns
	X <= '1';
    wait for 50 ns; --150 ns
	Y <= '0';
	Z <= '1';
	X <= '0';
    wait for 50 ns; --200 ns
	X <= '1';
    wait for 50 ns; --250 ns
	Y <= '1';
	X <= '0';
    wait for 50 ns; --300 ns
	X <= '1';
    wait for 50 ns; --350 ns
	Y <= '0';
	Z <= '0';
	X <= '0';
    wait for 50 ns; --400 ns
	X <= '1';
    wait for 50 ns; --450 ns
	Y <= '1';
	X <= '0';
    wait for 50 ns; --500 ns
	X <= '1';
    wait for 50 ns; --550 ns
	Y <= '0';
	Z <= '1';
	X <= '0';
    wait for 50 ns; --600 ns
	X <= '1';
    wait for 50 ns; --650 ns
	Y <= '1';
	X <= '0';
    wait for 50 ns; --700 ns
	X <= '1';
    wait for 50 ns; --750 ns
	Y <= '0';
	Z <= '0';
	X <= '0';
    wait for 50 ns; --800 ns
	X <= '1';
    wait for 50 ns; --850 ns
	Y <= '1';
	X <= '0';
    wait for 50 ns; --900 ns
	X <= '1';
    wait for 50 ns; --950 ns
	Y <= '0';
	Z <= '1';
	X <= '0';
    wait for 50 ns; --1 us
	X <= '1';
    wait for 50 ns; --1050 ns
	Y <= '1';
	X <= '0';
    wait for 50 ns; --1100 ns
	X <= '1';
    wait for 50 ns; --1150 ns
	Y <= '0';
	Z <= '0';
	X <= '0';
--	end of stimulus events
	wait;
end process; -- end of stimulus process
	


	error <= (f1 xor f) or (g1 xor g);
	-- Add your stimulus here ...

end TB_ARCHITECTURE;

configuration TESTBENCH_FOR_task311 of task311_tb is
	for TB_ARCHITECTURE
		for UUT : task311
			use entity work.task311(behavioral);
		end for;	
		for UUT2 : task311
			use entity work.task311(structural);
		end for;
	end for;
end TESTBENCH_FOR_task311;

