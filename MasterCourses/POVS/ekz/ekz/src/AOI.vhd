library IEEE;
use IEEE.std_logic_1164.all;

entity AOI is 
	port (
		a, b, c, d : in std_logic;
		f : out std_logic
		);
end AOI;

architecture v1 of AOI is
begin
	f <= not ((a and b) or (c and d));
end v1;

architecture v2 of AOI is
	signal ab, cd, o : std_logic;
begin
	ab <= a and b after 2ns;
	cd <= c and d after 2ns;
	o <= ab or cd after 2ns;
	f <= not o after 1ns;
end v2;							  

library IEEE;
use IEEE.std_logic_1164.all;

entity mux2 is																
	port(																	
		sel, a, b: in STD_LOGIC;
		f: out std_logic);
end mux2;

architecture m1 of mux2 is
	
	component INV
		port(a: in std_logic; f : out std_logic);
	end component;
	
	component AOI 
		port (
			a, b, c, d : in std_logic;
			f : out std_logic
			); 
	end component;
	
	signal selB : std_logic;
begin
	
	g1: INV port map (sel, selB);
	g2: AOI port map (sel, a, selB, b, f);
	
end m1;


library IEEE;
use IEEE.std_logic_1164.all;

entity D_FF is
	port(D, clk: in bit; Q: out bit);
end entity D_FF;

architecture F of D_FF is
begin	
	process (clk) begin
		if clk = '1' and clk'Event
			then Q<=D;
		end if;
	end process;
end architecture F;
