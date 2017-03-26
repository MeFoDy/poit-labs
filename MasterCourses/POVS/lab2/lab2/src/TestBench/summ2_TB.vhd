library ieee;
use ieee.std_logic_1164.all;

	-- Add your library and packages declaration here ...

entity summ2_tb is
end summ2_tb;

architecture TB_ARCHITECTURE of summ2_tb is
	-- Component declaration of the tested unit
	component summ2
	port(
		a : in STD_LOGIC_VECTOR(1 downto 0);
		b : in STD_LOGIC_VECTOR(1 downto 0);
		n : in STD_LOGIC;
		s : out STD_LOGIC_VECTOR(1 downto 0);
		p : out STD_LOGIC );
	end component;

	-- Stimulus signals - signals mapped to the input and inout ports of tested entity
	signal a : STD_LOGIC_VECTOR(1 downto 0);
	signal b : STD_LOGIC_VECTOR(1 downto 0);
	signal n : STD_LOGIC;
	-- Observed signals - signals mapped to the output ports of tested entity
	signal s : STD_LOGIC_VECTOR(1 downto 0);
	signal p : STD_LOGIC;	
	signal s1 : STD_LOGIC_VECTOR(1 downto 0);
	signal p1 : STD_LOGIC;
	signal error : std_logic;

	-- Add your code here ...

begin

	-- Unit Under Test port map
	UUT : summ2
		port map (
			a => a,
			b => b,
			n => n,
			s => s,
			p => p
		);
	UUT2 : summ2
		port map (
			a => a,
			b => b,
			n => n,
			s => s1,
			p => p1
		);

	--Below VHDL code is an inserted .\compile\summ2.vhs
	--User can modify it ....

STIMULUS: process
begin  -- of stimulus process
--wait for <time to next event>; -- <current time>

	b <= "00";
	a <= "00";
	n <= '0';
    wait for 50 ns; --0 fs
	a <= "10";
    wait for 50 ns; --50 ns
	a <= "01";
    wait for 50 ns; --100 ns
	a <= "11";
    wait for 50 ns; --150 ns
	b <= "10";
	a <= "00";
    wait for 50 ns; --200 ns
	a <= "10";
    wait for 50 ns; --250 ns
	a <= "01";
    wait for 50 ns; --300 ns
	a <= "11";
    wait for 50 ns; --350 ns
	b <= "01";
	a <= "00";
    wait for 50 ns; --400 ns
	a <= "10";
    wait for 50 ns; --450 ns
	a <= "01";
    wait for 50 ns; --500 ns
	a <= "11";
    wait for 50 ns; --550 ns
	b <= "11";
	a <= "00";
    wait for 50 ns; --600 ns
	a <= "10";
    wait for 50 ns; --650 ns
	a <= "01";
    wait for 50 ns; --700 ns
	a <= "11";
    wait for 50 ns; --750 ns
	b <= "00";
	a <= "00";
	n <= '1';
    wait for 50 ns; --800 ns
	a <= "10";
    wait for 50 ns; --850 ns
	a <= "01";
    wait for 50 ns; --900 ns
	a <= "11";
    wait for 50 ns; --950 ns
	b <= "10";
	a <= "00";
    wait for 50 ns; --1 us
	a <= "10";
    wait for 50 ns; --1050 ns
	a <= "01";
    wait for 50 ns; --1100 ns
	a <= "11";
    wait for 50 ns; --1150 ns
	b <= "01";
	a <= "00";
    wait for 50 ns; --1200 ns
	a <= "10";
    wait for 50 ns; --1250 ns
	a <= "01";
    wait for 50 ns; --1300 ns
	a <= "11";
    wait for 50 ns; --1350 ns
	b <= "11";
	a <= "00";
    wait for 50 ns; --1400 ns
	a <= "10";
    wait for 50 ns; --1450 ns
	a <= "01";
    wait for 50 ns; --1500 ns
	a <= "11";
    wait for 50 ns; --1550 ns
	b <= "00";
	a <= "00";
	n <= '0';
    wait for 50 ns; --1600 ns
	a <= "10";
    wait for 50 ns; --1650 ns
	a <= "01";
    wait for 50 ns; --1700 ns
	a <= "11";
    wait for 50 ns; --1750 ns
	b <= "10";
	a <= "00";
    wait for 50 ns; --1800 ns
	a <= "10";
    wait for 50 ns; --1850 ns
	a <= "01";
    wait for 50 ns; --1900 ns
	a <= "11";
    wait for 50 ns; --1950 ns
	b <= "01";
	a <= "00";
    wait for 50 ns; --2 us
	a <= "10";
    wait for 50 ns; --2050 ns
	a <= "01";
    wait for 50 ns; --2100 ns
	a <= "11";
    wait for 50 ns; --2150 ns
	b <= "11";
	a <= "00";
    wait for 50 ns; --2200 ns
	a <= "10";
    wait for 50 ns; --2250 ns
	a <= "01";
    wait for 50 ns; --2300 ns
	a <= "11";
    wait for 50 ns; --2350 ns
	b <= "00";
	a <= "00";
	n <= '1';
    wait for 50 ns; --2400 ns
	a <= "10";
    wait for 50 ns; --2450 ns
	a <= "01";
    wait for 50 ns; --2500 ns
	a <= "11";
    wait for 50 ns; --2550 ns
	b <= "10";
	a <= "00";
    wait for 50 ns; --2600 ns
	a <= "10";
    wait for 50 ns; --2650 ns
	a <= "01";
    wait for 50 ns; --2700 ns
	a <= "11";
    wait for 50 ns; --2750 ns
	b <= "01";
	a <= "00";
    wait for 50 ns; --2800 ns
	a <= "10";
    wait for 50 ns; --2850 ns
	a <= "01";
    wait for 50 ns; --2900 ns
	a <= "11";
    wait for 50 ns; --2950 ns
	b <= "11";
	a <= "00";
    wait for 50 ns; --3 us
	a <= "10";
    wait for 50 ns; --3050 ns
	a <= "01";
    wait for 50 ns; --3100 ns
	a <= "11";
    wait for 50 ns; --3150 ns
	b <= "00";
	a <= "00";
	n <= '0';
--	end of stimulus events
	wait;
end process; -- end of stimulus process
	
	error <= (p1 xor p) or (s1(0) xor s(0)) or (s1(1) xor s(1));

end TB_ARCHITECTURE;

configuration TESTBENCH_FOR_summ2 of summ2_tb is
	for TB_ARCHITECTURE
		for UUT : summ2
			use entity work.summ2(behavioral);
		end for;
		for UUT2 : summ2
			use entity work.summ2(structural);
		end for;
	end for;
end TESTBENCH_FOR_summ2;

