library IEEE;
use IEEE.STD_LOGIC_1164.all; 

entity RegN is
	generic (
		INITREG: std_logic_vector := "1001");
	port (
		Din: in std_logic_vector (INITREG'range);
		EN: in std_logic;
		INIT: in std_logic;
		CLK: in std_logic;
		OE: 	in std_logic;
		Dout: out std_logic_vector(INITREG'range));
end RegN;

architecture Beh of RegN is
	signal reg: std_logic_vector(INITREG'range);
	constant ALLZ: std_logic_vector(INITREG'range) := (others => 'Z');
Begin
	Main: process (Din, En, Init, CLK)
	begin
		if INIT = '1' then
			reg <= INITREG;
		elsif EN = '1' then
			if rising_edge(CLK)	then
				reg <= Din;
			end if;
		end if;
	end process;
	Dout <= reg when OE = '1' else ALLZ;
end Beh;