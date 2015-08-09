library ieee;
use ieee.std_logic_1164.all;

entity LFSR_In is
	generic (i:integer := 2);
	port(
		CLK: in std_logic;
		RST: in std_logic;
		LS: in std_logic;
		Pin: in std_logic_vector(0 to 2**i-1);
		Pout: out std_logic_vector(0 to 2**i-1)
		);
end LFSR_In;

architecture Beh of LFSR_In is
	signal sreg: std_logic_vector(0 to 2**i-1);
	signal sdat: std_logic_vector(0 to 2**i-1);
	signal buf: std_logic;
Begin
	Main: process (CLK, RST, sdat)
	begin
		if RST = '1' then
			sreg <= (others => '0');
		elsif rising_edge(CLK) then
			sreg <= sdat;
		end if;
	end process;
	
	Data: process (LS, Pin, sreg)
	begin
		if LS = '0' then
			sdat <= Pin;
		else
			buf <= sreg(0) xor sreg(2**i-1);
			sdat <= sreg(2**i-1) & sreg(0 to 2**i-2);
			sdat(2) <= buf;
		end if;
	end process;
	
	Pout <= sreg;
End Beh;